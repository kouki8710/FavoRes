<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Star;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // jsonのみ
    public function index(Request $request)
    {
        return Article::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    // viewを返す
    public function create(Request $request)
    {
        if (\Auth::check()){
            return view("article.create");
        }else{
            return redirect("login");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // 記事作成
    public function store(Request $request)
    {
        if (\Auth::check()){
            $article = new Article();
            $article->fill($request->input());
            $article->user = \Auth::id();
            $article->save();
            return redirect("articles/".$article->id);
        }else{
            return redirect("login");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $article = Article::find($id);
        if (!$article)
        {
            abort(404);
        }
        return $article;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $article = Article::find($id);
        if (!$article)
        {
            abort(404);
        }
        if (\Auth::check())
        {
            if (\Auth::id()==$article->user)
            {
                return view("article.edit",compact("article"));
            }else{
                abort(403);
            }
        }else{
            return redirect("login");
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
        $article = Article::find($id);
        if (!$article)
        {
            abort(404);
        }
        if (\Auth::check())
        {
            if (\Auth::id()==$article->user)
            {
                $article->update($request->input());
                return redirect("articles/".$article->id);
            }else{
                abort(403);
            }
        }else{
            return redirect("login");
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $article = Article::find($id);
        if (!$article)
        {
            abort(404);
        }
        
        if (\Auth::check())
        {
            if (\Auth::id()==$article->user)
            {
                $article->delete();
                return redirect("/");
            }else{
                abort(403);
            }
        }else{
            return redirect("login");
        }
    }
}
