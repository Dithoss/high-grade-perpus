@extends('layouts.app')
@section('title', 'Transaksi Dihapus')
@section('header', 'Transaksi Dihapus')
@section('subtitle', 'Kelola transaksi yang telah dihapus')

@section('content')
{{-- Header Actions --}}
<div class="flex justify-between items-center mb-6">
    <a href="{{ route('transactions.index') }}" 
       class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-all shadow-sm hover:shadow-md">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
</div>

{{-- Table Card --}}
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No Resi</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Peminjam</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Buku</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Pinjam</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Dihapus Pada</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($transactions as $item)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded-full">
                            #{{ substr($item->id, 0, 8) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white font-bold mr-3 flex-shrink-0">
                                {{ strtoupper(substr($item->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">{{ $item->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $item->user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $firstItem = $item->items->first();
                            $totalItems = $item->items->count();
                        @endphp
                        @if($firstItem)
                        <div>
                            <div class="font-semibold text-gray-900">{{ $firstItem->book->name }}</div>
                            <div class="text-sm text-gray-500">Qty: {{ $firstItem->quantity }}</div>
                            @if($totalItems > 1)
                                <span class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full mt-1">
                                    +{{ $totalItems - 1 }} buku lain
                                </span>
                            @endif
                        </div>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        {{ $item->borrowed_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @switch($item->status)
                            @case('borrowed')
                                <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">
                                    <i class="fas fa-book-open mr-1"></i> Dipinjam
                                </span>
                                @break
                            @case('return_requested')
                                <span class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-full">
                                    <i class="fas fa-clock mr-1"></i> Menunggu
                                </span>
                                @break
                            @case('returned')
                                <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                                    <i class="fas fa-check-circle mr-1"></i> Dikembalikan
                                </span>
                                @break
                            @case('damaged')
                                <span class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> Rusak
                                </span>
                                @break
                            @case('lost')
                                <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded-full">
                                    <i class="fas fa-times-circle mr-1"></i> Hilang
                                </span>
                                @break
                        @endswitch
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        {{ $item->deleted_at->format('d M Y H:i') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <form action="{{ route('transactions.restore', $item->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PUT')
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-1.5 bg-green-100 hover:bg-green-200 text-green-700 text-xs font-medium rounded-lg transition-all" 
                                        onclick="return confirm('Restore transaksi ini?')">
                                    <i class="fas fa-undo mr-1"></i> Restore
                                </button>
                            </form>
                            
                            <form action="{{ route('transactions.force-delete', $item->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-medium rounded-lg transition-all" 
                                        onclick="return confirm('Hapus permanen? Tindakan ini tidak bisa dibatalkan!')">
                                    <i class="fas fa-trash-alt mr-1"></i> Hapus Permanen
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12">
                        <div class="text-center">
                            <i class="fas fa-inbox text-gray-300 text-5xl mb-4"></i>
                            <p class="text-gray-500 text-lg">Tidak ada transaksi yang dihapus</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($transactions->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        {{ $transactions->links() }}
    </div>
    @endif
</div>
@endsection