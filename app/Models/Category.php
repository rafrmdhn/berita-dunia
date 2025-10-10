<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'kategoris';
    protected $guarded = ['id'];

    public function articles() {
        return $this->hasMany(Article::class, 'kategori_id', 'id');
    }
}
