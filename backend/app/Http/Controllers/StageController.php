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
        $oldOrder = $contact->order;
        $oldStageId = $contact->stage_id;
    
        $matriz = [
            'horizontal' => [],
            'vertical' => []
        ];
    
        if ($newStageId && $newStageId != $oldStageId) {
            $newStage = Stage::findOrFail($newStageId);
    
            $newContacts = Contacts::where('stage_id', $newStage->id)
                ->where('order', '>=', $newOrder)
                ->get();
            foreach ($newContacts as $newContact) {
                $newContact->order++;
                $matriz['vertical'][] = $newContact; 
            }
    
            $oldContacts = Contacts::where('stage_id', $oldStageId)
                ->where('order', '>', $oldOrder)
                ->get();
            foreach ($oldContacts as $oldContact) {
                $oldContact->order--;
                $matriz['vertical'][] = $oldContact; 
            }
    
            $contact->stage_id = $newStageId;
        } else {
            if ($oldOrder != $newOrder) {
                $contacts = Contacts::where('stage_id', $oldStageId)->orderBy('order')->get();
                foreach ($contacts as $currentContact) {
                    if ($currentContact->order > $oldOrder && $currentContact->order <= $newOrder) {
                        $currentContact->order--;
                        $matriz['horizontal'][] = $currentContact; 
                    } elseif ($currentContact->order >= $newOrder && $currentContact->order < $oldOrder) {
                        $currentContact->order++;
                        $matriz['horizontal'][] = $currentContact; 
                    }
                }
            }
        }

        $contact->order = $newOrder;
        if ($newStageId && $newStageId != $oldStageId) {
            $matriz['vertical'][] = $contact; 
        } else {
            $matriz['horizontal'][] = $contact; 
        }
    
        foreach ($matriz['horizontal'] as $update) {
            $update->save();
        }
    

        foreach ($matriz['vertical'] as $update) {
            $update->save();
        }
    
        return response()->json($contact, 200);
    }
    
    

    public function destroy(Request $request, Funnel $funnel, Stage $stage)
    {
        $stage->delete();

        return response()->json(['message' => 'etapa deletada'], 200);
    }

    public function totalContactsValue($funnelId)
{
    $funnel = Funnel::with('stages.contacts')->findOrFail($funnelId);
    $totalValue = 0;
  
    foreach ($funnel->stages as $stage) {
        foreach ($stage->contacts as $contact) {
            $totalValue += $contact->buyValue;
        }
    }
    return response()->json(['total_value' => $totalValue]);
}

}
