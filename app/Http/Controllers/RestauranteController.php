<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurantes = \App\Models\Restaurante::all();
        return view('restaurantes.index', compact('restaurantes'));
    }

    public function show(\App\Models\Restaurante $restaurante)
    {
        return view('restaurantes.show', compact('restaurante'));
    }

    // Add other methods for creating, updating, and deleting restaurantes as needed
}
