@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl shadow-lg p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name ?? 'User' }}! 👋</h1>
                <p class="text-blue-100">Selamat datang kembali di Perpustakaan Digital</p>
            </div>
            <div class="hidden md:block">
                <div class="w-24 h-24 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Active Loans -->
        @php
            $activeLoans = Auth::user()->transactions()
                ->whereIn('status', ['borrowed', 'approved'])
                ->count() ?? 0;
        @endphp
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-600 mb-1">Sedang Dipinjam</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $activeLoans }}</p>
                    <p class="text-xs text-gray-500 mt-1">Buku aktif</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Wishlist Count -->
        @php
            $wishlistCount = Auth::user()->wishlists()->count() ?? 0;
        @endphp
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-pink-500 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-600 mb-1">Wishlist</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $wishlistCount }}</p>
                    <p class="text-xs text-gray-500 mt-1">Buku favorit</p>
                </div>
                <div class="w-14 h-14 bg-pink-100 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Fines -->
        @php
            $pendingFines = Auth::user()->fines()
                ->where('transactions.status', 'borrowed')
                ->count() ?? 0;
        @endphp
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-amber-500 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-600 mb-1">Denda Belum Terbayar</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $pendingFines }}</p>
                    <p class="text-xs text-gray-500 mt-1">Perlu dibayar</p>
                </div>
                <div class="w-14 h-14 bg-amber-100 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Borrowed (All Time) -->
        @php
            $totalBorrowed = Auth::user()->transactions()->count() ?? 0;
        @endphp
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-600 mb-1">Total Peminjaman</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalBorrowed }}</p>
                    <p class="text-xs text-gray-500 mt-1">Sepanjang waktu</p>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column (2/3 width) -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Active Loans Widget -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Peminjaman Aktif</h3>
                            <p class="text-sm text-gray-500">Buku yang sedang Anda pinjam</p>
                        </div>
                    </div>
                    <a 
                        href="{{ route('transactions.index') }}" 
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-all duration-200 flex items-center space-x-2"
                    >
                        <span>Lihat Semua</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                @php
                    $activeTransactions = Auth::user()->transactions()
                        ->with('book')
                        ->whereIn('status', ['borrowed', 'approved'])
                        ->latest()
                        ->take(3)
                        ->get();
                @endphp

                @if($activeTransactions && $activeTransactions->count() > 0)
                    <div class="space-y-4">
                        @foreach($activeTransactions as $transaction)
                            @if($transaction && $transaction->book)
                                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 border-2 border-blue-200 hover:border-blue-300 transition-all">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-16 h-20 bg-gradient-to-br from-gray-200 to-gray-300 rounded-lg flex items-center justify-center flex-shrink-0 overflow-hidden">
                                            @if($transaction->book->image)
                                                <img src="{{ asset('storage/' . $transaction->book->image) }}" alt="{{ $transaction->book->name ?? 'Book Cover' }}" class="w-full h-full object-cover">
                                            @else
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-bold text-gray-900 mb-1">{{ $transaction->book->name ?? 'Untitled Book' }}</h4>
                                            <p class="text-sm text-gray-600 mb-2">{{ $transaction->book->writer ?? 'Unknown Author' }}</p>
                                            <div class="flex items-center space-x-4 text-xs">
                                                @if($transaction->borrow_date)
                                                    <span class="flex items-center text-gray-600">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                        Pinjam: {{ $transaction->borrow_date->format('d M Y') }}
                                                    </span>
                                                @endif
                                                @if($transaction->return_date)
                                                    <span class="flex items-center {{ $transaction->return_date->isPast() ? 'text-red-600 font-bold' : 'text-blue-600' }}">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        Kembali: {{ $transaction->return_date->format('d M Y') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $transaction->status === 'borrowed' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                            {{ ucfirst($transaction->status ?? 'unknown') }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <h4 class="text-lg font-bold text-gray-900 mb-2">Tidak Ada Peminjaman Aktif</h4>
                        <p class="text-gray-500 mb-4">Mulai pinjam buku dari koleksi kami</p>
                        <a 
                            href="{{ route('books.index') }}"
                            class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 shadow-md hover:shadow-lg transition-all duration-200"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <span>Jelajahi Buku</span>
                        </a>
                    </div>
                @endif
            </div>

            <!-- Wishlist Widget -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-rose-500 rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Wishlist Saya</h3>
                            <p class="text-sm text-gray-500">Buku yang ingin saya baca</p>
                        </div>
                    </div>
                    <a 
                        href="{{ route('wishlist.index') }}" 
                        class="px-4 py-2 bg-gradient-to-r from-pink-600 to-rose-600 hover:from-pink-700 hover:to-rose-700 text-white rounded-lg font-semibold transition-all duration-200 flex items-center space-x-2 shadow-md hover:shadow-lg"
                    >
                        <span>Lihat Semua</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                @php
                    // Flexible approach - works with both relationship types
                    $wishlistsRaw = Auth::user()->wishlists()->latest()->take(4)->get();
                    
                    // Check if wishlists return Book models directly or Wishlist models with book relationship
                    $wishlists = collect();
                    foreach ($wishlistsRaw as $item) {
                        if (isset($item->book_id) && method_exists($item, 'book')) {
                            // Wishlist model with book relationship
                            $wishlists->push($item);
                        } else {
                            // Direct book model (many-to-many)
                            $wishlists->push($item);
                        }
                    }
                    
                    $totalWishlists = Auth::user()->wishlists()->count() ?? 0;
                    
                    // Calculate available books safely
                    $availableWishlists = 0;
                    $categoryIds = collect();
                    
                    foreach (Auth::user()->wishlists()->get() as $item) {
                        $book = isset($item->book_id) && method_exists($item, 'book') ? $item->book : $item;
                        if ($book && ($book->stock ?? 0) > 0) {
                            $availableWishlists++;
                        }
                        if ($book && $book->category_id) {
                            $categoryIds->push($book->category_id);
                        }
                    }
                    
                    $uniqueCategories = $categoryIds->unique()->count();
                @endphp

                @if($wishlists && $wishlists->count() > 0)
                    <!-- Wishlist Summary Stats -->
                    <div class="grid grid-cols-3 gap-4 mb-6">
                        <div class="bg-gradient-to-br from-pink-50 to-rose-50 rounded-lg p-4 border-2 border-pink-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-semibold text-gray-600 mb-1">Total Buku</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $totalWishlists }}</p>
                                </div>
                                <div class="w-10 h-10 bg-pink-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg p-4 border-2 border-green-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-semibold text-gray-600 mb-1">Tersedia</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $availableWishlists }}</p>
                                </div>
                                <div class="w-10 h-10 bg-green-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg p-4 border-2 border-blue-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-semibold text-gray-600 mb-1">Kategori</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $uniqueCategories }}</p>
                                </div>
                                <div class="w-10 h-10 bg-blue-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Wishlist Preview Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($wishlists as $wishlistItem)
                            @php
                                // Handle both relationship types
                                $book = (isset($wishlistItem->book_id) && method_exists($wishlistItem, 'book')) 
                                    ? $wishlistItem->book 
                                    : $wishlistItem;
                            @endphp
                            
                            @if($book)
                                <div class="group relative">
                                    <a href="{{ route('books.show', $book->slug ?? $book->id) }}" class="block">
                                        <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1 border-2 border-pink-100 hover:border-pink-300">
                                            <!-- Book Image -->
                                            <div class="aspect-[3/4] bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center overflow-hidden relative">
                                                @if($book->image ?? null)
                                                    <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->name ?? 'Book Cover' }}" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-300">
                                                @else
                                                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                    </svg>
                                                @endif
                                                
                                                <!-- Stock Badge -->
                                                <div class="absolute top-2 right-2">
                                                    <span class="text-xs {{ ($book->stock ?? 0) > 0 ? 'bg-green-500' : 'bg-red-500' }} text-white px-2 py-1 rounded-full font-medium shadow-lg">
                                                        {{ ($book->stock ?? 0) > 0 ? 'Ada' : 'Habis' }}
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Book Info -->
                                            <div class="p-3">
                                                <h4 class="font-semibold text-gray-900 line-clamp-2 mb-1 text-sm group-hover:text-pink-600 transition-colors">
                                                    {{ $book->name ?? 'Untitled Book' }}
                                                </h4>
                                                <p class="text-xs text-gray-500 line-clamp-1">{{ $book->writer ?? 'Unknown Author' }}</p>
                                            </div>
                                        </div>
                                    </a>

                                    <!-- Quick Actions on Hover -->
                                    @if(($book->stock ?? 0) > 0)
                                        <a 
                                            href="{{ route('transactions.create', ['book_id' => $book->id]) }}"
                                            class="absolute bottom-3 left-3 right-3 bg-green-500 hover:bg-green-600 text-white text-xs font-semibold py-2 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 opacity-0 group-hover:opacity-100 flex items-center justify-center space-x-1"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            <span>Pinjam</span>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- View All Link -->
                    @if($totalWishlists > 4)
                        <div class="mt-6 text-center">
                            <a 
                                href="{{ route('wishlist.index') }}" 
                                class="inline-flex items-center text-pink-600 hover:text-pink-700 font-semibold"
                            >
                                <span>Lihat {{ $totalWishlists - 4 }} buku lainnya</span>
                                <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        </div>
                    @endif

                @else
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <div class="w-20 h-20 bg-gradient-to-br from-pink-100 to-rose-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-pink-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-2">Wishlist Masih Kosong</h4>
                        <p class="text-gray-500 mb-4">Tambahkan buku favorit Anda ke wishlist</p>
                        <a 
                            href="{{ route('books.index') }}"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-pink-600 to-rose-600 text-white rounded-lg font-semibold hover:from-pink-700 hover:to-rose-700 shadow-md hover:shadow-lg transition-all duration-200"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <span>Jelajahi Koleksi Buku</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Column (1/3 width) -->
        <div class="space-y-6">
            
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Aksi Cepat</h3>
                <div class="space-y-3">
                    <a 
                        href="{{ route('books.index') }}"
                        class="flex items-center space-x-3 p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors group"
                    >
                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Cari Buku</p>
                            <p class="text-xs text-gray-500">Jelajahi koleksi</p>
                        </div>
                    </a>

                    <a 
                        href="{{ route('wishlist.index') }}"
                        class="flex items-center space-x-3 p-3 bg-pink-50 hover:bg-pink-100 rounded-lg transition-colors group"
                    >
                        <div class="w-10 h-10 bg-pink-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Wishlist</p>
                            <p class="text-xs text-gray-500">Buku favorit</p>
                        </div>
                    </a>

                    <a 
                        href="{{ route('transactions.history') }}"
                        class="flex items-center space-x-3 p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors group"
                    >
                        <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Riwayat</p>
                            <p class="text-xs text-gray-500">Lihat peminjaman</p>
                        </div>
                    </a>

                    <a 
                        href="{{ route('fines.index') }}"
                        class="flex items-center space-x-3 p-3 bg-amber-50 hover:bg-amber-100 rounded-lg transition-colors group"
                    >
                        <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Denda</p>
                            <p class="text-xs text-gray-500">Kelola pembayaran</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Reading Tips -->
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold">Tips Membaca</h3>
                </div>
                <ul class="space-y-2 text-sm text-indigo-100">
                    <li class="flex items-start">
                        <span class="mr-2">📚</span>
                        <span>Baca minimal 20 menit setiap hari</span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2">⏰</span>
                        <span>Kembalikan buku tepat waktu</span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2">💡</span>
                        <span>Catat hal menarik dari buku</span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2">🎯</span>
                        <span>Tetapkan target membaca bulanan</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Recent Books Section --}}
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Buku Terbaru</h2>
                    <p class="text-sm text-gray-500">Koleksi terbaru perpustakaan</p>
                </div>
            </div>
            <a href="{{ route('books.index') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-all duration-200 flex items-center space-x-2">
                <span>Lihat Semua</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        @php
            $recentBooks = \App\Models\Book::with('category')->latest()->take(8)->get();
        @endphp

        @if($recentBooks && $recentBooks->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4">
                @foreach($recentBooks as $book)
                    <div class="group relative">
                        <a href="{{ route('books.show', $book->slug ?? $book->id) }}" class="block">
                            <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1 border-2 border-gray-100 hover:border-blue-300">
                                <!-- Book Image -->
                                <div class="aspect-[3/4] bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center overflow-hidden relative">
                                    @if($book->image)
                                        <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->name ?? 'Book Cover' }}" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-300">
                                    @else
                                        <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    @endif
                                    
                                    <!-- Stock Badge -->
                                    <div class="absolute top-2 right-2">
                                        <span class="text-xs {{ ($book->stock ?? 0) > 0 ? 'bg-green-500' : 'bg-red-500' }} text-white px-2 py-1 rounded-full font-medium shadow-lg">
                                            {{ ($book->stock ?? 0) > 0 ? 'Tersedia' : 'Habis' }}
                                        </span>
                                    </div>

                                    <!-- Category Badge -->
                                    @if($book->category)
                                        <div class="absolute top-2 left-2">
                                            <span class="text-xs bg-blue-500 text-white px-2 py-1 rounded-full font-medium shadow-lg">
                                                {{ $book->category->name }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Book Info -->
                                <div class="p-3">
                                    <h3 class="font-semibold text-gray-900 line-clamp-2 mb-1 text-sm group-hover:text-blue-600 transition-colors">
                                        {{ $book->name ?? 'Untitled Book' }}
                                    </h3>
                                    <p class="text-xs text-gray-500 line-clamp-1 mb-2">{{ $book->writer ?? 'Unknown Author' }}</p>
                                    
                                    @if($book->stock && $book->stock > 0)
                                        <div class="flex items-center text-xs text-gray-600">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                            <span>Stok: {{ $book->stock }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </a>

                        <!-- Quick Action Button -->
                        @if(($book->stock ?? 0) > 0)
                            <a 
                                href="{{ route('transactions.create', ['book_id' => $book->id]) }}"
                                class="absolute bottom-3 left-3 right-3 bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold py-2 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 opacity-0 group-hover:opacity-100 flex items-center justify-center space-x-1"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                <span>Pinjam Sekarang</span>
                            </a>
                        @else
                            <div class="absolute bottom-3 left-3 right-3 bg-gray-400 text-white text-xs font-semibold py-2 rounded-lg text-center opacity-0 group-hover:opacity-100 transition-all duration-200">
                                Stok Habis
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Belum Ada Buku</h3>
                <p class="text-gray-500">Belum ada buku yang tersedia di perpustakaan</p>
            </div>
        @endif
    </div>
</div>
@endsection