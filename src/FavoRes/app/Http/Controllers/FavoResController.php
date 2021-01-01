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
        $articles = Article::select()->join("users","users.id","=","articles.id")->take(5)->get();
        $user = \Auth::user();
        return Inertia::render("Index",["articles"=>$articles, "user"=>$user]);
    }
}
