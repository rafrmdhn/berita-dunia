<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\Tag;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show(Tag $tag)
    {
        $headerAd  = Ads::active()->position('header')->inRandomOrder()->first();
        $sidebarAd = Ads::active()->position('sidebar')->inRandomOrder()->first();
        $usedIds = collect();
        $tags = Tag::latest()->take(20)->get();
        $articles = Article::with('category','tags')
            ->whereHas('tags', fn($q) => $q->where('tags.id', $tag->id))
            ->terbit()
            ->latest()
            ->paginate(10);

        $allowedCategories = ['Politics','Finance','Health & lifestyle','Edu/Tech','Technology'];
        $categories = Category::withCount('articles')
            ->whereIn('name', $allowedCategories)->take(5)->get();

        $trending = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('name', $allowedCategories))
            ->whereNotIn('id', $usedIds)
            ->terbit()
            ->trendingScore(7)
            ->take(5)
            ->get();
        $popular = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('name', $allowedCategories))
            ->whereNotIn('id', $usedIds ?? [])
            ->terbit()
            ->popularScore(30, commentsWeight: 3.0, decay: 1.2)
            ->take(3)
            ->get();

        return view('tags.show', compact(
            'tag',
            'articles',
            'categories',
            'trending',
            'tags',
            'popular',
            'headerAd',
            'sidebarAd'
        ));
    }
}
