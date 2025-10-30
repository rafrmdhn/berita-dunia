<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Article;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArtikelTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $map = [
            'politics'         => ['election','parliament','public-policy','law-and-human-rights','corruption','diplomacy','security','local-elections'],
            'finance'          => ['stock-market','banking','interest-rates','inflation','tax','fintech','cryptocurrency','commodities'],
            'health-lifestyle' => ['nutrition','mental-health','fitness','sleep','beauty','parenting','public-health','infectious-disease'],
            'Edu/Tech'          => ['online-learning','lms','mooc','ai-in-education','digital-literacy','curriculum','coding-and-stem','scholarships'],
            'technology'       => ['gadgets','artificial-intelligence','cybersecurity','apps','cloud','data-science','blockchain','internet-of-things'],
        ];

        $tagIdBySlug = Tag::pluck('id', 'slug')->all();

        $articles = Article::query()
            ->select('artikels.id','kategoris.slug as cat_slug')
            ->join('kategoris','kategoris.id','=','artikels.kategori_id')
            ->get();

        $rows = [];

        foreach ($articles as $a) {
            $allowedSlugs = $map[$a->cat_slug] ?? [];
            if (empty($allowedSlugs)) {
                continue;
            }

            $allowedIds = array_values(array_intersect($tagIdBySlug, $tagIdBySlug)); // placeholder
            $allowedIds = [];
            foreach ($allowedSlugs as $slug) {
                if (isset($tagIdBySlug[$slug])) {
                    $allowedIds[] = $tagIdBySlug[$slug];
                }
            }
            if (empty($allowedIds)) {
                continue;
            }

            $count   = min(4, max(2, count($allowedIds) >= 2 ? rand(2, 4) : count($allowedIds)));
            $pickIds = Arr::random($allowedIds, $count);

            foreach ((array) $pickIds as $tagId) {
                $rows[] = [
                    'artikel_id' => $a->id,
                    'tag_id'     => $tagId,
                ];
            }
        }

        if (!empty($rows)) {
            foreach (array_chunk($rows, 1000) as $chunk) {
                DB::table('artikel_tags')->upsert($chunk, ['artikel_id','tag_id'], []);
            }
        }
    }
}
