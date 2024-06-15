<?php
namespace App\Http\Controllers;

use App\Models\Restaurante;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RestauranteController extends Controller
{
    public function index()
    {
        $restaurantes = Restaurante::where('user_id', auth()->id())->get();
        return Inertia::render('Restaurante/ManageRestaurantes', ['restaurantes' => $restaurantes]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
        ]);

        Restaurante::create([
            'name' => $request->name,
            'location' => $request->location,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('restaurantes.index');
    }

    public function update(Request $request, Restaurante $restaurante)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
        ]);

        if ($restaurante->user_id !== auth()->id()) {
            return redirect()->route('restaurantes.index')->with('error', 'Unauthorized action.');
        }

        $restaurante->update($request->all());

        return redirect()->route('restaurantes.index');
    }
}
