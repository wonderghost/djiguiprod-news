<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorException;
use App\Mail\NewsletterMail;
use App\Mail\NewsletterMails;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\TryCatch;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate(['email' => 'required|email']);

            $newsletter = new Newsletter;
            $newsletter->email = $request->email;
            $newsletter->save();

            
            Mail::to($request->email)->send(new NewsletterMail($request->email));

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

    public function send() {
        try {
            // $email = "amar@gmail.com";
            // Mail::to('amardiallo@dmail.com')->send(new NewsletterMail($email));
            // return view('app');
            $newsletters = Newsletter::all();
            foreach($newsletters as $value) {
                $newsletter = $value;
            }
            return response()->json($newsletter);
        } catch (ErrorException $e) {
            header("Erreur", true, 422);
            return response()->json($e->getMessage(), 422);
        }
    }
}
