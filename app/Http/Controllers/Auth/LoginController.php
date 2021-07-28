<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\ErrorException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Page d'authentification
     */
    public function index()
    {
        return view('login');
    }


    /**
     * Authentification utilisateur
     */
    public function login()
    {
        try
        {
            $validation = request()->validate([
                'email' =>  'required|email',
                'password'  =>  'required|string'
            ]);

            if(Auth::attempt($validation))
            {
                request()->session()->regenerate();
                return response()->json(request()->user(),200);
            }
            throw new ErrorException("Erreur sur les identifiants de connexion.");
        }
        catch(ErrorException $e)
        {
            header("Erreur",true,422);
            return response()->json($e->getMessage(),422);
        }
    }

    public function createUser(Request $request) 
    {
        try 
        {
            $request->validate([
                'name' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'role' => 'required',
            ]);

            $user = new User;
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->state = true;
            $user->password = Hash::make("bonjour");
            $user->save();

            $response = [
                'data' => $user,
                'message' => $user->name. " ajoutée avec succès." 
            ];
            return response()->json($response);
        } 
        catch(ErrorException $e)
        {
            header("Erreur",true,422);
            return response()->json($e->getMessage(),422);
        }
    }

    public function users() {
        try {
            $users = User::orderBy('created_at', 'DESC')->get();
            return response()->json($users, 200);
        } catch(ErrorException $e) {
            header('Erreur', true, 422);
            return response()->json($e->getMessage(), 422);
        }
    }
}
