<?php

declare(strict_types=1);

namespace Modules\Blog\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Blog\Models\Post;

class XmlController extends Controller
{
    public function xml()
    {
        $posts = Post::date()->order()->get();

        return view('blog::sitemap', compact('posts'));
    }

    public function rss()
    {
        $posts = Post::with('categories')->date()->order()->take(20)->get();

        return view('blog::rss', compact('posts'));
    }
}
