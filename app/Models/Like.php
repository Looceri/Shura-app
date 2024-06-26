<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'restaurante_id'
    ];
    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class);
    }
}
