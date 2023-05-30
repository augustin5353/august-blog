<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Category;
use App\Models\Scopes\RecentsArticlesScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::addGlobalScope(new RecentsArticlesScope);
    }

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

    public function getDate()
    {
        
        $date = Carbon::parse($this->created_at);  
        
        $dateGet  ='';
        if($date->isSameDay())
        {
            $dateGet = $date->translatedFormat('H:i:s');
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
        $image = $image->resize(null, 250, function ($constraint) {
            $constraint->aspectRatio();
        });
        

        return response($image)->header('Content-Type', 'image/jpeg');
    }


    public function replaceText(string $text, array $mots)
    {

        $mot_cle = "php";

        for($i = 0, $size = count($mots); $i < $size; ++$i) {
            $section_count = 0;
            $texte_modifie = preg_replace_callback("/\b($mot_cle)\b/i", function($matches) use (&$section_count) {
                $section_count++;
                return "<section id=\"section-$section_count\">{$matches[0]}</section>";
            }, $text);
        }
        
        
        
        return $texte_modifie;
    }

    public function scopeRecentsArticles(Builder $builder)
    {
        return $builder->orderBy('created_at', 'asc');
    }

}
