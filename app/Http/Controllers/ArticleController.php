<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController
{
    public function show($slug) {
        $article = Article::with(['category','tags'])
            ->where('slug',$slug)
            ->firstOrFail();
        $trending = Article::with('category')->trendingScore(5, 7)->get();
        $categories = Category::withCount('articles')
            ->whereIn('name', ['Politics','Finance','Health & Lifestyle','Edutech','Technology'])
            ->take(5)
            ->get();
        $tags = Tag::all();

        return view('news.show', compact(
            'article',
            'trending',
            'categories',
            'tags'
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
}
