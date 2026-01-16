<?php

namespace App\Http\Controllers;

use App\Contracts\Interface\BookInterface;
use App\Contracts\Interface\CategoryInterface;
use App\Http\Handlers\BookHandler;
use App\Http\Requests\Book\StoreBook;
use App\Http\Requests\Book\UpdateBook;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct(
        protected BookInterface $repo,
        protected BookHandler $handler,
        protected CategoryInterface $Crepo
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only([
            'search', 'stock_min', 'stock_max', 'sort_by', 'sort_dir','category_id'
        ]);

        $book = $this->repo->getWithFilters($filters);

        return view('books.index', compact('book'));
    }

    public function create()
    {
        $categories = $this->Crepo->getWithFilters();
        return view('books.create', compact('categories'));
    }

    public function store(StoreBook $request)
    {
        $this->handler->create($request->validated());

        return redirect()
            ->route('books.index')
            ->with('success', __('Berhasil Ditambahkan'));
    }
    public function show(string $id)
    {
        try {
            $book = $this->repo->findById($id);

            return view('books.show', compact('book'));
        } catch (ModelNotFoundException) {
            abort(404);
        }
    }


    public function edit(string $id)
    {
        try {
            $book = $this->repo->findById($id);

            return view('books.edit', compact('book'));
        } catch (ModelNotFoundException) {
            abort(404);
        }
    }

    public function update(UpdateBook $request, string $id)
    {
        try {
            $this->handler->update($id, $request->validated());

            return redirect()
                ->route('books.index')
                ->with('success', __('alert.update_success'));
        } catch (ModelNotFoundException) {
            abort(404);
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->repo->delete($id);

            return redirect()
            ->route('books.index')
            ->with('success', __('Berhasil Dihapus'));
        } catch (ModelNotFoundException) {
            abort(404);
        }
    }

    public function trash()
    {
        $book = $this->repo->trash([])
            ->paginate(10);

        return view('books.trash', compact('book'));
    }

    public function restore(string $id)
    {
        $this->repo->restore($id);

        return back()->with('success', __('alert.user_restore_success'));
    }
}
