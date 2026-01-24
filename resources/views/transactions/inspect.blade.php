@extends('layouts.app')

@section('title', 'Inspeksi Buku')

@section('content')
<div class="max-w-4xl mx-auto">

    <!-- HEADER -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-t-xl p-6 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold">Inspeksi Kondisi Buku</h2>
                <p class="text-indigo-100 text-sm mt-1">Periksa kondisi buku yang dikembalikan</p>
            </div>
            <a href="{{ route('transactions.index') }}" class="px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg transition-colors">
                Kembali
            </a>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="bg-white rounded-b-xl shadow-lg p-8 space-y-8">

        <!-- INFO TRANSAKSI -->
        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 border border-indigo-200 rounded-xl p-6">
            <div class="flex items-center mb-4">
                <svg class="w-6 h-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="font-bold text-lg text-gray-800">Informasi Transaksi</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white rounded-lg p-4">
                    <p class="text-xs text-gray-500 mb-1">Nomor Transaksi</p>
                    <p class="font-mono font-bold text-indigo-600">#{{ $transaction->id }}</p>
                </div>

                <div class="bg-white rounded-lg p-4">
                    <p class="text-xs text-gray-500 mb-1">Peminjam</p>
                    <p class="font-semibold text-gray-900">{{ $transaction->user->name }}</p>
                    <p class="text-xs text-gray-500">{{ $transaction->user->email }}</p>
                </div>

                <div class="bg-white rounded-lg p-4">
                    <p class="text-xs text-gray-500 mb-1">Tanggal Pinjam</p>
                    <p class="font-semibold text-gray-900">{{ $transaction->borrowed_at->format('d M Y') }}</p>
                </div>

                <div class="bg-white rounded-lg p-4">
                    <p class="text-xs text-gray-500 mb-1">Tanggal Dikembalikan</p>
                    <p class="font-semibold text-gray-900">
                        {{ $transaction->returned_at ? \Carbon\Carbon::parse($transaction->returned_at)->format('d M Y') : '-' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- BOOK LIST -->
        <div>
            <div class="flex items-center mb-4">
                <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <h3 class="font-bold text-lg text-gray-800">Daftar Buku</h3>
            </div>

            <div class="space-y-4">
                @foreach ($transaction->items as $item)
                    <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-4 flex justify-between items-center">
                            <div class="flex items-center">
                                <div class="h-12 w-12 bg-green-500 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-lg text-gray-900">{{ $item->book->name }}</p>
                                    <p class="text-sm text-gray-600">oleh {{ $item->book->writer }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">Jumlah</p>
                                <p class="text-2xl font-bold text-green-600">{{ $item->quantity }}</p>
                            </div>
                        </div>

                        <div class="p-4 bg-gray-50 grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-600">Barcode</p>
                                <p class="font-mono font-semibold">{{ $item->book->barcode }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Kategori</p>
                                <span class="inline-block px-2 py-1 bg-purple-100 text-purple-800 rounded text-xs font-medium">
                                    {{ $item->book->category?->name ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- INSPECTION FORM -->
        <div class="border-t-2 border-gray-200 pt-8">
            <div class="flex items-center mb-6">
                <svg class="w-6 h-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h6a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                <h3 class="font-bold text-lg text-gray-800">Form Inspeksi</h3>
            </div>

            <form method="POST" action="{{ route('transactions.inspect.store', $transaction->id) }}" class="space-y-6">
                @csrf

                <!-- CONDITION -->
                <div>
                    <label class="block font-semibold mb-3 text-gray-700">
                        Kondisi Buku <span class="text-red-500">*</span>
                    </label>

                    <div class="space-y-3">
                        <label class="flex items-start p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-green-50 hover:border-green-300 transition-all">
                            <input
                                type="radio"
                                name="condition"
                                value="good"
                                class="mt-1 mr-3 text-green-600 focus:ring-green-500"
                                onchange="toggleFineInput(false)"
                                {{ old('condition') === 'good' ? 'checked' : '' }}
                            >
                            <div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="font-semibold text-gray-900">Baik</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">Buku dalam kondisi sempurna, tidak ada kerusakan</p>
                            </div>
                        </label>

                        <label class="flex items-start p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-orange-50 hover:border-orange-300 transition-all">
                            <input
                                type="radio"
                                name="condition"
                                value="damaged"
                                class="mt-1 mr-3 text-orange-600 focus:ring-orange-500"
                                onchange="toggleFineInput(true)"
                                {{ old('condition') === 'damaged' ? 'checked' : '' }}
                            >
                            <div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-orange-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="font-semibold text-gray-900">Rusak</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">Buku mengalami kerusakan (sobek, coretan, dll)</p>
                            </div>
                        </label>

                        <label class="flex items-start p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-red-50 hover:border-red-300 transition-all">
                            <input
                                type="radio"
                                name="condition"
                                value="lost"
                                class="mt-1 mr-3 text-red-600 focus:ring-red-500"
                                onchange="toggleFineInput(true)"
                                {{ old('condition') === 'lost' ? 'checked' : '' }}
                            >
                            <div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="font-semibold text-gray-900">Hilang</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">Buku tidak dikembalikan atau hilang</p>
                            </div>
                        </label>
                    </div>

                    @error('condition')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- FINE AMOUNT (Hidden by default) -->
                <div id="fine-section" class="hidden bg-yellow-50 border-2 border-yellow-200 rounded-lg p-6">
                    <label class="block font-semibold mb-2 text-gray-700">
                        Jumlah Denda (Rp) <span class="text-red-500">*</span>
                    </label>
                    
                    <div class="relative">
                        <span class="absolute left-4 top-3 text-gray-500 font-semibold">Rp</span>
                        <input
                            type="number"
                            name="fine_amount"
                            id="fine_amount"
                            class="w-full pl-12 pr-4 py-3 border-2 border-yellow-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all outline-none"
                            placeholder="0"
                            value="{{ old('fine_amount') }}"
                            min="0"
                        >
                    </div>

                    <div class="mt-3 p-3 bg-white rounded border border-yellow-300">
                        <p class="text-sm text-gray-600">
                            <strong>Panduan Denda:</strong>
                        </p>
                        <ul class="text-sm text-gray-600 mt-2 space-y-1 list-disc list-inside">
                            <li>Rusak ringan: Rp 10.000 - Rp 50.000</li>
                            <li>Rusak berat: Rp 50.000 - Rp 100.000</li>
                            <li>Hilang: Sesuai harga buku atau Rp 100.000+</li>
                        </ul>
                    </div>

                    @error('fine_amount')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NOTE -->
                <div>
                    <label class="block font-semibold mb-2 text-gray-700">
                        Catatan (Opsional)
                    </label>
                    <textarea
                        name="note"
                        rows="3"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all outline-none resize-none"
                        placeholder="Tambahkan catatan inspeksi jika diperlukan..."
                    >{{ old('note') }}</textarea>
                    
                    @error('note')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- ALERT -->
                <div class="bg-indigo-50 border-l-4 border-indigo-500 p-4 rounded">
                    <div class="flex">
                        <svg class="w-5 h-5 text-indigo-500 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-sm text-indigo-700">
                            Pastikan Anda telah memeriksa kondisi buku dengan teliti sebelum menyimpan hasil inspeksi.
                        </p>
                    </div>
                </div>

                <!-- BUTTONS -->
                <div class="flex justify-end space-x-3 pt-4 border-t-2 border-gray-200">
                    <a
                        href="{{ route('transactions.index') }}"
                        class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-colors"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors shadow-lg hover:shadow-xl"
                        onclick="return confirm('Yakin dengan hasil inspeksi ini?')"
                    >
                        Simpan Hasil Inspeksi
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

@push('scripts')
<script>
function toggleFineInput(show) {
    const fineSection = document.getElementById('fine-section');
    const fineInput = document.getElementById('fine_amount');
    
    if (show) {
        fineSection.classList.remove('hidden');
        fineInput.required = true;
    } else {
        fineSection.classList.add('hidden');
        fineInput.required = false;
        fineInput.value = '';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const selectedCondition = document.querySelector('input[name="condition"]:checked');
    if (selectedCondition && (selectedCondition.value === 'damaged' || selectedCondition.value === 'lost')) {
        toggleFineInput(true);
    }
});
</script>
@endpush
@endsection