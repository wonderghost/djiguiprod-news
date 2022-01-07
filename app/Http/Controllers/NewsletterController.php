<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorException;
use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate(['email' => 'required|email']);

            $newsletter = new Newsletter;
            $newsletter->email = $request->email;
            $newsletter->save();

            $response = [
                'data' => $newsletter,
                'message' => "Hello ".  $newsletter->email . " nous vous remercions pour votre abonnement au newsletter."
            ];
            return response()->json($response, 200);
            return response()->json(Newsletter::all());
        } catch (ErrorException $e) {
            header("Erreur", true, 422);
            return response()->json($e->getMessage(), 422);
        }
    }
}
