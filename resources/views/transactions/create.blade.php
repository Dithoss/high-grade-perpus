@extends('layouts.app')

@section('title', 'Buat Transaksi Peminjaman')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Card -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-t-xl shadow-lg p-6 text-white">
        <div class="flex items-center space-x-3">
            <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Buat Transaksi Peminjaman</h2>
                <p class="text-green-100 text-sm">Catat peminjaman buku baru</p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-b-xl shadow-lg p-8">
        @php
            $preselectedBookId = request('book_id');
            $preselectedBook = $preselectedBookId ? \App\Models\Book::find($preselectedBookId) : null;
        @endphp

        @if($preselectedBook)
        <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-blue-800 font-medium">Buku yang akan dipinjam:</p>
                    <p class="text-blue-900 font-bold">{{ $preselectedBook->name }}</p>
                </div>
            </div>
        </div>
        @endif

        <form method="POST" action="{{ route('transactions.store') }}" class="space-y-6" id="transactionForm">
            @csrf

            @role('admin')
            <!-- User Selection (Admin Only) -->
            <div class="group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <svg class="w-4 h-4 inline text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Peminjam
                    <span class="text-red-500">*</span>
                </label>
                <select 
                    name="user_id" 
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 outline-none @error('user_id') border-red-500 @enderror"
                    required
                >
                    <option value="">Pilih peminjam</option>
                    @foreach(\App\Models\User::whereHas('roles', fn($q) => $q->where('name', 'user'))->get() as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            @endrole

            <!-- Date Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Borrowed Date -->
                <div class="group">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Tanggal Pinjam
                        <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        name="borrowed_at"
                        value="{{ old('borrowed_at', date('Y-m-d')) }}"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-200 outline-none @error('borrowed_at') border-red-500 @enderror"
                        required
                    >
                    @error('borrowed_at')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Due Date -->
                <div class="group">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline text-orange-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Tanggal Harus Kembali
                        <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        name="due_at"
                        value="{{ old('due_at') }}"
                        min="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition-all duration-200 outline-none @error('due_at') border-red-500 @enderror"
                        required
                    >
                    @error('due_at')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Books Section -->
            <div class="border-t border-gray-200 pt-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Daftar Buku yang Dipinjam
                    </h3>
                    <button 
                        type="button"
                        onclick="addBookItem()"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors flex items-center space-x-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span>Tambah Buku</span>
                    </button>
                </div>

                <div id="bookItems" class="space-y-4">
                    <!-- Initial book item -->
                    <div class="book-item bg-gray-50 rounded-lg p-4 border-2 border-gray-200">
                        <div class="flex items-start gap-4">
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Buku</label>
                                <select 
                                    name="items[0][book_id]" 
                                    class="book-select w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none"
                                    required
                                >
                                    <option value="">Pilih buku</option>
                                    @foreach(\App\Models\Book::where('stock', '>', 0)->get() as $book)
                                        <option 
                                            value="{{ $book->id }}" 
                                            data-stock="{{ $book->stock }}"
                                            {{ $preselectedBookId == $book->id ? 'selected' : '' }}
                                        >
                                            {{ $book->name }} - Stok: {{ $book->stock }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-32">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                                <input 
                                    type="number" 
                                    name="items[0][quantity]" 
                                    min="1"
                                    value="1"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none"
                                    required
                                >
                            </div>
                            <button 
                                type="button"
                                onclick="removeBookItem(this)"
                                class="mt-7 p-2.5 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors"
                                title="Hapus buku"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                @error('items')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Summary -->
            <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                <div class="flex items-center text-blue-900">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm font-medium">
                        Total buku yang dipinjam: <span id="totalBooks" class="font-bold">1</span> item
                    </p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a 
                    href="{{ route('transactions.index') }}" 
                    class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition-all duration-200 flex items-center space-x-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span>Batal</span>
                </a>
                <button 
                    type="submit" 
                    class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg font-semibold hover:from-green-700 hover:to-emerald-700 shadow-lg hover:shadow-xl transition-all duration-200 flex items-center space-x-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Simpan Transaksi</span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let itemIndex = 1;

function addBookItem() {
    const container = document.getElementById('bookItems');
    const newItem = document.querySelector('.book-item').cloneNode(true);
    
    // Update indices
    newItem.querySelectorAll('[name^="items"]').forEach(input => {
        const name = input.getAttribute('name');
        input.setAttribute('name', name.replace(/\[0\]/, `[${itemIndex}]`));
        if (input.tagName === 'SELECT') {
            input.value = '';
        } else {
            input.value = '1';
        }
    });
    
    container.appendChild(newItem);
    itemIndex++;
    updateTotalBooks();
}

function removeBookItem(button) {
    const items = document.querySelectorAll('.book-item');
    if (items.length > 1) {
        button.closest('.book-item').remove();
        updateTotalBooks();
    } else {
        alert('Minimal harus ada 1 buku yang dipinjam');
    }
}

function updateTotalBooks() {
    const total = document.querySelectorAll('.book-item').length;
    document.getElementById('totalBooks').textContent = total;
}

document.addEventListener('DOMContentLoaded', function() {
    const borrowedInput = document.querySelector('[name="borrowed_at"]');
    const dueInput = document.querySelector('[name="due_at"]');
    
    borrowedInput.addEventListener('change', function() {
        const borrowedDate = new Date(this.value);
        borrowedDate.setDate(borrowedDate.getDate() + 1);
        dueInput.min = borrowedDate.toISOString().split('T')[0];
    });

    // Add stock validation
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('book-select')) {
            const selectedOption = e.target.options[e.target.selectedIndex];
            const stock = parseInt(selectedOption.dataset.stock || 0);
            const quantityInput = e.target.closest('.book-item').querySelector('[name$="[quantity]"]');
            
            if (stock > 0) {
                quantityInput.max = stock;
            }
        }
    });
});
</script>
@endpush
@endsection