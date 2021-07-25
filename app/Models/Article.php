<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $table = 'article';
    protected $keyType = "string";
    protected $primaryKey = "slug";

    public function subCategories() {
        return $this->belongsTo(SubCategory::class, 'id_sub_category', 'slug')->first();
    }
}


