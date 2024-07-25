<?php

namespace App\Http\Controllers;

use App\Models\Funnel;
use Illuminate\Http\Request;
use App\Models\Contacts;
Use App\Models\Stage;

class ContactController extends Controller
{
    public function index()
    {
        return response()->json(Contacts::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'funnel_id' => 'required|exists:funnel,id',
            'stage_id' => 'required|exists:stages,id',
            'email' => 'required|email',
            'phoneNumber' => 'required|string',
            'dateOfBirth' => 'nullable|date',
            'address' => 'nullable|string',
            'buyValue' => 'nullable|numeric',   
        ]);

        $contact = Contacts::create([
            'name' => $request->name,
            'funnel_id' => $request->funnel_id,
            'stage_id' => $request->stage_id,
            'email' => $request->email,
            'phoneNumber' => $request->phoneNumber,
            'dateOfBirth' => $request->dateOfBirth,
            'address' => $request->address,
            'buyValue' => $request->buyValue,
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

    public function update(Request $request, Contacts $contact)
    {
        $request->validate([
            'name' => 'required|string',
            'funnel_id' => 'required|exists:funnel,id',
            'stage_id' => 'required|exists:stages,id',
            'email' => 'required|email',
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

    public function swap($newPosition, $stage_id, $contact_id)
{
    $contact = Contacts::findOrFail($contact_id);
    $position = $contact->position;
    
    $contactsInStage = Contacts::where('stage_id', $stage_id)
        ->orderBy('position')
        ->get();

    if ($newPosition == $position) {
        return response()->json(['message' => 'A nova posição é igual à posição atual.'], 200);
    }

    foreach ($contactsInStage as $contactInStage) {
        if ($contactInStage->position == $newPosition) {
            $contactInStage->position = $position;
            $contactInStage->save();
            break;
        } elseif ($position < $newPosition && $contactInStage->position > $position && $contactInStage->position <= $newPosition) {
            $contactInStage->position--;
            $contactInStage->save();
        } elseif ($position > $newPosition && $contactInStage->position < $position && $contactInStage->position >= $newPosition) {
            $contactInStage->position++;
            $contactInStage->save();
        }
    }

    $contact->position = $newPosition;
    $contact->save();
    
    return response()->json(['message' => 'Posição alterada com sucesso.'], 200);
}

public function swapPhase($contact_id, $newPosition, $new_stage_id)
{
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

    public function search(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $name = $request->input('name');
        $contacts = Contacts::where('name', 'LIKE', "%{$name}%")->get();

        if ($contacts->isEmpty()) {
            return response()->json(['message' => 'Contato não encontrado'], 404);
        }

        return response()->json($contacts);
    }

}