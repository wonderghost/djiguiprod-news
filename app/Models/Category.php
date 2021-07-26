<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = ['name'];
    protected $table = 'category';
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

    public function subCategories() 
    {
        return $this->hasMany(SubCategory::class, 'id_category', 'slug')->first();
    }

}