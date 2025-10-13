<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController
{
    public function index(Request $request)
    {
        $activeSlug = $request->query('cat');
        $allowedNames = ['Politics','Finance','Health & Lifestyle','Edutech','Technology'];
        $categories = Category::whereIn('name', $allowedNames)
            ->take(5)
            ->get();

        $query = Article::with('category')
            ->whereHas('category', function ($q) use ($allowedNames) {
                $q->whereIn('name', $allowedNames);
            })
            ->latest();

        $activeCategory = null;
        if ($activeSlug) {
            $activeCategory = Category::where('slug', $activeSlug)->firstOrFail();
            $query->where('kategori_id', $activeCategory->id);
        }

        $articles = $query->paginate(14)->appends(['cat' => $activeSlug]);

        $trending = Article::with('category')->trendingScore(5, 7)->get();

        $tags = Tag::all();

        return view('categories.index', compact(
            'categories',
            'activeCategory',
            'activeSlug',
            'articles',
            'trending',
            'tags'
        ));
    }
}
