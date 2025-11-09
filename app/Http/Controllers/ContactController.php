<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Mail\ContactFormSubmitted;
use Illuminate\Support\Facades\Mail;

class ContactController
{
    public function index()
    {
        $usedIds = collect();
        $allowedCategories = ['Politics','Finance','Health & Lifestyle','Edu/Tech','Technology'];
        $trending = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('name', $allowedCategories))
            ->whereNotIn('id', $usedIds)
            ->terbit()
            ->trendingScore(7)
            ->take(5)
            ->get();
        $categories = Category::withCount('articles')
            ->whereIn('name', $allowedCategories)
            ->take(5)->get();
        $tags = Tag::take(20)->get();
        $popular = Article::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('name', $allowedCategories))
            ->whereNotIn('id', $usedIds ?? [])
            ->popularScore(30, commentsWeight: 3.0, decay: 1.2)
            ->terbit()
            ->take(3)
            ->get();

        return view('contacts.index', compact(
            'trending',
            'categories',
            'tags',
            'popular'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => ['required','string','max:100'],
            'email'   => ['required','email','max:150'],
            'telp'    => ['required','string','max:12'],
            'subject' => ['required','string','max:150'],
            'message' => ['required','string','max:5000'],
        ]);

        $to = 'ramadhanrafi871@gmail.com';
        Mail::to($to)->send(new ContactFormSubmitted($data));

        return back()->with('success', 'Pesan berhasil dikirim. Terima kasih!');
    }
}
