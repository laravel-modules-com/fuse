<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Blog\Database\Factories\CategoryPostFactory;

class CategoryPost extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $table = 'blog_category_post';

    public $timestamps = false;

    protected static function newFactory(): CategoryPostFactory
    {
        return CategoryPostFactory::new();
    }
}
