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

    public function destroy(Request $request, Funnel $funnel, Stage $stage)
    {
        $stage->delete();

        return response()->json(['message' => 'etapa deletada'], 200);
    }

    public function updateOrder(Request $request, $funnel_id, $stage_id)
    {
        $request->validate([
            'order' => 'required|integer|min:1',
        ]);
    
        $stage = Stage::where('id', $stage_id)
            ->where('funnel_id', $funnel_id)
            ->firstOrFail();
    
        $newOrder = $request->input('order');
        
        if ($newOrder == $stage->order) {
            return response()->json(['message' => 'A nova ordem é igual à ordem atual.'], 200);
        }
    
        if ($newOrder < $stage->order) {
            Stage::where('funnel_id', $funnel_id)
                ->whereBetween('order', [$newOrder, $stage->order - 1])
                ->increment('order');
        } else {
            Stage::where('funnel_id', $funnel_id)
                ->whereBetween('order', [$stage->order + 1, $newOrder])
                ->decrement('order');
        }
    
        $stage->order = $newOrder;
        $stage->save();
    
        return response()->json(['message' => 'Ordem alterada com sucesso.'], 200);
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
    return response()->json([
        'total_value' => $totalValue
        // 'quantidade_contatos' =>
        // 'finalizados' =>
    ]);
}

}
