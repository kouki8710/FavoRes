<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Star;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // requestにarticlc_idも追加
    public function store(Request $request)
    {
        $article_id = $request->article_id ?? null;
        $article = $article_id ? Article::find($article_id) : null;
        if (\Auth::check() && $article){

            //既にコメントをしているかチェック
            if (Comment::where("user","=",\Auth::id())
            ->where("article","=",$article_id)->get()->count()){
                return ["status"=>"error","msg"=>"コメントは一回まで可能です。"];
            }

            $comment = new Comment();
            $comment->fill($request->input());
            $comment->user = \Auth::id();
            $comment->article = $article->id;
            $comment->save();
            return ["status"=>"success","comment"=>Comment::with("user")->find($comment->id)];
        }else{
            return ["status"=>"error", "msg"=>"ログインをしてください。"];
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        $comment = Comment::find($id);
        if ($comment && \Auth::id()==$comment->user){
            $comment->update($request->input());
            return ["status"=>"success"];
        }else{
            return ["status"=>"error"];
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
        $comment = Comment::find($id);
        if ($comment && \Auth::id()==$comment->user){
            $comment->delete();
            return ["status"=>"success"];
        }else{
            return ["status"=>"error"];
        }
    }
}
