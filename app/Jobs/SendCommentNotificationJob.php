<?php

namespace App\Jobs;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendCommentNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Comment $comment)
    {
    }

    public function handle(): void
    {
        // Логика отправки email уведомления
        // Mail::to(config('mail.admin_email'))->send(new NewCommentNotification($this->comment));
        
        \Log::info('Comment notification sent', [
            'comment_id' => $this->comment->id,
            'post_id' => $this->comment->post_id,
        ]);
    }
}
