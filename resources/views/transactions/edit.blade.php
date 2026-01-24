@extends('layouts.app')

@section('title', 'Update Status Transaksi')

@section('content')
<div class="max-w-2xl mx-auto">

    <!-- Header -->
    <div class="bg-gradient-to-r from-amber-600 to-orange-600 rounded-t-xl p-6 text-white">
        <h2 class="text-2xl font-bold">Update Status Transaksi</h2>
        <p class="text-amber-100 text-sm">Ubah status peminjaman buku</p>
    </div>

    <div class="bg-white rounded-b-xl shadow-lg p-8 space-y-6">

        <!-- INFO TRANSAKSI -->
        <div class="bg-gray-50 rounded-lg p-6 border">
            <h3 class="font-bold mb-4">Informasi Transaksi</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-600">No. Transaksi</p>
                    <p class="font-mono font-semibold">#{{ $transaction->id }}</p>
                </div>

                <div>
                    <p class="text-gray-600">Peminjam</p>
                    <p class="font-semibold">{{ $transaction->user->name }}</p>
                </div>

                <div class="md:col-span-2">
                    <p class="text-gray-600 mb-1">Daftar Buku</p>

                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($transaction->items as $item)
                            <li>
                                <span class="font-semibold">
                                    {{ $item->book->name }}
                                </span>
                                <span class="text-gray-500">
                                    ({{ $item->quantity }} buku)
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <p class="text-gray-600">Tanggal Pinjam</p>
                    <p class="font-semibold">
                        {{ $transaction->borrowed_at->format('d M Y') }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-600">Status Saat Ini</p>
                    @switch($transaction->status)
                        @case('borrowed')
                            <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">
                                Dipinjam
                            </span>
                            @break
                        @case('return_requested')
                            <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                Menunggu Konfirmasi
                            </span>
                            @break
                        @case('returned')
                            <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                Dikembalikan
                            </span>
                            @break
                        @case('damaged')
                            <span class="inline-block px-3 py-1 bg-orange-100 text-orange-800 rounded-full text-xs">
                                Rusak
                            </span>
                            @break
                        @case('lost')
                            <span class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs">
                                Hilang
                            </span>
                            @break
                    @endswitch
                </div>
            </div>
        </div>

        @if (!in_array($transaction->status, ['damaged', 'lost']))
        <!-- FORM UPDATE -->
        <form method="POST" action="{{ route('transactions.update', $transaction->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-semibold mb-2">
                    Ubah Status <span class="text-red-500">*</span>
                </label>

                <div class="space-y-3">
                    <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors {{ old('status', $transaction->status) === 'borrowed' ? 'border-yellow-400 bg-yellow-50' : 'border-gray-200' }}">
                        <input
                            type="radio"
                            name="status"
                            value="borrowed"
                            class="mr-3 text-yellow-600 focus:ring-yellow-500"
                            {{ old('status', $transaction->status) === 'borrowed' ? 'checked' : '' }}
                        >
                        <div>
                            <p class="font-semibold">Dipinjam</p>
                            <p class="text-sm text-gray-600">Buku masih dalam peminjaman</p>
                        </div>
                    </label>

                    <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors {{ old('status', $transaction->status) === 'return_requested' ? 'border-blue-400 bg-blue-50' : 'border-gray-200' }}">
                        <input
                            type="radio"
                            name="status"
                            value="return_requested"
                            class="mr-3 text-blue-600 focus:ring-blue-500"
                            {{ old('status', $transaction->status) === 'return_requested' ? 'checked' : '' }}
                        >
                        <div>
                            <p class="font-semibold">Pengajuan Pengembalian</p>
                            <p class="text-sm text-gray-600">User mengajukan pengembalian, menunggu konfirmasi</p>
                        </div>
                    </label>

                    @role('admin')
                    <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors {{ old('status', $transaction->status) === 'returned' ? 'border-green-400 bg-green-50' : 'border-gray-200' }}">
                        <input
                            type="radio"
                            name="status"
                            value="returned"
                            class="mr-3 text-green-600 focus:ring-green-500"
                            {{ old('status', $transaction->status) === 'returned' ? 'checked' : '' }}
                        >
                        <div>
                            <p class="font-semibold">Dikembalikan</p>
                            <p class="text-sm text-gray-600">Buku sudah dikembalikan (akan dilanjutkan ke inspeksi jika belum)</p>
                        </div>
                    </label>
                    @endrole
                </div>

                @error('status')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded">
                <div class="flex">
                    <svg class="w-5 h-5 text-amber-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm text-amber-700">
                        <strong>Perhatian:</strong> 
                        @role('admin')
                            Setelah status diubah menjadi <strong>Dikembalikan</strong>, transaksi harus melalui proses inspeksi.
                        @else
                            Perubahan status akan dicatat dalam audit log sistem.
                        @endrole
                    </p>
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t">
                <a
                    href="{{ route('transactions.index') }}"
                    class="px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition-colors"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors"
                    onclick="return confirm('Yakin ingin mengubah status transaksi ini?')"
                >
                    Update Status
                </button>
            </div>
        </form>
        @else
            <!-- SUDAH FINAL -->
            <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-red-600 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="font-semibold text-red-900">
                            Transaksi sudah final dan tidak dapat diubah
                        </p>
                        <p class="text-sm text-red-700 mt-1">
                            Transaksi dengan status 
                            @if($transaction->status === 'damaged')
                                <strong>"Rusak"</strong> 
                            @else
                                <strong>"Hilang"</strong> 
                            @endif
                            sudah melalui proses inspeksi dan tidak dapat diubah lagi.
                            @if($transaction->returned_at)
                                <br>Dikembalikan pada {{ \Carbon\Carbon::parse($transaction->returned_at)->format('d M Y, H:i') }}
                            @endif
                        </p>
                        @if($transaction->fines && $transaction->fines->count() > 0)
                            <div class="mt-3 p-3 bg-white rounded border border-red-200">
                                <p class="text-sm font-semibold text-gray-900">Denda terkait:</p>
                                @foreach($transaction->fines as $fine)
                                    <p class="text-sm text-gray-700 mt-1">
                                        • {{ ucfirst($fine->type) }}: Rp {{ number_format($fine->amount, 0, ',', '.') }}
                                    </p>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <a
                    href="{{ route('transactions.index') }}"
                    class="inline-block mt-4 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors"
                >
                    Kembali ke Daftar
                </a>
            </div>
        @endif

    </div>
</div>
@endsection