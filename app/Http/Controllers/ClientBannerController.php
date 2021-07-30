<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorException;
use App\Models\ClientBanner;
use Illuminate\Http\Request;

class ClientBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return response()->json(ClientBanner::orderBy('name', 'ASC')->get(), 200);
        } catch (ErrorException $e) {
            header("Erreur", true, 422);
            return response()->json($e->getMessage(), 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'contact' => 'required',
                'email' => ['required', 'email']
            ]);

            $client = new ClientBanner;
            $client->name = $request->name;
            $client->description = $request->description;
            $client->contact = $request->contact;
            $client->email = $request->email;
            $client->save();

            $response = [
                'data' => $client,
                'message' => $client->name . " ajouté(e) avec succès"
            ];
            return response()->json($response, 200);
        } catch (ErrorException $e) {
            header("Erreur", true, 422);
            return response()->json($e->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $client = ClientBanner::find($id);

            if ($client) {
                $client->name = $request->name;
                $client->description = $request->description;
                $client->contact = $request->contact;
                $client->email = $request->email;
                $client->save();

                $response = [
                    'data' => $client,
                    'message' => "Modification effectuée avec succès"
                ];
                return response()->json($response, 200);
            }

            throw new ErrorException("Cette categorie n'existe pas.", 422);
        } catch (ErrorException $e) {
            header("Erreur", true, 422);
            return response()->json($e->getMessage(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $client = ClientBanner::find($id);

            if($client) {
                $client->delete();
                $response = [
                    'message' => $client->name." supprimé(e) avec succès."
                ];
                return response()->json($response, 200);
            }
        } catch (ErrorException $e) {
            header("Erreur", true, 422);
            return response()->json($e->getMessage(), 422);
        }
    }
}
