<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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

    public function additional_authors() {
        return $this->belongsToMany(AdditionalAuthor::class, 'artikel_additional_author', 'artikel_id', 'additional_author_id');
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

    public function scopeTrendingByViews($q, int $days = 7)
    {
        return $q
            ->where('status', 'published')
            ->where('tanggal_posting', '>=', now()->subDays($days))
            ->orderByDesc('views');
    }

    public function scopeTrendingScore($q, int $days = 7)
    {
        $q
            ->when(Schema::hasColumn($this->getTable(), 'is_published'), fn ($qq) =>
                $qq->where('is_published', 1)
            )
            ->when(Schema::hasColumn($this->getTable(), 'published_at'), fn ($qq) =>
                $qq->whereNotNull('published_at')
            );

        $q->whereDate('tanggal_posting', '>=', now()->subDays($days)->toDateString());

        return $q->select('*')
            ->selectRaw("
                (views / POW(
                    GREATEST(TIMESTAMPDIFF(HOUR, CONCAT(tanggal_posting, ' 00:00:00'), NOW()), 1)
                , 1.5)) as trending_score
            ")
            ->orderByDesc('trending_score');
    }

    public function scopePopular($q, int $days = 30)
    {
        return $q
            ->when(\Illuminate\Support\Facades\Schema::hasColumn($this->getTable(), 'is_published'), fn($qq) =>
                $qq->where('is_published', 1)
            )
            ->whereDate('tanggal_posting', '>=', now()->subDays($days)->toDateString())
            ->orderByDesc('views');
    }

    public function scopePopularScore($q, int $days = 30, float $commentsWeight = 3.0, float $decay = 1.2)
    {
        $table = $q->getModel()->getTable();

        $q->whereDate('tanggal_posting', '>=', now()->subDays($days)->toDateString());

        $q->when(Schema::hasColumn($table, 'is_published'), fn ($qq) =>
            $qq->where('is_published', 1)
        );

        $q->addSelect("$table.*");
        $q->addSelect(DB::raw("
            (
            (COALESCE($table.views,0) + ($commentsWeight * (
                SELECT COUNT(*) FROM comments
                WHERE comments.article_id = $table.id   -- ganti ke article_id jika itu FK-mu
            )))
            / POW(GREATEST(TIMESTAMPDIFF(HOUR, CONCAT($table.tanggal_posting,' 00:00:00'), NOW()), 1), $decay)
            ) AS pop_score
        "));

        return $q->orderByDesc('pop_score');
    }

    public function scopeTerbit($q)
    {
        return $q->where('tanggal_posting', '<=', now('Asia/Jakarta'));
    }
}
