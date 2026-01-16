<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <!-- Logo/Header Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-2xl shadow-lg mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Buat Akun Baru</h2>
            <p class="text-gray-600">Bergabunglah dengan perpustakaan digital kami</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-4 shadow-sm">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-red-800 mb-1">Terdapat beberapa kesalahan:</h3>
                        <ul class="text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span>{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Registration Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <form method="POST" action="{{ route('register.store') }}" class="p-8 space-y-6">
                @csrf

                <!-- Name Field -->
                <div class="group">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            id="name"
                            name="name" 
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap Anda"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 outline-none hover:border-gray-400"
                            required>
                    </div>
                </div>

                <!-- Email Field -->
                <div class="group">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                        </div>
                        <input 
                            type="email" 
                            id="email"
                            name="email" 
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 outline-none hover:border-gray-400"
                            required>
                    </div>
                </div>

                <!-- Password Field -->
                <div class="group">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input 
                            type="password" 
                            id="password"
                            name="password" 
                            placeholder="Minimal 8 karakter"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 outline-none hover:border-gray-400"
                            required>
                    </div>
                </div>

                <!-- Password Confirmation Field -->
                <div class="group">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                        Konfirmasi Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <input 
                            type="password" 
                            id="password_confirmation"
                            name="password_confirmation" 
                            placeholder="Ketik ulang password Anda"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 outline-none hover:border-gray-400"
                            required>
                    </div>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Daftar Sekarang
                </button>
            </form>

            <!-- Footer Section -->
            <div class="px-8 py-6 bg-gray-50 border-t border-gray-100">
                <p class="text-center text-sm text-gray-600">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-500">
                Dengan mendaftar, Anda menyetujui 
                <a href="#" class="text-blue-600 hover:underline">Syarat & Ketentuan</a> 
                dan 
                <a href="#" class="text-blue-600 hover:underline">Kebijakan Privasi</a>
            </p>
        </div>
    </div>

</body>
</html>