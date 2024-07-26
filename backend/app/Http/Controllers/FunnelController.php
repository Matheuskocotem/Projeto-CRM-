<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funnel;
use Illuminate\Support\Facades\Auth;

class FunnelController extends Controller
{
    public function index($id)
    {
        if ($id) {
            $funnel = Funnel::where('user_id', Auth::id())
                            ->where('id', $id)
                            ->first();
            if (!$funnel) {
                return response()->json(['message' => 'funnel não encontrado'], 404);
            }
            return response()->json($funnel);
        }
        $funnel = Funnel::where('user_id', Auth::id())->paginate(10);
    
        return response()->json([
            'data' => $funnel->items(), 
            'meta' => [
                'total' => $funnel->total(), 
                'per_page' => $funnel->perPage(), 
                'current_page' => $funnel->currentPage(), 
                'last_page' => $funnel->lastPage(), 
                'next_page_url' => $funnel->nextPageUrl(), 
                'prev_page_url' => $funnel->previousPageUrl() 
            ]
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:7',
        ]);

        $funnel = new Funnel();
        $funnel->user_id = Auth::id();
        $funnel->name = $request->name;
        $funnel->color = $request->color;
        $funnel->save();

        return response()->json($funnel, 201);
    }

    public function search(Request $request)
    {
        $name = $request->query('name');
        $funnel = Funnel::where('user_id', Auth::id())
            ->where('name', 'like', "%$name%")
            ->get();
        return response()->json($funnel);
    }

    public function destroy($id)
    {
        $funnel = Funnel::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $funnel->delete();

        return response()->json(null, 204);
    }
}
