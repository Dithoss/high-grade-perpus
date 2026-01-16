@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header Card -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-t-xl shadow-lg p-6 text-white">
        <div class="flex items-center space-x-3">
            <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3">
                <i class="fas fa-book-medical text-2xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Tambah Buku Baru</h2>
                <p class="text-blue-100 text-sm">Masukkan informasi buku ke dalam sistem perpustakaan</p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-b-xl shadow-lg p-8">
        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Nama Buku -->
            <div class="group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-book text-blue-600 mr-2"></i>Nama Buku
                    <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="name" 
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 outline-none @error('name') border-red-500 @enderror" 
                    placeholder="Masukkan nama buku"
                    value="{{ old('name') }}"
                    required
                >
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Stock -->
            <div class="group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-boxes text-green-600 mr-2"></i>Stok
                    <span class="text-red-500">*</span>
                </label>
                <input 
                    type="number" 
                    name="stock" 
                    min="0"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-200 outline-none @error('stock') border-red-500 @enderror" 
                    placeholder="Masukkan jumlah stok"
                    value="{{ old('stock') }}"
                    required
                >
                @error('stock')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Writer -->
            <div class="group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-pen-nib text-purple-600 mr-2"></i>Penulis
                </label>
                <input 
                    type="text" 
                    name="writer" 
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200 outline-none @error('writer') border-red-500 @enderror" 
                    placeholder="Masukkan nama penulis"
                    value="{{ old('writer') }}"
                >
                @error('writer')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div class="group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-tag text-orange-600 mr-2"></i>Kategori
                    <span class="text-red-500">*</span>
                </label>
                <select 
                    name="category_id" 
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition-all duration-200 outline-none @error('category_id') border-red-500 @enderror"
                    required
                >
                    <option value="">Pilih kategori</option>
                    @foreach($categories ?? [] as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Barcode -->
            <div class="group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-barcode text-indigo-600 mr-2"></i>Barcode
                    <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="barcode" 
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 outline-none font-mono @error('barcode') border-red-500 @enderror" 
                    placeholder="Masukkan barcode buku"
                    value="{{ old('barcode') }}"
                    required
                >
                @error('barcode')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image Upload -->
            <div class="group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-image text-pink-600 mr-2"></i>Gambar Buku
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-pink-400 transition-all duration-200 cursor-pointer">
                    <input 
                        type="file" 
                        name="image" 
                        accept="image/*"
                        class="hidden" 
                        id="imageInput"
                        onchange="previewImage(event)"
                    >
                    <label for="imageInput" class="cursor-pointer">
                        <div id="imagePreview" class="mb-3">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400"></i>
                        </div>
                        <p class="text-sm text-gray-600">Klik untuk upload gambar</p>
                        <p class="text-xs text-gray-400 mt-1">PNG, JPG, JPEG (Max 2MB)</p>
                    </label>
                </div>
                @error('image')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a 
                    href="{{ route('books.index') }}" 
                    class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition-all duration-200 flex items-center space-x-2"
                >
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
                <button 
                    type="submit" 
                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all duration-200 flex items-center space-x-2"
                >
                    <i class="fas fa-save"></i>
                    <span>Simpan Buku</span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="max-h-40 mx-auto rounded-lg shadow">`;
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endpush
@endsection