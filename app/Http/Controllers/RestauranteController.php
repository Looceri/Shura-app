<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RestauranteController extends Controller
{
    public function index()
    {
        $restaurantes = \App\Models\Restaurante::all();
        return view('restaurants', compact('restaurantes'));
    }

    public function show(\App\Models\Restaurante $restaurante)
    {
        return view('restaurantes.show', compact('restaurantes'));
    }

    // Add other methods for creating, updating, and deleting restaurantes as needed
}
