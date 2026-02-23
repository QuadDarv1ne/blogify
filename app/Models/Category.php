<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public static function getCached(): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::remember('categories', 3600, function () {
            return static::all();
        });
    }
}
