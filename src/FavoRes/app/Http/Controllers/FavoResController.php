<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Star;
use Inertia\Inertia;

class FavoResController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::select("*","articles.id as article_id")
        ->join("users","articles.user","=","users.id")->take(20)->get();
        $user = \Auth::user();
        return Inertia::render("Index",["articles"=>$articles, "user"=>$user])
        ->withViewData(["title"=>"FavoRes | Home"]);
    }
}
