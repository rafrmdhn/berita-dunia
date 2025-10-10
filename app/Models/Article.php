<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'artikels';
    protected $guarded = ['id'];

    public function category() {
        return $this->belongsTo(Category::class, 'kategori_id', 'id');
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'artikel_tags', 'artikel_id', 'tag_id');
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function scopeBreakingToday($q)
    {
        $start = Carbon::now('Asia/Jakarta')->startOfDay()->timezone('UTC');
        $end   = Carbon::now('Asia/Jakarta')->endOfDay()->timezone('UTC');

        return $q->whereBetween('created_at', [$start, $end])
            ->whereHas('category', function ($c) {
                $c->whereIn('slug', ['politics','finance']);
            });
    }
}
