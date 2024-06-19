<?php

namespace App\Http\Controllers;

use App\Models\Restaurante;
use App\Models\Item;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ItemController extends Controller
{
    public function index()
    {
        $restaurantes = Restaurante::where('user_id', auth()->id())->get();

        // Extract the IDs of the restaurants
        $restaurantIds = $restaurantes->pluck('id');
        $items = Item::whereIn('restaurante_id', $restaurantIds)->get();
        return Inertia::render('MenuItems/ManageItems', [
            'restaurantes' => $restaurantes,
            'items' => $items,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'restaurante_id' => 'required|exists:restaurantes,id',
            'preco' => 'required|numeric',
            'descricao' => 'required|string',
            'imagem' => 'nullable|string',
        ]);

        return Item::create($validatedData);
    }

    public function show($id)
    {
        return Item::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $validatedData = $request->validate([
            'restaurante_id' => 'required|exists:restaurantes,id',
            'preco' => 'required|numeric',
            'descricao' => 'required|string',
            'imagem' => 'nullable|string',
        ]);

        $item->update($validatedData);

        return $item;
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return response()->noContent();
    }
}
