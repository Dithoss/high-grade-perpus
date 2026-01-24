<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        //MENGAMBIL SELURUH DATA
        $products = Product::all();

        //PINDAH HALAMAN 
        return view('products.index', compact('products'));
    }

    public function create()
    {
        //HALAMAN
        return view('products.create');
    }

    public function store(Request $request)
    {
        //VALIDASI
        $request->validate([
            'name'  => 'required|string|max:255',
            'stock'  => 'required|integer|min:0',
        ]);
        //BUAT
        Product::create([
            'name'  => $request->name,
            'stock'  => $request->stock,
        ]);
        //PINDAH HALAMAN
        return redirect()->route('products.index');
    }

    public function edit($id)
    {
        //HALAMAN SESUAI ID (DETAIL PRODUCT)
        $products = Book::findOrFail($id);
        //PINDAH HALAMAN
        return view('products.edit', compact('products'));
    }

    public function update(Request $request, $id)
    {
        //VALIDASI
        $request->validate([
            'name'  => 'sometimes|string|max:255', //SESUAIKAN FIELD DATABASE
            'stock'  => 'sometimes|integer|min:0', //SESUAIKAN FIELD DATABASE
        ]);
        //CARI DAN CEK ID
        $book = Book::findOrFail($id);

        //UPDATE SESUAI ID DI VARIABLE 
        $book->update([
            'name'  => $request->name, //SESUAIKAN FIELD DATABASE
            'stock'  => $request->stock, //SESUAIKAN FIELD DATABASE
        ]);
        //PINDAH HALAMAN
        return redirect()->route('products.index');
    }

    public function destroy($id)
    {
        //CARI SESUAI ID, JIKA ADA MAKA HAPUS DATA
        Book::findOrFail($id)->delete();
        //PINDAH HALAMAN
        return redirect()->route('products.index');
    }
}
