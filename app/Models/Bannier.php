<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bannier extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image'];
    protected $table = 'banniers';

    public function clientBanner() {
        return $this->belongsTo(ClientBanner::class, 'id_client', 'id')->first();
    }
}
