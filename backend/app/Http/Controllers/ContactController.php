<?php

namespace App\Http\Controllers;

use App\Models\Funnel;
use Illuminate\Http\Request;
use App\Models\Contacts;

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

    public function averageValueInStage($funnelId, $stageId)
    {
        $average = Contacts::whereHas('stages', function ($query) use ($stageId) {
                        $query->where('id', $stageId);
                    })
                    ->avg('buyValue');

        return response()->json(['buyValue' => $average]);
    }


}
