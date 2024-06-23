<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class restaurante extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'restaurante_id',
        'user_id',
        'imagem',
        'endereco',
        'descricao'
    ];

    // A restaurant belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A restaurant has many menu items
    public function menuItems()
    {
        return $this->hasMany(Item::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
