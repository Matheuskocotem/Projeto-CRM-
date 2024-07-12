<?php

namespace App\Http\Controllers;

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

    public function update(Request $request, Funnel $funnel, Stage $stage)
    {
        $request->validate([
            'name' => 'string',
            'order' => 'integer',
        ]);

        if ($request->has('name')) {
            $stage->name = $request->name;
        }

        if ($request->has('order')) {
            $stage->order = $request->order;
        }

        $stage->save();

        return response()->json($stage, 200);
    }

    public function destroy(Request $request, Funnel $funnel, Stage $stage)
    {
        $stage->delete();

        return response()->json(['message' => 'etapa deletada'], 200);
    }

    public function updateOrder(Request $request)
    {
        $request->validate(['order' => 'required|array']);
        foreach ($request->order as $index => $id){
            Stage::where('id, $id')->update(['order' => $index]);
        }

        return response()->json(['message' => 'Ordem alterada com sucesso']);
    }
}
