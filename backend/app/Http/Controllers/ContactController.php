<?php

namespace App\Http\Controllers;

use App\Models\Funnel;
use Illuminate\Http\Request;
use App\Models\Contacts;
Use App\Models\Stage;

class ContactController extends Controller
{
    public function index($funnel_id, $stage_id)
    {
        $contacts = Contacts::where('funnel_id', $funnel_id)
                            ->where('stage_id', $stage_id)
                            ->orderBy('position')
                            ->get();
        return response()->json($contacts);
    }

    public function store(Request $request, $funnel_id, $stage_id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phoneNumber' => 'required|string',
            'dateOfBirth' => 'nullable|string',
            'address' => 'nullable|string',
            'buyValue' => 'nullable|numeric',   
        ]);

        $nextPosition = Contacts::getNextPosition($request->stage_id);

        $contact = Contacts::create([
            'name' => $request->name,
            'funnel_id' => $funnel_id,
            'stage_id' => $stage_id,
            'email' => $request->email,
            'phoneNumber' => $request->phoneNumber,
            'dateOfBirth' => $request->dateOfBirth,
            'address' => $request->address,
            'buyValue' => $request->buyValue,
            'position' => $nextPosition,
        ]);

        return response()->json([
            'message' => 'Contato criado com sucesso',
            'data' => $contact
        ], 201);
    }

    public function show(Contacts $contact)
    {
        return response()->json($contact);
    }

    public function update(Request $request, $funnel_id, $stage_id, Contacts $contact)
    {
        $request->validate([
            'name' => 'nullable|string',
            'email' => 'nullable|email',
            'phoneNumber' => 'nullable|string',
            'dateOfBirth' => 'nullable|date',
            'address' => 'nullable|string',
            'buyValue' => 'nullable|numeric',
        ]);

        $contact->update($request->all());

        return response()->json([
            'message' => 'Contato atualizado com sucesso',
            'data' => $contact
        ], 200);
    }

    public function destroy(Contacts $contact)
    {
        $contact->delete();

        return response()->json(['message' => 'Contato apagado com sucesso'], 204);

    }

    public function swap(Request $request)
{
    $request->validate([
        'newPosition' => 'required|integer',
        'stage_id' => 'required|exists:stages,id',
    ]);

    $newPosition = $request->newPosition;
    $stage_id = $request->stage_id;
    $contact_id = $request->contact_id;

    $contact = Contacts::findOrFail($contact_id);
    $currentPosition = $contact->position;

    if ($newPosition == $currentPosition) {
        return response()->json(['message' => 'A nova posição é igual à posição atual.'], 200);
    }

 
    $contactsInStage = Contacts::where('stage_id', $stage_id)
        ->orderBy('position')
        ->get();

    foreach ($contactsInStage as $contactInStage) {
        if ($contactInStage->position == $newPosition) {
            $contactInStage->position = $currentPosition;
            $contactInStage->save();
            break;
        } elseif ($currentPosition < $newPosition && $contactInStage->position > $currentPosition && $contactInStage->position <= $newPosition) {
            $contactInStage->position--;
            $contactInStage->save();
        } elseif ($currentPosition > $newPosition && $contactInStage->position < $currentPosition && $contactInStage->position >= $newPosition) {
            $contactInStage->position++;
            $contactInStage->save();
        }
    }

    $contact->position = $newPosition;
    $contact->save();

    return response()->json(['message' => 'Posição alterada com sucesso.'], 200);
}


    public function swapPhase(Request $request)
    {
        $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'newPosition' => 'required|integer',
            'new_stage_id' => 'required|exists:stages,id',
        ]);

        $contact_id = $request->contact_id;
        $newPosition = $request->newPosition;
        $new_stage_id = $request->new_stage_id;

        $contact = Contacts::findOrFail($contact_id);
        $position = $contact->position;

        $contactsInCurrentStage = Contacts::where('stage_id', $contact->stage_id)
            ->orderBy('position')
            ->get();

        $contactsInNewStage = Contacts::where('stage_id', $new_stage_id)
            ->orderBy('position')
            ->get();

        foreach ($contactsInCurrentStage as $contactInCurrentStage) {
            if ($contactInCurrentStage->position > $position) {
                $contactInCurrentStage->position--;
                $contactInCurrentStage->save();
            }
        }

        $newPosition = $contactsInNewStage->count() + 1;
        
        foreach ($contactsInNewStage as $contactInNewStage) {
            if ($contactInNewStage->position >= $newPosition) {
                $contactInNewStage->position++;
                $contactInNewStage->save();
            }
        }
        
        $contact->stage_id = $new_stage_id;
        $contact->position = $newPosition;
        $contact->save();
        
        return response()->json(['message' => 'Fase alterada com sucesso.'], 200);
    }




    public function averageValueInStage($funnelId, $stageId)
    {
        $average = Contacts::whereHas('stages', function ($query) use ($stageId) {
                        $query->where('id', $stageId);
                    })
                    ->avg('buyValue');

        return response()->json(['buyValue' => $average]);
    }

    public function search(Request $request, $funnel_id, $stage_id)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $name = $request->input('name');
        $contacts = Contacts::where('funnel_id', $funnel_id)
                            ->where('stage_id', $stage_id)
                            ->where('name', 'LIKE', "%{$name}%")
                            ->get();

        if ($contacts->isEmpty()) {
            return response()->json(['message' => 'Contato não encontrado'], 404);
        }

        return response()->json($contacts);
    }

}