<?php

namespace App\Listeners;

use App\Models\User;
use App\Models\Article;
use App\Events\ApproveArticleEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\PostArticleNotification;

class ApproveArticleListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(public Article $article)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ApproveArticleEvent $event): void
    {

       // sleep(5);
        $users = User::all();

        foreach($users as $user)
        {
            $user = User::find($user->id);
            $user->notify(new PostArticleNotification($user, $event->article));
        }
    }
}
