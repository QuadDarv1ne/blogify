<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostPublishedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Post $post)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("New Post Published: {$this->post->title}")
            ->greeting('Hello!')
            ->line("A new post has been published: {$this->post->title}")
            ->line($this->post->excerpt ?? str()->limit(strip_tags($this->post->content), 150))
            ->action('Read Post', route('posts.show', $this->post->slug))
            ->line('Thank you for reading our blog!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'post_id' => $this->post->id,
            'title' => $this->post->title,
        ];
    }
}
