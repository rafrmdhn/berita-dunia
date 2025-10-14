<?php

namespace Database\Seeders;

use App\Models\Tag;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $categories = [
            ['name' => 'Politics', 'slug' => 'politics', 'status' => 1],
            ['name' => 'Finance', 'slug' => 'finance', 'status' => 1],
            ['name' => 'Health & lifestyle', 'slug' => 'health-lifestyle', 'status' => 1],
            ['name' => 'Edutech', 'slug' => 'edutech', 'status' => 1],
            ['name' => 'Technology', 'slug' => 'technology', 'status' => 1],
        ];

        $tags = [
            // --- Politics ---
            ['name' => 'Election',          'slug' => 'election',          'category_slug' => 'politics'],
            ['name' => 'Parliament',        'slug' => 'parliament',        'category_slug' => 'politics'],
            ['name' => 'Public Policy',     'slug' => 'public-policy',     'category_slug' => 'politics'],
            ['name' => 'Law & Human Rights','slug' => 'law-and-human-rights','category_slug' => 'politics'],
            ['name' => 'Corruption',        'slug' => 'corruption',        'category_slug' => 'politics'],
            ['name' => 'Diplomacy',         'slug' => 'diplomacy',         'category_slug' => 'politics'],
            ['name' => 'Security',          'slug' => 'security',          'category_slug' => 'politics'],
            ['name' => 'Local Elections',   'slug' => 'local-elections',   'category_slug' => 'politics'],

            // --- Finance ---
            ['name' => 'Stock Market',      'slug' => 'stock-market',      'category_slug' => 'finance'],
            ['name' => 'Banking',           'slug' => 'banking',           'category_slug' => 'finance'],
            ['name' => 'Interest Rates',    'slug' => 'interest-rates',    'category_slug' => 'finance'],
            ['name' => 'Inflation',         'slug' => 'inflation',         'category_slug' => 'finance'],
            ['name' => 'Tax',               'slug' => 'tax',               'category_slug' => 'finance'],
            ['name' => 'Fintech',           'slug' => 'fintech',           'category_slug' => 'finance'],
            ['name' => 'Cryptocurrency',    'slug' => 'cryptocurrency',    'category_slug' => 'finance'],
            ['name' => 'Commodities',       'slug' => 'commodities',       'category_slug' => 'finance'],

            // --- Health & lifestyle ---
            ['name' => 'Nutrition',         'slug' => 'nutrition',         'category_slug' => 'health-lifestyle'],
            ['name' => 'Mental Health',     'slug' => 'mental-health',     'category_slug' => 'health-lifestyle'],
            ['name' => 'Fitness',           'slug' => 'fitness',           'category_slug' => 'health-lifestyle'],
            ['name' => 'Sleep',             'slug' => 'sleep',             'category_slug' => 'health-lifestyle'],
            ['name' => 'Beauty',            'slug' => 'beauty',            'category_slug' => 'health-lifestyle'],
            ['name' => 'Parenting',         'slug' => 'parenting',         'category_slug' => 'health-lifestyle'],
            ['name' => 'Public Health',     'slug' => 'public-health',     'category_slug' => 'health-lifestyle'],
            ['name' => 'Infectious Disease','slug' => 'infectious-disease','category_slug' => 'health-lifestyle'],

            // --- Edutech ---
            ['name' => 'Online Learning',   'slug' => 'online-learning',   'category_slug' => 'edutech'],
            ['name' => 'LMS',               'slug' => 'lms',               'category_slug' => 'edutech'],
            ['name' => 'MOOC',              'slug' => 'mooc',              'category_slug' => 'edutech'],
            ['name' => 'AI in Education',   'slug' => 'ai-in-education',   'category_slug' => 'edutech'],
            ['name' => 'Digital Literacy',  'slug' => 'digital-literacy',  'category_slug' => 'edutech'],
            ['name' => 'Curriculum',        'slug' => 'curriculum',        'category_slug' => 'edutech'],
            ['name' => 'Coding & STEM',     'slug' => 'coding-and-stem',   'category_slug' => 'edutech'],
            ['name' => 'Scholarships',      'slug' => 'scholarships',      'category_slug' => 'edutech'],

            // --- Technology ---
            ['name' => 'Gadgets',           'slug' => 'gadgets',           'category_slug' => 'technology'],
            ['name' => 'Artificial Intelligence','slug' => 'artificial-intelligence','category_slug' => 'technology'],
            ['name' => 'Cybersecurity',     'slug' => 'cybersecurity',     'category_slug' => 'technology'],
            ['name' => 'Apps',              'slug' => 'apps',              'category_slug' => 'technology'],
            ['name' => 'Cloud',             'slug' => 'cloud',             'category_slug' => 'technology'],
            ['name' => 'Data Science',      'slug' => 'data-science',      'category_slug' => 'technology'],
            ['name' => 'Blockchain',        'slug' => 'blockchain',        'category_slug' => 'technology'],
            ['name' => 'Internet of Things','slug' => 'internet-of-things','category_slug' => 'technology'],
        ];

        // foreach ($categories as $category) {
        //     Category::create($category);
        // }

        // $this->call([
        //     ArtikelSeeder::class,
        // ]);

        // foreach ($tags as $t) {
        //     Tag::firstOrCreate(
        //         ['slug' => $t['slug']],
        //         ['name' => $t['name']]
        //     );
        // }

        $this->call([
            ArtikelTagSeeder::class,
        ]);
    }
}
