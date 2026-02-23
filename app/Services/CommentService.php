<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Mail;

class CommentService
{
    public function getApprovedForPost(Post $post)
    {
        return $post->comments()
            ->approved()
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function create(array $data): Comment
    {
        $data['is_approved'] = false;
        
        $comment = Comment::create($data);

        // Уведомление администратору (можно настроить)
        // Mail::to(config('mail.admin_email'))->send(new NewCommentNotification($comment));

        return $comment;
    }

    public function approve(Comment $comment): Comment
    {
        $comment->update(['is_approved' => true]);
        return $comment;
    }

    public function delete(Comment $comment): void
    {
        $comment->delete();
    }

    public function getPending()
    {
        return Comment::where('is_approved', false)
            ->with('post')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
