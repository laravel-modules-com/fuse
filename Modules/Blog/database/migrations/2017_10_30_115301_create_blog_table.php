<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('slug');
            $table->string('image')->nullable();
            $table->uuid('author_id');
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->datetime('display_at');
            $table->string('shortlink')->nullable();
            $table->string('download')->nullable();
            $table->string('demo')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('slug');
            $table->index('display_at');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
