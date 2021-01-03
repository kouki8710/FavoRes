<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "content",
        "address",
        "image_path"
    ];

    public function user()
    {
        return $this->belongsTo("App\Models\User","user");
    }

    public function comments()
    {
        return $this->hasMany("App\Models\Comment","article");
    }

    public function stars()
    {
        return $this->hasMany("App\Models\Comment", "article");
    }
}
