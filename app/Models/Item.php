<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'restaurante_id',
        'preco',
        'descricao',
        'imagem',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class);
    }

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class);
    }
}
