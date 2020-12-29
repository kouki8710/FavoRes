<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Star extends Model
{
    use HasFactory;

    protected $fillable = [
        "num_star"
    ];

    public function user()
    {
        return $this->belongsTo("App\Models\User","user");
    }

    public function article()
    {
        return $this->belongsTo("App\Models\Article","article");
    }
}
