<?php

namespace App\Listeners;

use App\Events\CommentSubmitted;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCommentNotification implements ShouldQueue
{
    public function handle(CommentSubmitted $event): void
    {
        // Уведомление администратору о новом комментарии
        \Log::info('New comment submitted', [
            'comment_id' => $event->comment->id,
            'post_id' => $event->comment->post_id,
            'author' => $event->comment->author_name,
        ]);
    }
}
