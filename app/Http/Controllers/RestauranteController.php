<?php

namespace App\Http\Controllers;

use App\Models\Restaurante;
use App\Models\Like;
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
        dd($request);
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/storage/restaurantes');

            // Check if an image with the same name and size exists
            $existingImagePath = $destinationPath . '/' . $imageName;
            if (file_exists($existingImagePath) && filesize($existingImagePath) === $image->getSize()) {
                // Use the existing image path
                $validated['image'] = $imageName;
            } else {
                // Move the uploaded image to the destination path
                $image->move($destinationPath, $imageName);
                $validated['image'] = $imageName;
            }
        } else {
            $validated['image'] = null;
        }

        Restaurante::create([
            'nome' => $validated['nome'],
            'endereco' => $validated['endereco'],
            'descricao' => $validated['descricao'],
            'imagem' => $validated['image'],
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('restaurantes.index');
    }

    public function update(Request $request, Restaurante $restaurante)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        if ($restaurante->user_id !== auth()->id()) {
            return redirect()->route('restaurantes.index')->with('error', 'Unauthorized action.');
        }

        // Check if the user has provided a new image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/storage/restaurantes');

            // Check if an image with the same name and size exists
            $existingImagePath = $destinationPath . '/' . $imageName;
            if (file_exists($existingImagePath) && filesize($existingImagePath) === $image->getSize()) {
                // Use the existing image path
                $validated['imagem'] = $imageName;
            } else {
                // Move the uploaded image to the destination path
                $image->move($destinationPath, $imageName);
                $validated['imagem'] = $imageName;
            }
        } else {
            // If the user does not have a new image, use the existing image path
            $validated['imagem'] = $restaurante->imagem;
        }

        // Update the restaurant with the validated data
        $restaurante->update($validated);

        return redirect()->route('restaurantes.index');
    }

    public function like(Request $request)
    {
        Like::create([
            'user_id' => $request['user_id'],
            'restaurante_id' => $request['restaurante_id']
        ]);

        return redirect()->route('dashboard');
    }

    public function unlike(Request $request)
    {
        $like = Like::where('user_id', $request['user_id'])
            ->where('restaurante_id', $request['restaurante_id'])
            ->first();

        if ($like) {
            $like->delete();
        }

        return redirect()->route('dashboard');
    }
}
