<?php

namespace App\Models;

use App\Models\Article;
use App\Models\Scopes\RecentsArticlesScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::addGlobalScope(new RecentsArticlesScope);
    }
    protected $fillable = [
        'designation'
    ];


    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function getImagePath(): string
    {
        return Storage::url($this->image_path);
    }

}
