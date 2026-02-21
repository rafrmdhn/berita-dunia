<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\Tag;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController
{
    public function index(Request $request)
    {
        $headerAd  = Ads::active()->position('header')->inRandomOrder()->first();
        $sidebarAd = Ads::active()->position('sidebar')->inRandomOrder()->first();
        $usedIds = collect();
        $activeSlug = $request->query('cat');
        $allowedCategories = ['Politics','Finance','Health & Lifestyle','Edu/Tech','Technology'];
        $categories = Category::whereIn('name', $allowedCategories)
            ->take(5)
            ->get();

        $query = Article::with('category')
            ->whereHas('category', function ($q) use ($allowedCategories) {
                $q->whereIn('name', $allowedCategories);
            })
            ->terbit()
            ->latest();

        $activeCategory = null;
        if ($activeSlug) {
            $activeCategory = Category::where('slug', $activeSlug)->firstOrFail();
            $query->where('kategori_id', $activeCategory->id);
        }

        $articles = $query->paginate(10)->appends(['cat' => $activeSlug]);

        $trending = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('name', $allowedCategories))
            ->whereNotIn('id', $usedIds)
            ->terbit()
            ->trendingScore(7)
            ->take(5)
            ->get();

        $tags = Tag::latest()->take(10)->get();

        $popular = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('name', $allowedCategories))
            ->whereNotIn('id', $usedIds ?? [])
            ->terbit()
            ->popularScore(30, commentsWeight: 3.0, decay: 1.2)
            ->take(3)
            ->get();

        return view('categories.index', compact(
            'categories',
            'activeCategory',
            'activeSlug',
            'articles',
            'trending',
            'tags',
            'popular',
            'headerAd',
            'sidebarAd'
        ));
    }
}
