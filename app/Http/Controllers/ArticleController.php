<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorException;
use App\Models\Article;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            $articles = Article::orderBy('created_at', 'DESC')->where('deleted', false)->limit(30)->get();
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

    public function articleByCategory(string $slug)
    {
        try
        {
            $articles = Article::orderBy('article.created_at', 'DESC')
            ->join('sub_category', 'article.id_sub_category', "=", "sub_category.slug")
            ->join('category', 'sub_category.id_category', "=", "category.slug")
            ->where('category.slug', $slug)
            ->select('article.slug', 'article.resume', 'article.name', 'article.description', 'article.image', 
            'article.created_at', 'article.id_sub_category')
            ->paginate();

            return response()->json($articles, 200);
        }
        catch(ErrorException $e) {
            header('Erreur', true, 422);
            return response()->json($e->getMessage(), 422);
        }
    }

    public function articleBySubCategory(string $idSubCategory)
    {
        try 
        {
            $articles = Article::orderBy('article.created_at', 'DESC')
                ->join('sub_category', 'article.id_sub_category', "=", "sub_category.slug")
                ->where('id_sub_category', $idSubCategory)
                ->select('article.slug', 'article.name', 'article.resume', 'article.description', 'article.image', 
                'article.created_at', 'article.id_sub_category')
                ->get();
            
                return response()->json($articles);
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
        try 
        {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'id_sub_category' => 'required',
                'image' => 'required'
            ]);

            if(!$request->hasFile('image')) {
                throw new ErrorException("Aucune image trouvée.");
            }

            $slug = Str::slug($request->name);
            $testSlug = Article::find($slug);

            if($testSlug) {
                throw new ErrorException("Cet article existe déjà.");
            }

            $path = Str::random(10).time(). '.'.$request->image->extension();


            $article = new Article;
            $article->name = $request->name;
            $article->resume = $request->resume;
            $article->makeSlug();
            $article->description = $request->description;
            $article->author = request()->user()->email;
            $article->id_sub_category = $request->id_sub_category;
            $article->image = $path;

            if($request->file('image')->move(config('uploads.path'), $path)) {
                $article->save();
                return response()->json($article, 200);
            }

            throw new ErrorException("Aucun traitement n'a été effectué.");

        } catch(ErrorException $e) {
            header('Erreur', true, 422);
            return response()->json($e->getMessage(), 422);
        }
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
            $article->userName = $article->user()->name;

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
    public function update(Request $request, string $slug)
    {
        try
        {
            $article = Article::where('slug', '=', $slug)->first();
            if($article) {
                // $request->validate([
                //     'name' => 'required',
                //     'description' => 'required',
                //     'id_sub_category' => 'required',
                //     'image' => 'required'
                // ]);

                if(!$request->hasFile('image')) {
                    throw new ErrorException("Aucune image trouvée.");
                }
    
                $path = Str::random(10).time(). '.'.$request->image->extension();
    
                $article->name = $request->name;
                $article->resume = $request->resume;
                $article->description = $request->description;
                $article->author = request()->user()->email;
                $article->id_sub_category = $request->id_sub_category;
                $article->image = $path;
    
                

                if($request->file('image')->move(config('uploads.path'), $path)) {
                    $article->save();
                    return response()->json($article, 200);
                }
    
                throw new ErrorException("Aucun traitement n'a été effectué.");
            }
            throw new ErrorException("Cet article n'existe pas.", 422);
        } catch(ErrorException $e)
        {
            header('Erreur', true, 422);
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
        try
        {
            $article = Article::where('slug', $slug)->first();

            if($article) 
            {
                $article->deleted = true;
                $article->save();

                $response = [
                    'message' => "Suppression effectué avec succès",
                ];

                return response()->json($response, 200);
            }
            throw new ErrorException("Cet article n'existe pas dans le système");
        } catch(ErrorException $e) {
            header('Erreur', true, 422);
            return response()->json($e->getMessage(), 422);
        }
    }

    public function search() 
    {
        try
        {
            request()->validate(['text' => 'required']);

            $data = Article::orderBy('created_at', 'DESC')
                ->where('name', 'LIKE', "%". request()->text . "%")
                ->limit(50)->get();

            return response()->json($data, 200);
        }
        catch(ErrorException $e) 
        {
            header('Erreur', 422);
            return response()->json($e->getMessage(), 422);
        }
    }
}
