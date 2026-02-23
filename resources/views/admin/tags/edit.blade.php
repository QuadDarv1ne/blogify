@extends('admin.layouts.app')

@section('title', 'Edit Tag')

@section('content')
<h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Tag</h1>

<form action="{{ route('admin.tags.update', $tag) }}" method="POST" class="space-y-6 max-w-2xl">
    @csrf
    @method('PUT')

    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $tag->name) }}" class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500" required>
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end gap-4">
        <a href="{{ route('admin.tags.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</a>
        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">Update</button>
    </div>
</form>
@endsection
