@extends('layouts.app')

@section('title', 'Daftar Kategori')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Flash Messages --}}
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

        @if (session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-4 shadow-md animate-fade-in">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-red-800 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        {{-- Header Section --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center">
                <div class="p-3 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl mr-4 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Daftar Kategori</h1>
                    <p class="text-gray-600 mt-1">Kelola kategori buku perpustakaan</p>
                </div>
            </div>

            @role('admin')
                <a href="{{ route('categories.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Kategori
                </a>
            @endrole
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Kategori</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $categories->total() }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Halaman</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $categories->currentPage() }}/{{ $categories->lastPage() }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Data Per Halaman</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $categories->count() }}</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                    </svg>
                                    <span>No</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    <span>Nama Kategori</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    <span>Dibuat</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span>Diubah</span>
                                </div>
                            </th>
                            @role('admin')
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center justify-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                                    </svg>
                                    <span>Aksi</span>
                                </div>
                            </th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($categories as $category)
                            <tr class="hover:bg-gradient-to-r hover:from-purple-50 hover:to-transparent transition-all duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-600">
                                    {{ $loop->iteration + $categories->firstItem() - 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-lg flex items-center justify-center shadow-md">
                                            <span class="text-white font-bold text-lg">{{ strtoupper(substr($category->name, 0, 1)) }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900">{{ $category->name }}</div>
                                            <div class="text-xs text-gray-500">ID: {{ substr($category->id, 0, 8) }}...</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <svg class="w-4 h-4 inline mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $category->created_at->format('d M Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500">{{ $category->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <svg class="w-4 h-4 inline mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $category->updated_at->format('d M Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500">{{ $category->updated_at->format('H:i') }}</div>
                                </td>
                                @role('admin')
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('categories.edit', $category->id) }}" 
                                           class="inline-flex items-center px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium rounded-md transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Edit
                                        </a>

                                        <form action="{{ route('categories.destroy', $category->id) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('Yakin hapus kategori {{ $category->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-md transition-all duration-150 shadow-sm hover:shadow-md">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                @endrole
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->hasRole('admin') ? '5' : '4' }}" class="px-6 py-12 text-center">
                                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    <p class="text-gray-500 text-lg font-medium">Belum ada kategori</p>
                                    <p class="text-gray-400 text-sm mt-1">Tambahkan kategori pertama Anda</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden divide-y divide-gray-200">
                @forelse ($categories as $category)
                    <div class="p-4 hover:bg-purple-50 transition-colors duration-150">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center flex-1">
                                <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-lg flex items-center justify-center shadow-md">
                                    <span class="text-white font-bold text-xl">{{ strtoupper(substr($category->name, 0, 1)) }}</span>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-base font-semibold text-gray-900">{{ $category->name }}</h3>
                                    <p class="text-xs text-gray-500">ID: {{ substr($category->id, 0, 8) }}...</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3 mb-3 text-sm bg-gray-50 rounded-lg p-3">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Dibuat</p>
                                <p class="text-sm font-medium text-gray-700">{{ $category->created_at->format('d M Y') }}</p>
                                <p class="text-xs text-gray-500">{{ $category->created_at->format('H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Diubah</p>
                                <p class="text-sm font-medium text-gray-700">{{ $category->updated_at->format('d M Y') }}</p>
                                <p class="text-xs text-gray-500">{{ $category->updated_at->format('H:i') }}</p>
                            </div>
                        </div>

                        @role('admin')
                        <div class="flex gap-2">
                            <a href="{{ route('categories.edit', $category->id) }}" 
                               class="flex-1 text-center px-3 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-md transition-colors">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </a>
                            <form action="{{ route('categories.destroy', $category->id) }}"
                                  method="POST"
                                  class="flex-1"
                                  onsubmit="return confirm('Yakin hapus kategori {{ $category->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button class="w-full px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-md transition-colors">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                        @endrole
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <p class="text-gray-500 font-medium">Belum ada kategori</p>
                        <p class="text-gray-400 text-sm mt-1">Tambahkan kategori pertama Anda</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $categories->links() }}
        </div>

    </div>
</div>

@push('styles')
<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}
</style>
@endpush
@endsection