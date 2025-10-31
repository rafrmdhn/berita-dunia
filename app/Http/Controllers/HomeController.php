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
        $allowedCategories = ['Politics','Finance','Health & Lifestyle','Edu/Tech','Technology'];
        $usedIds = collect();

        $hero = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('name', $allowedCategories))
            ->whereNotNull('slug')->where('slug','!=','')
            ->orderByDesc('views')
            ->take(3)->get();
        $usedIds = $usedIds->merge($hero->pluck('id'));

        $breaking = Article::with('category')
            ->breakingToday()
            ->whereHas('category', fn($q) => $q->whereIn('name', $allowedCategories))
            ->whereNotIn('id', $usedIds)
            ->whereNotNull('slug')->where('slug','!=','')
            ->latest('created_at')->take(4)->get();
        $usedIds = $usedIds->merge($breaking->pluck('id'));

        $featured = Article::with('category')
            ->where('is_featured', true)
            ->whereHas('category', fn($q) => $q->whereIn('name', $allowedCategories))
            ->whereNotIn('id', $usedIds)
            ->whereNotNull('slug')->where('slug','!=','')
            ->latest('created_at')->take(5)->get();
        $usedIds = $usedIds->merge($featured->pluck('id'));

        $side = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('name', $allowedCategories))
            ->whereNotIn('id', $usedIds)
            ->whereNotNull('slug')->where('slug','!=','')
            ->latest('created_at')->take(4)->get();
        $usedIds = $usedIds->merge($side->pluck('id'));

        $trending = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('name', $allowedCategories))
            ->whereNotIn('id', $usedIds)
            ->whereNotNull('slug')->where('slug','!=','')
            ->trendingScore(7)
            ->take(5)->get();

        $usedIds = $usedIds->merge($trending->pluck('id'));

        $latest = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('name', $allowedCategories))
            ->whereNotIn('id', $usedIds)
            ->whereNotNull('slug')->where('slug','!=','')
            ->latest('created_at')->take(13)->get();

        $tags = Tag::take(20)->get();
        $categories = Category::withCount('articles')
            ->whereIn('name', $allowedCategories)->take(5)->get();

        $popular = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('name', $allowedCategories))
            ->whereNotIn('id', $usedIds ?? [])
            ->popularScore(30, commentsWeight: 3.0, decay: 1.2)
            ->take(3)->get();

        return view('news.index', compact(
            'hero','breaking','featured','side','latest','trending','tags','categories','popular'
        ));
    }
}
