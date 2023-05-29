<?php

namespace App\Http\Controllers;

use App\Mail\ReceiveCommentMail;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;
use App\Models\User;
use App\Notifications\ReceiveCommentNotification;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request, Article $article)
    {

        $user = User::find(Auth::id());
        $comment  = Comment::create($request->validated());

        $comment->article()->associate($article);
        $comment->user()->associate($user);

        $comment->save();


        $user->notify(new ReceiveCommentNotification($article, $article->user, $comment));

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back();
    }
}
