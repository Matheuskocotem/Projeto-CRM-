<?php

namespace App\Http\Controllers;

use App\Models\Contacts;
use Illuminate\Http\Request;
use App\Models\Stage;
use App\Models\Funnel;
use Illuminate\Support\Facades\Auth;


class StageController extends Controller
{
    public function index(Request $request, $funnel_id)
    {
        $funnel = Funnel::findOrFail($funnel_id);
        $stages = $funnel->stages()->orderBy('order')->get()->toArray();
        return response()->json($stages, 200,['message' => 'Sucesso ao buscar as etapas']);
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

    public function update(Request $request, Funnel $funnel, Stage $stage){
        $validatedData = $request->validate([
            'name' => 'sometimes|string',
            'order' => 'sometimes|integer',
        ]);

        $stage->update([
            'name' => $validatedData['name'],
            'order' => $validatedData['order'],
        ]);

        return response()->json($stage, 200);
    }

    public function destroy(Request $request, $funnelId, $stageId)
    {
        $funnel = Funnel::where('user_id', Auth::id())->where('id', $funnelId)->firstOrFail();
        
        $stage = Stage::where('funnel_id', $funnelId)->where('id', $stageId)->firstOrFail();
        
        $stage->delete();
    
        return response()->json(['message' => 'Estágio excluído com sucesso'], 204);
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
    ]);
}

}
