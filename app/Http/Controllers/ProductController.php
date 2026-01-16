<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'stock'  => 'required|integer|min:0',
        ]);

        Book::create([
            'name'  => $request->name,
            'stock'  => $request->stock,
        ]);

        return redirect()->route('products.index');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('products.edit', compact('book'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'stock'  => 'required|integer|min:0',
        ]);

        $book = Book::findOrFail($id);

        $book->update([
            'name'  => $request->name,
            'stock'  => $request->stock,
        ]);

        return redirect()->route('products.index');
    }

    public function destroy($id)
    {
        Book::findOrFail($id)->delete();
        return redirect()->route('products.index');
    }
}
