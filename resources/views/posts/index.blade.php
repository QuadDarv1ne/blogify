@extends('layouts.app')

@section('title', 'All Posts')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Latest Posts</h1>

            @if($posts->count() > 0)
                <div class="space-y-8">
                    @foreach($posts as $post)
                        <article class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                            @if($post->featured_image)
                                <a href="{{ route('posts.show', $post) }}">
                                    <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-64 object-cover">
                                </a>
                            @endif

                            <div class="p-6">
                                <!-- Categories -->
                                <div class="flex flex-wrap gap-2 mb-3">
                                    @foreach($post->categories as $category)
                                        <a href="{{ route('posts.category', $category) }}" class="inline-block px-3 py-1 text-xs font-semibold rounded-full" style="background-color: {{ $category->color }}20; color: {{ $category->color }}">
                                            {{ $category->name }}
                                        </a>
                                    @endforeach
                                </div>

                                <!-- Title -->
                                <h2 class="text-2xl font-bold mb-2">
                                    <a href="{{ route('posts.show', $post) }}" class="text-gray-900 hover:text-indigo-600">
                                        {{ $post->title }}
                                    </a>
                                </h2>

                                <!-- Meta -->
                                <div class="flex items-center text-sm text-gray-500 mb-4">
                                    <span>{{ $post->user->name }}</span>
                                    <span class="mx-2">•</span>
                                    <time>{{ $post->published_at->format('M d, Y') }}</time>
                                    <span class="mx-2">•</span>
                                    <span>{{ $post->reading_time }} min read</span>
                                </div>

                                <!-- Excerpt -->
                                <p class="text-gray-600 mb-4">
                                    {{ $post->excerpt }}
                                </p>

                                <!-- Tags -->
                                @if($post->tags->count() > 0)
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @foreach($post->tags as $tag)
                                            <a href="{{ route('posts.tag', $tag) }}" class="text-sm text-gray-500 hover:text-indigo-600">
                                                #{{ $tag->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Read More -->
                                <a href="{{ route('posts.show', $post) }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">
                                    Read more →
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                    <p class="text-gray-500 text-lg">No posts found.</p>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Popular Posts -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Popular Posts</h3>
                <div class="space-y-4">
                    @foreach($popularPosts as $post)
                        <article>
                            <h4 class="font-semibold mb-1">
                                <a href="{{ route('posts.show', $post) }}" class="text-gray-900 hover:text-indigo-600">
                                    {{ Str::limit($post->title, 60) }}
                                </a>
                            </h4>
                            <div class="text-sm text-gray-500">
                                {{ $post->views_count }} views
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            <!-- Categories -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Categories</h3>
                <div class="space-y-2">
                    @foreach($categories as $category)
                        <a href="{{ route('posts.category', $category) }}" class="flex items-center justify-between py-2 px-3 rounded-lg hover:bg-gray-50 transition">
                            <span class="text-gray-700">{{ $category->name }}</span>
                            <span class="text-sm text-gray-500">{{ $category->published_posts_count }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
