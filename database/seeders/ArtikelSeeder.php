<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArtikelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [7, 8, 9, 10, 11];
        $faker = \Faker\Factory::create('id_ID');

        foreach ($categories as $categoryId) {
            for ($i = 1; $i <= 10; $i++) {
                $title = $faker->sentence(6);

                Article::create([
                    'gambar'         => null,
                    'sumber_gambar'  => 'https://picsum.photos/600/400?random=' . rand(1, 1000),
                    'judul'          => $title,
                    'slug'           => Str::slug($title) . '-' . Str::random(5),
                    'deskripsi'      => $faker->paragraphs(4, true),
                    'nama_penulis'   => $faker->name(),
                    'tanggal_posting'=> $faker->dateTimeBetween('-1 years', 'now'),
                    'like_count'     => rand(0, 100),
                    'dislike_count'  => rand(0, 50),
                    'views'          => rand(0, 1000),
                    'kategori_id'    => $categoryId,
                    'video'          => null,
                    'is_featured'    => rand(0, 1),
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ]);
            }
        }
    }
}
