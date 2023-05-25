<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashborad()
    {
        return view('admin.dashboard');
    }
    public function articleIndex()
    {
        $articles = Article::has('comments', 'category', 'user')->paginate(15);

        return view('admin.article.index', [
            'articles' =>$articles,
        ]);
    }
}
