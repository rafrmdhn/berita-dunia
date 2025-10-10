<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = ['id'];

    public function articles() {
        return $this->belongsToMany(Article::class, 'artikel_tags', 'tag_id', 'artikel_id');
    }
}
