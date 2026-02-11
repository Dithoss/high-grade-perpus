@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50">
    {{-- Success Message --}}
    @if (session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 rounded-lg p-4 shadow-md animate-fade-in">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- Hero Banner --}}
    <div class="bg-gradient-to-r from-blue-500 via-blue-600 to-indigo-600 text-white px-6 py-12 mb-6 rounded-xl shadow-xl">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Halo, {{ auth()->user()->name }}! 👋</h1>
                    <p class="text-blue-100 text-lg">Selamat datang di Perpustakaan Digital</p>
                </div>
                <div class="hidden md:block">
                    <svg class="w-32 h-32 text-white opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="">
        {{-- Quick Stats Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            {{-- Total Books --}}
            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Total Buku</p>
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Book::count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Total Categories --}}
            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Kategori</p>
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Category::count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Currently Borrowed --}}
            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Sedang Dipinjam</p>
                        <p class="text-2xl font-bold text-gray-900">
                            @php
                                $borrowed = \App\Models\Transaction::where('user_id', auth()->id())
                                    ->whereNull('returned_at')
                                    ->count();
                            @endphp
                            {{ $borrowed }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Total Unpaid Fines --}}
            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Denda Belum Bayar</p>
                        @php
                            $unpaidFines = \App\Models\Fine::whereHas('transaction', function($q) {
                                    $q->where('user_id', auth()->id());
                                })
                                ->where('status', 'unpaid')
                                ->sum('amount');
                        @endphp
                        <p class="text-lg font-bold text-gray-900">
                            Rp {{ number_format($unpaidFines, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Personalized Recommendations --}}
        @php
            $personalizedBooks = app(\App\Contracts\Repositories\AlgorithmRepository::class)
                ->personalized(auth()->id(), 6);
        @endphp

        @if($personalizedBooks->isNotEmpty())
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                    Rekomendasi Untuk Anda
                </h2>
                <a href="{{ route('books.index') }}" class="text-purple-600 hover:text-purple-700 text-sm font-medium">
                    Lihat Semua →
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($personalizedBooks as $recBook)
                <a href="{{ route('books.show', $recBook->slug) }}" class="group">
                    <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
                        <div class="aspect-[3/4] bg-gradient-to-br from-purple-100 to-indigo-100 flex items-center justify-center overflow-hidden">
                            @if($recBook->image)
                                <img src="{{ asset('storage/' . $recBook->image) }}" alt="{{ $recBook->name }}" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-300">
                            @else
                                <svg class="w-12 h-12 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            @endif
                        </div>
                        <div class="p-3">
                            <h3 class="text-sm font-medium text-gray-900 line-clamp-2 mb-1 group-hover:text-purple-600">
                                {{ $recBook->name }}
                            </h3>
                            <p class="text-xs text-gray-500">{{ $recBook->category?->name ?? 'Uncategorized' }}</p>
                            <div class="flex items-center mt-1">
                                <span class="text-xs {{ $recBook->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $recBook->stock > 0 ? 'Tersedia' : 'Habis' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Quick Actions --}}
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8 border border-gray-100">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Menu Cepat
            </h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('books.index') }}" 
                   class="group flex flex-col items-center p-4 rounded-lg hover:bg-blue-50 transition-colors border border-gray-100">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-blue-200 transition-colors">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-blue-600">Cari Buku</span>
                </a>

                <a href="{{ route('transactions.index') }}" 
                   class="group flex flex-col items-center p-4 rounded-lg hover:bg-blue-50 transition-colors border border-gray-100">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-blue-200 transition-colors">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-blue-600">Riwayat Pinjam</span>
                </a>

                <a href="{{ route('categories.index') }}" 
                   class="group flex flex-col items-center p-4 rounded-lg hover:bg-purple-50 transition-colors border border-gray-100">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-purple-200 transition-colors">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-purple-600">Kategori</span>
                </a>

                <a href="{{ route('fines.index') }}" 
                   class="group flex flex-col items-center p-4 rounded-lg hover:bg-red-50 transition-colors border border-gray-100">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-red-200 transition-colors">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-red-600">Denda Saya</span>
                </a>
            </div>
        </div>

        {{-- Recent Books Section --}}
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">Buku Terbaru</h2>
                <a href="{{ route('books.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    Lihat Semua →
                </a>
            </div>

            @php
                $recentBooks = \App\Models\Book::latest()->take(6)->get();
            @endphp

            @if($recentBooks->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach($recentBooks as $book)
                    <a href="{{ route('books.show', $book->slug) }}" class="group">
                        <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
                            <div class="aspect-[3/4] bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center overflow-hidden">
                                @if($book->image)
                                    <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->name }}" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="p-3">
                                <h3 class="text-sm font-medium text-gray-900 line-clamp-2 mb-1 group-hover:text-blue-600">
                                    {{ $book->name }}
                                </h3>
                                <p class="text-xs text-gray-500">{{ $book->category?->name ?? 'Uncategorized' }}</p>
                                <div class="flex items-center mt-1">
                                    <span class="text-xs {{ $book->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $book->stock > 0 ? 'Tersedia' : 'Habis' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <p class="text-gray-500">Belum ada buku tersedia</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection