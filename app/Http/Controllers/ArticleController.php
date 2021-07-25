<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorException;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
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
            $articles = Article::orderBy('created_at', 'DESC')->limit(30)->get();
            foreach($articles as $value) {
                $value->category = $value->subCategories()->category()->only('slug', 'name'); 
            }
            return response()->json($articles, 200);
        } 
        catch(ErrorException $e) 
        {
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $slug)
    {
        try
        {
            $article = Article::where('slug', '=', $slug)->first();
            if($article) {
                return response()->json($article, 200);
            }
            throw new ErrorException("Cet article n'existe pas.", 422);
        } catch(ErrorException $e)
        {
            header('Erreur', true, 422);
            return response()->json($e->getMessage(), 422);
        }
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
