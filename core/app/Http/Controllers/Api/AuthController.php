<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\User;


class AuthController extends Controller
{
    
               public function login(Request $request)
            {
                // Récupérez les données du formulaire
                $mobile = $request->input('telephone');
                $ver_code = $request->input('pin');
            
                // Trouvez l'utilisateur avec ce numéro de mobile et ce code de vérification
                $user = User::where('mobile', $mobile)
                            ->where('ver_code', $ver_code)
                            ->first();
            
                if ($user) {
                    // Connectez l'utilisateur
                    Auth::login($user);
                    $token = Str::random(60);
                    
                    // if ($user->user_type === 'manager') {
                    //     return response()->json(['user' => $user], 200);
                    // } else {
                    //     Auth::logout(); // Déconnecter l'utilisateur s'il n'est pas chauffeur
                    //     return response()->json(['error' => 'Unauthorized: User is not a chauffeur'], 401);
                    // }
                    
                    return response()->json(['user' => $user,'token' => $token,'code' =>200], 200);
                } else {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
            }

}
