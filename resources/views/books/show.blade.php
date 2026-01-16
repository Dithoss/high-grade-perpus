@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Card -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-t-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold">Detail Buku</h2>
                    <p class="text-blue-100 text-sm">Informasi lengkap buku</p>
                </div>
            </div>
            <a 
                href="{{ route('books.index') }}" 
                class="px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-lg font-semibold transition-all duration-200 flex items-center space-x-2"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Content Card -->
    <div class="bg-white rounded-b-xl shadow-lg p-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left Column - Image & Barcode -->
            <div class="space-y-6">
                <!-- Book Image -->
                <div class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl p-8 flex items-center justify-center shadow-inner" style="min-height: 400px;">
                    @if($book->image)
                        <img src="{{ asset('storage/' . $book->image) }}">
                    @else
                        <div class="text-center text-gray-400">
                            <svg class="w-32 h-32 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <p class="font-medium text-lg">Tidak ada gambar</p>
                        </div>
                    @endif
                </div>

                <!-- Barcode Display -->
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 border-2 border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-base font-bold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                            Barcode Buku
                        </p>
                        <button 
                            onclick="copyBarcode()" 
                            class="p-2 hover:bg-indigo-100 rounded-lg transition-colors group"
                            title="Copy barcode"
                        >
                            <svg class="w-5 h-5 text-indigo-600 group-hover:text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </button>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-inner">
                        <div class="w-full overflow-x-auto flex justify-center mb-3">
                            <svg id="barcode" class="max-w-full"></svg>
                        </div>
                        <p class="text-center font-mono text-base font-semibold text-gray-900">
                            {{ $book->barcode }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Column - Book Details -->
            <div class="space-y-6">
                <!-- Title & Author -->
                <div class="pb-6 border-b-2 border-gray-100">
                    <h1 class="text-4xl font-bold text-gray-900 mb-3 leading-tight">{{ $book->name }}</h1>
                    <div class="flex items-center space-x-2 text-gray-600">
                        <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                        <span class="text-xl font-medium">{{ $book->writer }}</span>
                    </div>
                </div>

                <!-- Details Grid -->
                <div class="space-y-4">
                    <!-- Stock Info - Prominent -->
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 border-2 border-green-200 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="p-3 bg-green-100 rounded-xl">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-600 mb-1">Stok Tersedia</p>
                                    <p class="text-3xl font-bold text-gray-900">{{ $book->stock }} <span class="text-lg font-normal text-gray-600">unit</span></p>
                                </div>
                            </div>
                            <span class="px-5 py-3 rounded-xl text-base font-bold {{ $book->stock > 5 ? 'bg-green-500 text-white' : ($book->stock > 0 ? 'bg-yellow-500 text-white' : 'bg-red-500 text-white') }} shadow-md">
                                @if($book->stock > 5)
                                    Stok Banyak
                                @elseif($book->stock > 0)
                                    Stok Terbatas
                                @else
                                    Habis
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Category & Writer Info -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-5 border-2 border-purple-200">
                            <div class="flex items-start space-x-3">
                                <div class="p-2 bg-purple-100 rounded-lg mt-1">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-600 mb-1">Kategori</p>
                                    <p class="text-lg font-bold text-gray-900 break-words">{{ $book->category?->name ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-5 border-2 border-amber-200">
                            <div class="flex items-start space-x-3">
                                <div class="p-2 bg-amber-100 rounded-lg mt-1">
                                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-600 mb-1">Penulis</p>
                                    <p class="text-lg font-bold text-gray-900 break-words">{{ $book->writer }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Barcode Quick View -->
                    <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-xl p-5 border-2 border-indigo-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-indigo-100 rounded-lg">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-600 mb-1">Kode Barcode</p>
                                    <p class="text-lg font-bold text-gray-900 font-mono">{{ $book->barcode }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Timestamps -->
                    <div class="bg-gray-50 rounded-xl p-5 border-2 border-gray-200">
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <p class="text-xs font-semibold text-gray-600 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Ditambahkan
                                </p>
                                <p class="font-bold text-gray-900">{{ $book->created_at->format('d M Y') }}</p>
                                <p class="text-sm text-gray-600">{{ $book->created_at->format('H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-600 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Terakhir Update
                                </p>
                                <p class="font-bold text-gray-900">{{ $book->updated_at->format('d M Y') }}</p>
                                <p class="text-sm text-gray-600">{{ $book->updated_at->format('H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                @role('admin')
                <div class="flex items-center space-x-4 pt-6 border-t-2 border-gray-100">
                    <a 
                        href="{{ route('books.edit', $book->id) }}" 
                        class="flex-1 px-6 py-4 bg-amber-500 hover:bg-amber-600 text-white rounded-xl font-bold transition-all duration-200 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl hover:-translate-y-0.5"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <span>Edit Buku</span>
                    </a>
                    <form action="{{ route('books.destroy', $book->id) }}" 
                          method="POST" 
                          class="flex-1"
                          onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                        @csrf
                        @method('DELETE')
                        <button 
                            type="submit"
                            class="w-full px-6 py-4 bg-red-500 hover:bg-red-600 text-white rounded-xl font-bold transition-all duration-200 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl hover:-translate-y-0.5"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            <span>Hapus</span>
                        </button>
                    </form>
                </div>
                @endrole
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- JsBarcode Library -->
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

<script>
// Generate barcode visualization
document.addEventListener('DOMContentLoaded', function() {
    JsBarcode("#barcode", "{{ $book->barcode }}", {
        format: "CODE128",
        width: 2,
        height: 80,
        displayValue: false,
        margin: 0
    });
});

// Copy barcode to clipboard
function copyBarcode() {
    const barcode = "{{ $book->barcode }}";
    navigator.clipboard.writeText(barcode).then(function() {
        const button = event.currentTarget;
        const originalHTML = button.innerHTML;
        button.innerHTML = '<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
        
        setTimeout(() => {
            button.innerHTML = originalHTML;
        }, 2000);
    });
}
</script>
@endpush
@endsection