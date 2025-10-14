<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class TagController
{
    public function show(Tag $tag)
    {
        $tags = Tag::take(20)->get();
        $articles = Article::with('category','tags')
            ->whereHas('tags', fn($q) => $q->where('tags.id', $tag->id))
            ->latest()
            ->paginate(10);

        $allowed = ['Politics','Finance','Health & lifestyle','Edutech','Technology'];
        $categories = Category::withCount('articles')
            ->whereIn('name', $allowed)->take(5)->get();

        $trending = Article::with('category')->trendingScore(5, 7)->get();
        return view('tags.show', compact(
            'tag',
            'articles',
            'categories',
            'trending',
            'tags'
        ));
    }
}
