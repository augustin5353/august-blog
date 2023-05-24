<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

       
    

    public function getImagePath(): string
    {
        return Storage::url($this->image_path);
    }
    public function getSlug(): string
    {
        return Str::slug($this->title);
    }
}
