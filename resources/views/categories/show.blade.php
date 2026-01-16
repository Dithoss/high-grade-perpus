@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto">
    <h1 class="text-xl font-bold mb-4">Detail Kategori</h1>

    <div class="bg-white p-4 rounded shadow">
        <p><strong>Nama:</strong> {{ $category->name }}</p>
        <p><strong>Dibuat:</strong> {{ $category->created_at->format('d M Y') }}</p>
    </div>

    <a href="{{ route('categories.index') }}"
       class="inline-block mt-4 text-blue-600">
        ← Kembali
    </a>
</div>
@endsection
