<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurante_id',
        'user_id',
        'itens',
        'preco_total',
    ];

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class);
    }
}
