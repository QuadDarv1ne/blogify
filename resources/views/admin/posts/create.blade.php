@extends('admin.layouts.app')

@section('title', 'Create Post')

@section('content')
<h1 class="text-2xl font-bold text-gray-900 mb-6">Create Post</h1>

<form action="{{ route('admin.posts.store') }}" method="POST" class="space-y-6">
    @csrf

    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
        <input type="text" name="title" id="title" value="{{ old('title') }}" class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500" required>
        @error('title')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
        <textarea name="content" id="content" rows="10" class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500" required>{{ old('content') }}</textarea>
        @error('content')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-2 gap-6">
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
            <select name="category_id" id="category_id" class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Select category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="tags" class="block text-sm font-medium text-gray-700">Tags</label>
            <select name="tags[]" id="tags" multiple class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                @foreach($tags as $tag)
                    <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="flex items-center">
        <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published') ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
        <label for="is_published" class="ml-2 block text-sm text-gray-700">Publish immediately</label>
    </div>

    <div class="flex justify-end gap-4">
        <a href="{{ route('admin.posts.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</a>
        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">Create Post</button>
    </div>
</form>
@endsection
