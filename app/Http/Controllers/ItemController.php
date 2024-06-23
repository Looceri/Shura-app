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
        $items = Item::whereIn('restaurante_id', $restaurantIds)
            ->with('restaurante') // Eager load the restaurante relationship
            ->get();

        // Add the restaurante_nome field to each item
        $items->each(function ($item) {
            $item->restaurante_nome = $item->restaurante->nome;
        });

        return Inertia::render('MenuItems/ManageItems', [
            'restaurantes' => $restaurantes,
            'items' => $items,
        ]);
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'nome' => 'required|string',
            'restaurante_id' => 'required',
            'preco' => 'required',
            'descricao' => 'required|string',
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('imagem')) {
            $imagem = $request->file('imagem');
            $imageName = time() . '.' . $imagem->getClientOriginalExtension();
            $destinationPath = public_path('/storage/items/');

            // Check if an imagem with the same name and size exists
            $existingImagePath = $destinationPath . '/' . $imageName;
            if (file_exists($existingImagePath) && filesize($existingImagePath) === $imagem->getSize()) {
                // Use the existing imagem path
                $validatedData['imagem'] = $imageName;
            } else {
                // Move the uploaded imagem to the destination path
                $imagem->move($destinationPath, $imageName);
                $validatedData['imagem'] = $imageName;
            }
        } else {
            $validatedData['imagem'] = null;
        }

        Item::create($validatedData);

        return redirect()->route('items.index');
    }

    public function show($id)
    {
        return Item::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $data = ([
            'nome' => $request['nome'],
            'restaurante_id' => $request['restaurante_id'],
            'preco' => $request['preco'],
            'descricao' => $request['descricao'],
            'imagem' => $request['imagem'],
        ]);


        if ($request->hasFile('imagem')) {
            $imagem = $request->file('imagem');
            $imageName = time() . '.' . $imagem->getClientOriginalExtension();
            $destinationPath = public_path('/storage/items/');

            // Check if an imagem with the same name and size exists
            $existingImagePath = $destinationPath . '/' . $imageName;
            if (file_exists($existingImagePath) && filesize($existingImagePath) === $imagem->getSize()) {
                // Use the existing imagem path
                $data['imagem'] = $imageName;
            } else {
                // Delete the existing imagem if it exists
                if ($item->imagem && file_exists($destinationPath . $item->imagem)) {
                    unlink($destinationPath . $item->imagem);
                }

                // Move the uploaded imagem to the destination path
                $imagem->move($destinationPath, $imageName);
                $data['imagem'] = $imageName;
            }
        } elseif ($request->input('imagem') === null) {
            // Delete the existing imagem if it exists
            if ($item->imagem && file_exists(public_path('/storage/items/') . $item->imagem)) {
                unlink(public_path('/storage/items/') . $item->imagem);
            }

            $data['imagem'] = null;
        }

        $item->update($data);

    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return response()->noContent();
    }
}
