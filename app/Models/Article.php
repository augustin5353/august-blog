<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Intervention\Image\Facades\Image;
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
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

       
    

    public function getImagePath(): string
    {
        return Storage::url($this->image_path);
    }
    public function getSlug(): string
    {
        return Str::slug($this->title);
    }

    public function getDate(){
        
        $date = Carbon::parse($this->created_at);  
        
        $dateGet  ='';
        if($date->isSameDay())
        {
            $dateGet = 'Aujourd\'hui à ' . $date->translatedFormat('H:i');
        }
        else
        {
            $dateGet = $date->translatedFormat('d F Y H:i');
        }

        return $dateGet;
    }

    public function resizeImage(string $path)
    {
        $image = Image::make($path);
        $image = $image->resize(null, 500, function ($constraint) {
            $constraint->aspectRatio();
        });
        

        return response($image)->header('Content-Type', 'image/jpeg');
    }
}
