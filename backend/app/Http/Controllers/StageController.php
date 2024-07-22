<?php

namespace App\Http\Controllers;

use App\Models\Contacts;
use Illuminate\Http\Request;
use App\Models\Stage;
use App\Models\Funnel;

class StageController extends Controller
{
    public function index(Request $request, Funnel $funnel)
    {
        $stages = $funnel->stages()->orderBy('order')->get();
        return response()->json($stages);
    }
    
    public function store(Request $request, $funnel_id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'order' => 'required|integer',
        ]);

        $funnel = Funnel::findOrFail($funnel_id);

        $stage = new Stage([
            'name' => $validatedData['name'],
            'order' => $validatedData['order'],
        ]);

        $funnel->stages()->save($stage);

        return response()->json($stage, 201);
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'contact_id' => 'required|integer',
            'new_order' => 'required|integer',
            'new_stage_id' => 'nullable|integer', 
        ]);
    
        $contactId = $request->contact_id;
        $newOrder = $request->new_order;
        $newStageId = $request->new_stage_id;
    
        $contact = Contacts::findOrFail($contactId);
    
        if ($newStageId && $newStageId != $contact->stage_id) {
            $newStage = Stage::findOrFail($newStageId);
    
            Contacts::where('stage_id', $newStage->id)
                ->where('order', '>=', $newOrder)
                ->increment('order');
    
            $contact->stage_id = $newStageId;
        } else {
            
            Contacts::where('stage_id', $contact->stage_id)
                ->where('order', '>=', $newOrder)
                ->where('id', '!=', $contactId)
                ->increment('order');
        }
    
        $contact->order = $newOrder;
        $contact->save();
    
        return response()->json($contact, 200);
    }
    

    public function destroy(Request $request, Funnel $funnel, Stage $stage)
    {
        $stage->delete();

        return response()->json(['message' => 'etapa deletada'], 200);
    }

    public function averageContactsValue($funnelId, $stageId)
    {
        $average = Contacts::where('stage_id', $stageId)
            ->avg('buyValue');

        return response()->json(['average_value' => $average]);
    }

}
