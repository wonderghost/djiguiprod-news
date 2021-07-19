<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\ErrorException;

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
}
