<?php

namespace Modules\Blog\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Admin\Models\Traits\HasUuid;
use Modules\Blog\Database\Factories\PostFactory;

class Post extends Model
{
    use HasFactory;
    use HasUuid;

    protected $guarded = [];

    public $table = 'blog_posts';

    protected $casts = [
        'display_at' => 'datetime',
    ];

    protected static function newFactory(): PostFactory
    {
        return PostFactory::new();
    }

    public function route($id): string
    {
        return route('admin.blog.posts.edit', ['post' => $id]);
    }

    public function author(): HasOne
    {
        return $this->hasOne(Author::class, 'id', 'author_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'blog_category_post');
    }

    public function scopeDate($query): object
    {
        return $query->where('display_at', '<=', Carbon::now());
    }

    public function scopeOrder($query): object
    {
        return $query->orderBy('display_at', 'desc');
    }
}
