<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // READ (list)
    public function index()
    {
        $transactions = Transaction::latest()->get();
        return view('transaction.index', compact('transactions'));
    }

    // CREATE (form)
    public function create()
    {
        return view('transaction.create');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'book_id'        => 'required|uuid|exists:books,id',
            'user_id'        => 'required|uuid|exists:users,id',
            'receipt_number' => 'required|string|unique:transaction,receipt_number',
            'borrowed_at'    => 'required|date',
            'returned_at'    => 'nullable|date|after_or_equal:borrowed_at',
        ]);

        Transaction::create($request->all());

        return redirect()->route('transaction.index');
    }

    // EDIT (form)
    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('transaction.edit', compact('transaction'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $request->validate([
            'book_id'        => 'required|uuid|exists:books,id',
            'user_id'        => 'required|uuid|exists:users,id',
            'receipt_number' => 'required|string|unique:transaction,receipt_number,' . $transaction->id,
            'borrowed_at'    => 'required|date',
            'returned_at'    => 'nullable|date|after_or_equal:borrowed_at',
        ]);

        $transaction->update($request->all());

        return redirect()->route('transaction.index');
    }

    // DELETE
    public function destroy($id)
    {
        Transaction::findOrFail($id)->delete();
        return redirect()->route('transaction.index');
    }
}
