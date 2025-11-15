<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\Tag;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController
{
    public function index()
    {
        $headerAd  = Ads::active()->position('header')->inRandomOrder()->first();
        $sidebarAd = Ads::active()->position('sidebar')->inRandomOrder()->first();
        $allowedCategories = ['Politics','Finance','Health & Lifestyle','Edu/Tech','Technology'];

        $usedIds = collect();

        $hero = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('name', $allowedCategories))
            ->terbit()
            ->orderByDesc('views')
            ->take(3)
            ->get();
        $usedIds = $usedIds->merge($hero->pluck('id'));

        $breaking = Article::with('category')
            ->breakingToday()
            ->whereHas('category', fn($q) => $q->whereIn('name', $allowedCategories))
            ->whereNotIn('id', $usedIds)
            ->terbit()
            ->latest('tanggal_posting')
            ->take(4)
            ->get();
        $usedIds = $usedIds->merge($breaking->pluck('id'));

        $featured = Article::with('category')
            ->where('is_featured', true)
            ->whereHas('category', fn($q) => $q->whereIn('name', $allowedCategories))
            ->whereNotIn('id', $usedIds)
            ->terbit()
            ->latest('tanggal_posting')
            ->take(5)
            ->get();
        $usedIds = $usedIds->merge($featured->pluck('id'));

        $side = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('name', $allowedCategories))
            ->whereNotIn('id', $usedIds)
            ->terbit()
            ->latest('tanggal_posting')
            ->take(4)
            ->get();
        $usedIds = $usedIds->merge($side->pluck('id'));

        $latest = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('name', $allowedCategories))
            ->whereNotIn('id', $usedIds)
            ->terbit()
            ->latest('tanggal_posting')
            ->take(13)
            ->get();
        $usedIds = $usedIds->merge($latest->pluck('id'));

        $usedIds = collect();
        $trending = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('name', $allowedCategories))
            ->whereNotIn('id', $usedIds)
            ->trendingScore(7)
            ->terbit()
            ->take(5)
            ->get();

        $tags = Tag::take(20)->get();

        $categories = Category::withCount('articles')
            ->whereIn('name', $allowedCategories)->take(5)->get();

        $usedIds = collect();
        $popular = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('name', $allowedCategories))
            ->whereNotIn('id', $usedIds ?? [])
            ->terbit()
            ->popularScore(30, commentsWeight: 3.0, decay: 1.2)
            ->take(3)
            ->get();

        return view('news.index', compact(
            'hero',
            'breaking',
            'featured',
            'side',
            'latest',
            'trending',
            'tags',
            'categories',
            'popular',
            'headerAd',
            'sidebarAd'
        ));
    }
}
