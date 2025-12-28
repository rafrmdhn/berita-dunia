<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdditionalAuthor extends Model
{
    protected $guarded = ['id'];

    public function articles() {
        return $this->belongsToMany(Article::class, 'artikel_additional_author', 'additional_author_id', 'artikel_id');
    }
}
