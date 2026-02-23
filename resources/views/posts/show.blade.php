@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <article class="bg-white rounded-lg shadow-sm overflow-hidden">
        @if($post->image)
            <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="w-full h-96 object-cover">
        @endif

        <div class="p-8">
            @if($post->category)
                <div class="mb-4">
                    <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full bg-indigo-100 text-indigo-700">
                        {{ $post->category->name }}
                    </span>
                </div>
            @endif

            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>

            <div class="flex items-center text-gray-600 mb-6 pb-6 border-b border-gray-200">
                <div class="text-sm">
                    {{ $post->published_at?->format('M d, Y') }} · {{ $post->reading_time }} min read
                </div>
            </div>

            <div class="prose prose-lg max-w-none mb-8">
                {!! nl2br(e($post->content)) !!}
            </div>

            @if($post->tags->count() > 0)
                <div class="flex flex-wrap gap-2 pt-6 border-t border-gray-200">
                    @foreach($post->tags as $tag)
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                            #{{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            @endif
        </div>
    </article>

    <!-- Comments Section -->
    <div class="bg-white rounded-lg shadow-sm p-8 mt-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Comments</h2>

        @auth
            <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mb-8">
                @csrf
                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Leave a comment</label>
                    <textarea name="content" id="content" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required></textarea>
                </div>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Post Comment
                </button>
            </form>
        @else
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-8">
                <p class="text-gray-600">
                    Please <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">login</a> to leave a comment.
                </p>
            </div>
        @endauth

        <div class="space-y-6">
            @forelse($post->comments->where('is_approved', true) as $comment)
                <div class="border-l-4 border-indigo-500 pl-4">
                    <div class="flex items-start mb-2">
                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 font-bold mr-3">
                            {{ substr($comment->author_name, 0, 1) }}
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">{{ $comment->author_name }}</div>
                            <div class="text-sm text-gray-500">{{ $comment->created_at?->diffForHumans() }}</div>
                        </div>
                    </div>
                    <p class="text-gray-700">{{ $comment->content }}</p>
                </div>
            @empty
                <p class="text-gray-500 text-center py-8">No comments yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
