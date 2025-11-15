<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\Tag;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ArticleController
{
    public function show($slug)
    {
        $headerAd  = Ads::active()->position('header')->inRandomOrder()->first();
        $sidebarAd = Ads::active()->position('sidebar')->inRandomOrder()->first();
        $usedIds = collect();
        $allowedCategories = ['Politics','Finance','Health & Lifestyle','Edu/Tech','Technology'];
        $article = Article::with(['category','tags'])
            ->where('slug', $slug)
            ->terbit()
            ->firstOrFail();
        $trending = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('name', $allowedCategories))
            ->whereNotIn('id', $usedIds)
            ->terbit()
            ->trendingScore(7)
            ->take(5)
            ->get();
        $categories = Category::withCount('articles')
            ->whereIn('name', $allowedCategories)
            ->take(5)
            ->get();
        $tags = Tag::take(20)->get();
        $popular = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('name', $allowedCategories))
            ->whereNotIn('id', $usedIds ?? [])
            ->terbit()
            ->popularScore(30, commentsWeight: 3.0, decay: 1.2)
            ->take(3)
            ->get();
        $article->increment('views');
        return view('news.show', compact(
            'article',
            'trending',
            'categories',
            'tags',
            'popular',
            'headerAd',
            'sidebarAd'
        ));
    }

    public function comment(Request $request)
    {
        $validated = $request->validate([
            'article_id' => 'required|exists:artikels,id',
            'parent_id'  => 'nullable|exists:comments,id',
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'website'    => 'nullable|url|max:255',
            'message'    => 'required|string',
        ]);

        $emailHash = md5(strtolower(trim($validated['email'])));
        $validated['avatar'] = "https://www.gravatar.com/avatar/{$emailHash}?s=80&d=mp";

        Comment::create($validated);

        return back()->with('success', 'Komentar berhasil dikirim!');
    }

    public function trending(Request $request)
    {
        $headerAd  = Ads::active()->position('header')->inRandomOrder()->first();
        $sidebarAd = Ads::active()->position('sidebar')->inRandomOrder()->first();
        $usedIds = collect();
        $allowedCategories = ['Politics','Finance','Health & Lifestyle','Edu/Tech','Technology'];

        $articles = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('name', $allowedCategories))
            ->trendingScore(7)
            ->paginate(10);

        $trending = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('name', $allowedCategories))
            ->whereNotIn('id', $usedIds)
            ->trendingScore(7)
            ->take(5)
            ->get();

        $categories = Category::withCount('articles')
            ->whereIn('name', $allowedCategories)
            ->take(5)->get();

        $tags = Tag::latest()->take(20)->get();

        $popular = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('name', $allowedCategories))
            ->whereNotIn('id', $usedIds ?? [])
            ->popularScore(30, commentsWeight: 3.0, decay: 1.2)
            ->take(3)
            ->get();

        return view('news.trending', compact(
            'articles',
            'trending',
            'categories',
            'tags',
            'popular',
            'headerAd',
            'sidebarAd'
        ));
    }

    public function search(Request $request)
    {
        $headerAd  = Ads::active()->position('header')->inRandomOrder()->first();
        $sidebarAd = Ads::active()->position('sidebar')->inRandomOrder()->first();
        $usedIds = collect();
        $q     = trim($request->query('q', ''));
        $cat   = $request->query('cat');
        $sort  = $request->query('sort', 'recent');
        $days  = (int) $request->query('days', 0);
        $allowed = ['Politics','Finance','Health & Lifestyle','Edu/Tech','Technology'];

        $categories = Category::select('name','slug')->orderBy('name')->get();

        $articles = Article::with('category')
            ->when($q !== '', function($query) use ($q) {
                $query->where(function($qq) use ($q) {
                    $qq->where('judul', 'like', "%{$q}%");
                });
            })
            ->whereHas('category', fn($c) => $c->whereIn('name', $allowed))
            ->orderBy('tanggal_posting','desc')
            ->paginate(12)
            ->appends($request->query());
        $trending = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('name', $allowed))
            ->whereNotIn('id', $usedIds)
            ->trendingScore(7)
            ->take(5)
            ->get();
        $tags = Tag::latest()->take(20)->get();
        $popular = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('name', $allowed))
            ->whereNotIn('id', $usedIds ?? [])
            ->popularScore(30, commentsWeight: 3.0, decay: 1.2)
            ->take(3)
            ->get();
        return view('news.search', compact(
            'articles',
            'q',
            'cat',
            'sort',
            'days',
            'categories',
            'trending',
            'tags',
            'popular',
            'headerAd',
            'sidebarAd'
        ));
    }
}
