<?php

namespace App\Models;

use App\Models\Article;
use App\Models\Scopes\RecentsArticlesScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::addGlobalScope(new RecentsArticlesScope);
    }

    protected $fillable = [
        'name'
    ];

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
