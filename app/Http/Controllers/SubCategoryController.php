<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorException;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return SubCategory::orderBy('created_at', 'DESC')->get();
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
                'id_category' => 'required'
            ]);

            $subCategory = new SubCategory();
            $subCategory->name = $request->name;
            $subCategory->id_category = $request->id_category;
            $subCategory->save();

            return response()->json($subCategory, 200);
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
    public function update(Request $request, string $slug)
    {
        try {
            $subCategory = SubCategory::where('slug', '=', $slug)->first();

            if ($subCategory) {
                $subCategory->name = $request->name;
                $subCategory->id_category = $request->id_category;
                $subCategory->save();

                $response = [
                    'data' => $subCategory,
                    'message' => "Modification effectuée avec succès" 
                ];
                return response()->json($response, 200);
            }

            throw new ErrorException("Cette sous-catégorie n'existe pas.", 422);
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
    public function destroy(string $slug)
    {
        try {
            $subCategory = SubCategory::where('slug', '=', $slug)->first();

            if($subCategory) {
                $subCategory->delete();
                $response = [
                    'message' => $subCategory->name." supprimé(e) avec succès."
                ];
                return response()->json($response, 200);
            }
        } catch (ErrorException $e) {
            header("Erreur", true, 422);
            return response()->json($e->getMessage(), 422);
        }
    }
}
