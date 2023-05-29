<?php

namespace App\Models;

use App\Models\User;
use App\Models\Article;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
}
