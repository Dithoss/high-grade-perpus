@extends('layouts.app')
@section('title', 'Daftar Transaksi')
@section('header')
    @role('admin')
        Daftar Transaksi
    @else
        Transaksi Saya
    @endrole
@endsection
@section('subtitle')
    @role('admin')
        Kelola semua peminjaman buku
    @else
        Riwayat peminjaman buku Anda
    @endrole
@endsection

@section('content')
{{-- Header Actions --}}
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div class="flex flex-wrap gap-2">
        @role('admin')
            <a href="{{ route('transactions.trash') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-all shadow-sm hover:shadow-md">
                <i class="fas fa-trash mr-2"></i> Lihat Dihapus
            </a>
        @endrole
        <a href="{{ route('transactions.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg transition-all shadow-md hover:shadow-lg">
            <i class="fas fa-plus-circle mr-2"></i> Pinjam Buku
        </a>
    </div>
</div>

{{-- Filter Section --}}
<div class="bg-white rounded-xl shadow-md mb-6 overflow-hidden">
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
        <h5 class="font-semibold text-gray-800 flex items-center">
            <i class="fas fa-filter mr-2 text-blue-600"></i>
            Filter & Pencarian
        </h5>
    </div>
    <div class="p-6">
        <form method="GET" action="{{ route('transactions.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                {{-- Search --}}
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                    <input type="text" name="search" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                           placeholder="Cari resi/peminjam..." 
                           value="{{ request('search') }}">
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">Semua Status</option>
                        <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="return_requested" {{ request('status') == 'return_requested' ? 'selected' : '' }}>Pengajuan Kembali</option>
                        <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                        <option value="damaged" {{ request('status') == 'damaged' ? 'selected' : '' }}>Rusak</option>
                        <option value="lost" {{ request('status') == 'lost' ? 'selected' : '' }}>Hilang</option>
                    </select>
                </div>

                {{-- Date From --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                    <input type="date" name="date_from" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                           value="{{ request('date_from') }}">
                </div>

                {{-- Date To --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                    <input type="date" name="date_to" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                           value="{{ request('date_to') }}">
                </div>

                {{-- Sort --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
                    <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">Default</option>
                        <option value="borrowed_at" {{ request('sort') == 'borrowed_at' ? 'selected' : '' }}>Tanggal Pinjam</option>
                        <option value="due_at" {{ request('sort') == 'due_at' ? 'selected' : '' }}>Tanggal Kembali</option>
                    </select>
                </div>
            </div>

            {{-- Filter Buttons --}}
            <div class="flex flex-wrap gap-3 mt-4">
                <button type="submit" class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg transition-all shadow-md hover:shadow-lg">
                    <i class="fas fa-search mr-2"></i> Terapkan Filter
                </button>
                <a href="{{ route('transactions.index') }}" class="inline-flex items-center px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-all shadow-sm hover:shadow-md">
                    <i class="fas fa-redo mr-2"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Table Card --}}
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        {{-- Desktop Table --}}
        <div class="hidden md:block">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No Resi</th>
                        @role('admin')
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Peminjam</th>
                        @endrole
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Buku</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Pinjam</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jatuh Tempo</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($transactions as $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded-full">
                                #{{ substr($item->receipt_number, 0, 8) }}
                            </span>
                        </td>
                        @role('admin')
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
                        @endrole
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
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            @if($item->due_at)
                                {{ \Carbon\Carbon::parse($item->due_at)->format('d M Y') }}
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
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
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('transactions.show', $item->id) }}" 
                                   class="inline-flex items-center px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 text-xs font-medium rounded-lg transition-all">
                                    <i class="fas fa-eye mr-1"></i> Detail
                                </a>
                                
                                @role('admin')
                                    @if($item->status === 'return_requested')
                                    <form action="{{ route('confirm-return', $item->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-1.5 bg-green-100 hover:bg-green-200 text-green-700 text-xs font-medium rounded-lg transition-all" 
                                                onclick="return confirm('Konfirmasi pengembalian buku ini?')">
                                            <i class="fas fa-check-circle mr-1"></i> Konfirmasi
                                        </button>
                                    </form>
                                    @endif

                                    @if($item->status === 'returned')
                                    <a href="{{ route('transactions.inspect', $item->id) }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 text-xs font-medium rounded-lg transition-all">
                                        <i class="fas fa-search mr-1"></i> Inspeksi
                                    </a>
                                    @endif

                                    @if(!in_array($item->status, ['damaged', 'lost']))
                                    <a href="{{ route('transactions.edit', $item->id) }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium rounded-lg transition-all">
                                        <i class="fas fa-edit mr-1"></i> Update
                                    </a>
                                    @endif

                                    <form action="{{ route('transactions.destroy', $item->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-medium rounded-lg transition-all" 
                                                onclick="return confirm('Yakin ingin menghapus transaksi ini?')">
                                            <i class="fas fa-trash mr-1"></i>
                                        </button>
                                    </form>
                                @endrole
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->hasRole('admin') ? '7' : '6' }}" class="px-6 py-12">
                            <div class="text-center">
                                <i class="fas fa-inbox text-gray-300 text-5xl mb-4"></i>
                                <p class="text-gray-500 text-lg font-medium mb-2">
                                    @role('admin')
                                        Tidak ada transaksi
                                    @else
                                        Anda belum memiliki transaksi peminjaman
                                    @endrole
                                </p>
                                <a href="{{ route('transactions.create') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg transition-all shadow-md hover:shadow-lg mt-2">
                                    @role('admin')
                                        Buat transaksi peminjaman baru
                                    @else
                                        Mulai pinjam buku sekarang
                                    @endrole
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="md:hidden divide-y divide-gray-200">
            @forelse ($transactions as $item)
            <div class="p-4 hover:bg-gray-50 transition-colors">
                <div class="flex justify-between items-start mb-3">
                    <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded-full">
                        #{{ substr($item->id, 0, 8) }}
                    </span>
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
                </div>
                
                @role('admin')
                <div class="mb-3">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white font-bold text-sm mr-2">
                            {{ strtoupper(substr($item->user->name, 0, 1)) }}
                        </div>
                        <div class="font-semibold text-gray-900">{{ $item->user->name }}</div>
                    </div>
                </div>
                @endrole

                @php
                    $firstItem = $item->items->first();
                @endphp
                @if($firstItem)
                <div class="mb-3">
                    <div class="font-semibold text-gray-900">{{ $firstItem->book->name }}</div>
                </div>
                @endif

                <div class="text-sm text-gray-500 mb-4 space-y-1">
                    <div><i class="fas fa-calendar-alt mr-2 text-gray-400"></i>Pinjam: {{ $item->borrowed_at->format('d M Y') }}</div>
                    <div>
                        <i class="fas fa-boxes mr-2 text-gray-400"></i>Qty: 
                        @php
                            $totalQty = $item->items->sum('quantity');
                        @endphp
                        {{ $totalQty }}
                    </div>
                </div>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('transactions.show', $item->id) }}" 
                       class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 text-xs font-medium rounded-lg transition-all">
                        <i class="fas fa-eye mr-1"></i> Detail
                    </a>
                    
                    @role('admin')
                        @if($item->status === 'return_requested')
                        <form action="{{ route('confirm-return', $item->id) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" 
                                    class="w-full inline-flex items-center justify-center px-3 py-2 bg-green-100 hover:bg-green-200 text-green-700 text-xs font-medium rounded-lg transition-all" 
                                    onclick="return confirm('Konfirmasi pengembalian?')">
                                <i class="fas fa-check-circle mr-1"></i> Konfirmasi
                            </button>
                        </form>
                        @elseif(!in_array($item->status, ['damaged', 'lost']))
                        <a href="{{ route('transactions.edit', $item->id) }}" 
                           class="inline-flex items-center px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium rounded-lg transition-all">
                            <i class="fas fa-edit mr-1"></i> Update
                        </a>
                        @endif

                        <form action="{{ route('transactions.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-medium rounded-lg transition-all" 
                                    onclick="return confirm('Yakin ingin menghapus?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    @endrole
                </div>
            </div>
            @empty
            <div class="p-8 text-center">
                <i class="fas fa-inbox text-gray-300 text-5xl mb-4"></i>
                <p class="text-gray-500 mb-3">Tidak ada transaksi</p>
                <a href="{{ route('transactions.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg transition-all shadow-md hover:shadow-lg">
                    Buat transaksi peminjaman baru
                </a>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Pagination --}}
    @if($transactions->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        {{ $transactions->links() }}
    </div>
    @endif
</div>
@endsection