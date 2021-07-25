<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Exceptions\ErrorException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return response()->json(Category::orderBy('name', 'ASC')->get(), 200);
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
            $request->validate(['name' => 'required']);

            $category = new Category;
            $category->name = $request->name;
            $category->save();

            return response()->json($category, 200);
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
            $category = Category::where('slug', '=', $slug)->first();

            if ($category) {
                $category->name = $request->name;
                $category->save();

                $response = [
                    'data' => $category,
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
    public function destroy(string $slug)
    {
        try {
            $category = Category::where('slug', '=', $slug)->first();

            if($category) {
                $category->delete();
                $response = [
                    'message' => $category->name." supprimé(e) avec succès."
                ];
                return response()->json($response, 200);
            }
        } catch (ErrorException $e) {
            header("Erreur", true, 422);
            return response()->json($e->getMessage(), 422);
        }
    }
}
