<?php

namespace App\Http\Controllers;

use App\Contracts\Interface\CategoryInterface;
use App\Http\Requests\Category\StoreCategory;
use App\Http\Requests\Category\UpdateCategory;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryInterface $repo,
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only([
            'search', 'stock_min', 'stock_max', 'sort_by', 'sort_dir','category_id'
        ]);
        $categories = $this->repo->getWithFilters($filters);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(StoreCategory $request)
    {
        $this->repo->store($request->validated());

        return redirect()
            ->route('categories.index')
            ->with('success', __('Berhasil Ditambahkan'));
    }
    public function show(string $id)
    {
        try {
            $categories = $this->repo->findById($id);

            return view('categories.show', compact('categories'));
        } catch (ModelNotFoundException) {
            abort(404);
        }
    }


    public function edit(string $id)
    {
        $book = $this->repo->findById($id);
        $categories = Category::all();

        return view('categories.edit', compact('book', 'categories'));
    }


    public function update(UpdateCategory $request, string $id)
    {
        try {
            $this->repo->update($id, $request->validated());

            return redirect()
                ->route('categories.index')
                ->with('success', __('Berhasil Memperbarui'));
        } catch (ModelNotFoundException) {
            abort(404);
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->repo->delete($id);

            return back()->with('success', __('Berhasil Menghapus'));
        } catch (ModelNotFoundException) {
            abort(404);
        }
    }

    public function trash()
    {
        $categories = $this->repo->trash([])
            ->paginate(10);

        return view('category.trash', compact('categories'));
    }

    public function restore(string $id)
    {
        $this->repo->restore($id);

        return back()->with('success', __('alert.user_restore_success'));
    }
}
