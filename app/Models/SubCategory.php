<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = ['name', 'id_category'];
    protected $table = 'sub_category';
    protected $keyType = "string";
    protected $primaryKey = "slug";

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function category() 
    {
        return $this->belongsTo(Category::class, 'id_category', 'slug')->first();
    }

    public function articles() 
    {
        return $this->hasMany(Article::class, 'id_sub_category', 'slug')->first();
    }
}
