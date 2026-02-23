<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'is_published' => $this->is_published,
            'published_at' => $this->published_at?->toIso8601String(),
            'reading_time' => $this->reading_time,
            'views_count' => $this->views_count,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'author' => [
                'id' => $this->user?->id,
                'name' => $this->user?->name,
            ],
            'comments_count' => $this->whenCounted('comments', $this->comments_count),
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
