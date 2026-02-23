<?php

use Illuminate\Support\Str;

if (!function_exists('generate_slug')) {
    function generate_slug(string $string): string
    {
        return Str::slug($string);
    }
}

if (!function_exists('excerpt')) {
    function excerpt(string $content, int $length = 150): string
    {
        return Str::limit(strip_tags($content), $length);
    }
}

if (!function_exists('reading_time')) {
    function reading_time(string $content): int
    {
        $words = str_word_count(strip_tags($content));
        return max(1, ceil($words / 200));
    }
}

if (!function_exists('is_admin')) {
    function is_admin(): bool
    {
        return auth()->check() && auth()->user()->is_admin;
    }
}

if (!function_exists('cache_key')) {
    function cache_key(string $prefix, mixed $id = null): string
    {
        return $id ? "{$prefix}.{$id}" : $prefix;
    }
}
