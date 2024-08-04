<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\Funnel;

class AuthController extends Controller
{

    public function show(Request $request)
    {
        $user = Auth::user();

        $funnels = Funnel::where('user_id', $user->id)->with('stages.contacts')->get();

        $funnelsData = $funnels->map(function($funnel) {
            $totalValue = 0;
            $totalContacts = 0;
            $lastStageContacts = 0;

            foreach ($funnel->stages as $stage) {
                foreach ($stage->contacts as $contact) {
                    $totalValue += $contact->buyValue ?? 0;
                    $totalContacts++;
                }
            }
            
            if ($funnel->stages->isNotEmpty()) {
                $lastStage = $funnel->stages->last();
                $lastStageContacts = $lastStage->contacts->count();
            }

            return [
                'id' => $funnel->id,
                'name' => $funnel->name,
                'total_value' => $totalValue,
                'total_contacts' => $totalContacts,
                'last_stage_contacts' => $lastStageContacts
            ];
        });

        return response()->json([
            'user' => $user,
            'funnels' => $funnelsData
        ]);
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:User',
            'password' => 'required|string|min:8|confirmed',
            'documentType' => 'required|in:CPF,CNPJ',
            'documentNumber' => 'required|string|unique:User',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors()
            , 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'documentType' => $request->documentType,
            'documentNumber' => $request->documentNumber,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User Registrado com Sucesso', 'user' => $user], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!auth::attempt($credentials)) {
            return response()->json(['message' => 'Credenciais Inválidas'], 401);
        }

        $user = Auth::User();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['access_token' => $token, 'token_type' => 'Bearer', 'AuthUser' => $user]);
    }

    public function destroy($id)
    {
        $User = User::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $User->delete();

        return response()->json(null, 204);
    }
}



