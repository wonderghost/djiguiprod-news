<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorException;
use App\Models\Bannier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BannierController extends Controller
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
            return response()->json(Bannier::all(), 200);
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

            $banner = new Bannier;
            $banner->name = $request->name;
            $banner->id_client = $request->id_client;
            $banner->image = $path;

            if($request->file('image')->move(config('uploads.path'), $path)) {
                $banner->save();
                return response()->json($banner, 200);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}