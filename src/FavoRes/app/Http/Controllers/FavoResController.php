<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Star;

class FavoResController extends Controller
{
    public function index(Request $request)
    {
        return view("index");
    }
}
