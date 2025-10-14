<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController
{
    public function index()
    {
        $catNames = ['Politics','Finance','Health & Lifestyle','Edutech','Technology'];

        $usedIds = collect();

        $hero = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('name', $catNames))
            ->orderByDesc('views')
            ->take(3)
            ->get();
        $usedIds = $usedIds->merge($hero->pluck('id'));

        $breaking = Article::with('category')
            ->breakingToday()
            ->whereHas('category', fn($q) => $q->whereIn('name', $catNames))
            ->whereNotIn('id', $usedIds)
            ->latest('created_at')
            ->take(4)
            ->get();
        $usedIds = $usedIds->merge($breaking->pluck('id'));

        $featured = Article::with('category')
            ->where('is_featured', true)
            ->whereHas('category', fn($q) => $q->whereIn('name', $catNames))
            ->whereNotIn('id', $usedIds)
            ->latest('created_at')
            ->take(5)
            ->get();
        $usedIds = $usedIds->merge($featured->pluck('id'));

        $side = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('name', $catNames))
            ->whereNotIn('id', $usedIds)
            ->latest('created_at')
            ->take(4)
            ->get();
        $usedIds = $usedIds->merge($side->pluck('id'));

        $latest = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('name', $catNames))
            ->whereNotIn('id', $usedIds)
            ->latest('created_at')
            ->take(13)
            ->get();

        $trending = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('name', $catNames))
            ->whereNotIn('id', $usedIds)
            ->trendingScore(7)
            ->take(5)
            ->get();

        $tags = Tag::take(20)->get();

        $categories = Category::withCount('articles')
            ->whereIn('name', $catNames)->take(5)->get();

        return view('news.index', compact(
            'hero',
            'breaking',
            'featured',
            'side',
            'latest',
            'trending',
            'tags',
            'categories'
        ));
    }
}
