@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto">
    <h1 class="text-xl font-bold mb-4">Tambah Kategori</h1>

    <form action="{{ route('categories.store') }}"
          method="POST"
          class="space-y-4">

        @csrf

        <div>
            <label class="block text-sm mb-1">Nama Kategori</label>
            <input type="text"
                   name="name"
                   value="{{ old('name') }}"
                   class="w-full border rounded px-3 py-2">
        </div>

        <div class="flex gap-2">
            <button class="px-4 py-2 bg-blue-600 text-white rounded">
                Simpan
            </button>

            <a href="{{ route('categories.index') }}"
               class="px-4 py-2 bg-gray-300 rounded">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
