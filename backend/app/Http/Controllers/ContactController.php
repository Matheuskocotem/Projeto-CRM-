<?php

namespace App\Http\Controllers;

use App\Models\Funnel;
use Illuminate\Http\Request;
use App\Models\Contacts;
Use App\Models\Stage;

class ContactController extends Controller
{
    public function index($funnel_id)
    {
        $contacts = Contacts::where('funnel_id', $funnel_id)
                            ->orderBy('position')
                            ->get();
        return response()->json($contacts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'funnel_id' => 'required|exists:funnel,id',
            'stage_id' => 'required|exists:stages,id',
            'email' => 'required|email|max:255',
            'phoneNumber' => 'required|string|max:20',
            'dateOfBirth' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'buyValue' => 'nullable|numeric',
        ]);
    
        if ($request->stage_id === null) {
            $request->stage_id = 1;
        }
    
        if ($request->buyValue === null) {
            $request->buyValue = 0.00;
        }
    
        $contact = Contacts::create([
            'name' => $request->name,
            'stage_id' => $request->stage_id,
            'funnel_id' => $request->funnel_id,
            'phoneNumber' => $request->phoneNumber,
            'email' => $request->email,
            'dateOfBirth' => $request->dateOfBirth,
            'address' => $request->address,
            'buyValue' => $request->buyValue
        ]);
    
        return response()->json([
            'id' => $contact->id,
            'contact' => $contact
        ], 201);
    }


    public function show(Contacts $contact)
    {
        return response()->json($contact);
    }

    public function update(Request $request, $funnel_id, $contact_id)
    {   
        $request->validate([
            'name' => 'nullable|string',
            'email' => 'nullable|email',
            'phoneNumber' => 'nullable|string',
            'dateOfBirth' => 'nullable|date',
            'address' => 'nullable|string',
            'buyValue' => 'nullable|numeric',
            'funnel_id' => 'required|exists:funnel,id',
            'stage_id' => 'required|exists:stages,id',
        ]);
    
        $contact = Contacts::where('id', $contact_id)
                           ->where('funnel_id', $funnel_id)
                           ->first();
    
        if (!$contact) {
            return response()->json([
                'message' => 'Contato não encontrado'
            ], 404);
        }
    
        $contact->update([
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
            'message' => 'Contato atualizado com sucesso',
            'data' => $contact
        ], 200);
    }

    public function destroy($id_funnel, $id_contact)
    {
        $contact = Contacts::where('id', $id_contact)
                           ->where('funnel_id', $id_funnel)
                           ->first();

        if ($contact) {
            $contact->delete();
            return response()->json(['message' => 'Contato não deletado'], 204);
        } else {
            return response()->json(['error' => 'Contato não encontrado'], 404);
        }
    }
    
    public function swap(Request $request, $stage_id)
    {
        
        $request->validate([
            'position' => 'required|integer'
        ]);
    
        $contato = Contacts::where('stage_id', $stage_id)->first();
        if (!$contato) {
            return response()->json(['error' => 'Contato não encontrado.'], 404);
        }
        $current_position = $contato->position;
        $new_position = $request->position;
    
        if ($new_position == $current_position) {
            return response()->json(['message' => 'A nova posição é igual à posição atual.'], 200);
        }
        if ($new_position > $current_position) {
            Contacts::where('stage_id', $stage_id)
                ->whereBetween('position', [$current_position + 1, $new_position])
                ->increment('position');
        } elseif ($new_position < $current_position) {
            Contacts::where('stage_id', $stage_id)
                ->whereBetween('position', [$new_position, $current_position - 1])
                ->decrement('position');
        }

        $contato->position = $new_position;
        $contato->save();
    
        return response()->json($contato, 200);
    }
    



    public function swapPhase(Request $request)
    {
        $request->validate([
            'new_position' => 'required|integer',
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