<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funnel;
use Illuminate\Support\Facades\Auth;

class FunnelController extends Controller
{
    public function index()
    {
        $funnels = Funnel::where('user_id', Auth::id())->with('stages.contacts')->paginate(8);
    
        $funnelsData = $funnels->map(function($funnel) {
            $totalValue = 0;
    
            foreach ($funnel->stages as $stage) {
                foreach ($stage->contacts as $contact) {
                    $totalValue += $contact->buyValue;
                }
            }
    
            return [
                'id' => $funnel->id,
                'name' => $funnel->name,
                'color' => $funnel->color,
                'total_value' => $totalValue
            ];
        });
    
        return response()->json([
            'data' => $funnelsData,
            'meta' => [
                'total' => $funnels->total(),
                'per_page' => $funnels->perPage(),
                'current_page' => $funnels->currentPage(),
                'last_page' => $funnels->lastPage(),
                'next_page_url' => $funnels->nextPageUrl(),
                'prev_page_url' => $funnels->previousPageUrl()
            ]
        ]);
    }
    




    public function metrics()
    {
        $funnels = Funnel::where('user_id', Auth::id())->with('stages.contacts')->get();
    
        $totalFunnels = $funnels->count();
        $totalValue = 0;
        $totalContacts = 0;
        $totalContactsInLastStage = 0;
    
        foreach ($funnels as $funnel) {
            foreach ($funnel->stages as $index => $stage) {
                foreach ($stage->contacts as $contact) {
                    $totalValue += $contact->buyValue;
                    $totalContacts++;
                }
                if ($index === $funnel->stages->count() - 1) {
                    $totalContactsInLastStage += $stage->contacts->count();
                }
            }
        }
    
        $averageValuePerContact = $totalContacts > 0 ? $totalValue / $totalContacts : 0;
        $averageValuePerFunnel = $totalFunnels > 0 ? $totalValue / $totalFunnels : 0;
    
        return response()->json([
            'total_funnels' => $totalFunnels,
            'total_value' => $totalValue,
            'average_value_per_contact' => $averageValuePerContact,
            'average_value_per_funnel' => $averageValuePerFunnel,
            'total_contacts_in_last_stage' => $totalContactsInLastStage,
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
