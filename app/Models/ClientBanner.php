<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientBanner extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'contact', 'email'];
    protected $table = 'client_banners';
    protected $primaryKey = "id";

    public function banners() {
        return $this->hasMany(Bannier::class, 'id_client', 'id')->first();
    }
}
