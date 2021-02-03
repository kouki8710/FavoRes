<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Star;

class StarController extends Controller
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    // idはarticleの
    public function update(Request $request, $id)
    {
        $user = \Auth::user();
        $article = Article::find($id);
        if ($user && $article){
            $star = Star::where("user","=",$user->id)->where("article","=",$article->id)->first();
            if ($star){
                $star->update($request->input());
            }else{
                $star = new Star();
                $star->fill($request->input());
                $star->user = $user->id;
                $star->article = $article->id;
                $star->save();
            }
            $star_ave = Star::all()->map(function ($star) {return (int)$star->num_star;})->average();
            return ["status"=>"success", "star"=>$star, "star_ave"=>$star_ave];
        }else{
            return ["status"=>"error", "msg"=>"ログインをしてください。"];
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
        // $star = Star::find($id);

    }
}
