<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pedido extends Model
{
    use HasFactory;

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class);
    }
}