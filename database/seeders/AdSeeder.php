<?php

namespace Database\Seeders;

use App\Models\Ads;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ads::truncate();

        Ads::create([
            'title'      => 'Top Header Banner 1',
            'image_path' => 'https://picsum.photos/728/90?random=' . rand(1, 1000),
            'link_url'   => 'https://kisahjawa.fypmedia.id',
            'position'   => 'header',
            'is_active'  => true,
        ]);

        Ads::create([
            'title'      => 'Top Header Banner 2',
            'image_path' => 'https://picsum.photos/728/90?random=' . rand(1, 1000),
            'link_url'   => 'https://kisahjawa.fypmedia.id',
            'position'   => 'header',
            'is_active'  => true,
        ]);

        Ads::create([
            'title'      => 'Sidebar Advert 1',
            'image_path' => 'https://picsum.photos/500/280?random=' . rand(1, 1000),
            'link_url'   => 'https://beritadunia.fypmedia.id',
            'position'   => 'sidebar',
            'is_active'  => true,
        ]);

        Ads::create([
            'title'      => 'Sidebar Advert 2',
            'image_path' => 'https://picsum.photos/303/280?random=' . rand(1, 1000),
            'link_url'   => 'https://istanapolitik.fypmedia.id',
            'position'   => 'sidebar',
            'is_active'  => true,
        ]);
    }
}
