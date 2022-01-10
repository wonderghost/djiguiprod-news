<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorException;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try
        {
            return response()->json(Banner::all(), 200);
        }
        catch(ErrorException $e) {
            header('Erreur', true, 422);
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
                'image' => 'required',
                'id_client' => 'required'
            ]);

            if(!$request->hasFile('image')) {
                throw new ErrorException("Il n'y a pas d'image");
            }

            $path = Str::random(10).time(). '.'.$request->image->extension();

            $banner = new Banner;
            $banner->name = $request->name;
            $banner->id_client = $request->id_client;
            $banner->image = $path;

            if($request->file('image')->move(config('uploads.path'), $path)) {
                $banner->save();

                $response = [
                    'data' => $banner,
                    'message' => $banner->name . " ajouté(e) avec succès."
                ];

                return response()->json($response, 200);
            }

            throw new ErrorException("Aucun traitement n'a été effectué.");

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
        try
        {
            $banner = Banner::find($id);

            if($banner) {
                $request->validate([
                    'name' => 'required',
                    'image' => 'required',
                    'id_client' => 'required'
                ]);
    
                if(!$request->hasFile('image')) {
                    throw new ErrorException("Il n'y a pas d'image");
                }

                $path = Str::random(10).time(). '.'.$request->image->extension();

                $banner->name = $request->name;
                $banner->id_client = $request->id_client;
                $banner->image = $path;
                
                if($request->file('image')->move(config('uploads.path'), $path)) {
                    $banner->save();

                    $response = [
                        'data' => $banner,
                        'message' => $banner->name . " modifié(e) avec succès."
                    ];
    
                    return response()->json($response, 200);
                }

                throw new ErrorException("Aucun traitement n'a été effectué.");
            }
            
            throw new ErrorException("Cette bannière n'existe pas.", 422);
        }
        catch(ErrorException $e) {
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
        try
        {
            $banner = Banner::find($id);

            if($banner) {
                $banner->delete();
                $response = [
                    'message' => $banner->name . ' supprimé(e) avec succès.'
                ];
                return response()->json($response, 200);
            }

            throw new ErrorException("Cette bannière n'existe pas.", 422);
        }
        catch(ErrorException $e) 
        {
            header("Erreur", true, 422);
            return response()->json($e->getMessage(), 422);
        }
    }
}
