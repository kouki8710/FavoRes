<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Star;
use Inertia\Inertia;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // アクセス拒否
    public function index(Request $request)
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    // viewを返す get
    public function create(Request $request)
    {
        if (\Auth::check()){
            $user = \Auth::user();
            return Inertia::render("Post",["user"=>$user])
            ->withViewData(["title"=>"FavoRes | create"]);
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

    // 記事作成 post 
    public function store(Request $request)
    {
        if (\Auth::check()){
            $request->validate([
                "title" => ["required","max:255"],
                "content" => ["required"],
                "address" => ["max:255"],
            ]);
            $article = new Article();
            $article->fill($request->input());
            $article->user = \Auth::id();
            $image = $request->file("image");
            if ($image){
                $uuidFactory = app()->make("uuidFactory");
                $uuid = $uuidFactory::generate();
                $extension = $image->getClientOriginalExtension();
                $image->storeAs('public/articles/', $uuid . '.' . $extension);
                $article->image_path = 'storage/articles/' . $uuid . '.' . $extension;
            }
            $article->save();
            return ["status"=>"success","redirect"=>"/articles"."/".$article->id];

        }else{
            return ["status"=>"guest","redirect"=>"/login"];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // 詳細記事 get
    public function show(Request $request,$id)
    {
        $article = Article::with("user")->find($id);
        $user = \Auth::user();
        if (!$article)
        {
            abort(404);
        }
        $comments = $article->comments()->with("user")->get();
        $selectedStar = $user ? $article->stars()->where("user","=",$user->id)->first() : null;
        $star_ave = Star::all()->map(function ($star) {return (int)$star->num_star;})->average();

        return Inertia::render("Detail",["article"=>$article, "user"=>$user, "parent_comments"=>$comments,
         "parent_selectedStar"=>$selectedStar, "parent_star_ave"=>$star_ave])
        ->withViewData(["title"=>"FavoRes | " . $article->title]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // 編集 get
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
                $user = \Auth::user();
                return Inertia::render("Edit",["article"=>$article, "user"=>$user])
                ->withViewData(["title"=>"FavoRes | edit - " . $article->title]);
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

    // 更新 put/patch
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
                $image = $request->file("image");
                if ($image){
                    $uuidFactory = app()->make("uuidFactory");
                    $uuid = $uuidFactory::generate();
                    $extension = $image->getClientOriginalExtension();
                    $image->storeAs('public/articles/', $uuid . '.' . $extension);
                    $article->image_path = 'storage/articles/' . $uuid . '.' . $extension;
                    $article->save();
                }
                return ["status"=>"success","redirect"=>"/articles"."/".$article->id];
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
    // 削除 delete
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
                return ["status"=>"success","redirect"=>"/"];
            }else{
                abort(403);
            }
        }else{
            return redirect("login");
        }
    }
}
