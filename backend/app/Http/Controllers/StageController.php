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
