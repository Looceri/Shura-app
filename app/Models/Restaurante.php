<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class restaurante extends Model
{
    use HasFactory;

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
