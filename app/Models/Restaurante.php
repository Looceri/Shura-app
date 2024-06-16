<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class restaurante extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'user_id','imagem', 'endereco', 'descricao']; // Add 'name' to the fillable array

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
}
