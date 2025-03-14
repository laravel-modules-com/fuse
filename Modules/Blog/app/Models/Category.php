<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Admin\Models\Traits\HasUuid;
use Modules\Blog\Database\Factories\CategoryFactory;

class Category extends Model
{
    use HasFactory;
    use HasUuid;

    protected $guarded = [];

    public $table = 'blog_categories';

    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'blog_category_post');
    }

    public function scopeOrder($query): object
    {
        return $query->orderBy('title', 'asc');
    }
}
