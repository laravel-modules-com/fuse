<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Admin\Models\Traits\HasUuid;
use Modules\Blog\Database\Factories\AuthorFactory;

class Author extends Model
{
    use HasFactory;
    use HasUuid;

    protected $guarded = [];

    public $table = 'blog_authors';

    protected static function newFactory(): AuthorFactory
    {
        return AuthorFactory::new();
    }

    public function posts(): hasMany
    {
        return $this->hasMany(Post::class, 'author_id', 'id');
    }
}
