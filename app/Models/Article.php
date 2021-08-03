<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;
    protected $table = 'article';
    protected $keyType = "string";
    protected $primaryKey = "slug";

    public function makeSlug() {
        $this->slug = Str::slug($this->name);
    }

    public function subCategories() {
        return $this->belongsTo(SubCategory::class, 'id_sub_category', 'slug')->first();
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'author', 'email')->first();
    }
}


