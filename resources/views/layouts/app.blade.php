<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Library System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Smooth transitions */
        * {
            transition-property: background-color, border-color, color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }

        /* Active menu item animation */
        .menu-item-active {
            position: relative;
        }
        .menu-item-active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 70%;
            background: linear-gradient(to bottom, #3B82F6, #1D4ED8);
            border-radius: 0 4px 4px 0;
        }

        /* Notification badge pulse */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }
        .notification-badge {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white text-black transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 flex flex-col shadow-xl">
            <!-- Sidebar Header -->
            <div class="relative h-20 px-6 bg-gradient-to-r from-blue-900 via-blue-800 to-blue-900 flex items-center justify-between overflow-hidden">
                <div class="absolute inset-0 bg-white opacity-5"></div>
                <div class="relative flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-book-open text-white text-xl"></i>
                    </div>
                    <div>
                        <span class="text-xl font-bold text-white block">Perpustakaan</span>
                        <span class="text-xs text-blue-200">Digital Library</span>
                    </div>
                </div>
                <button id="closeSidebar" class="lg:hidden text-blue-200 hover:text-white relative">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- User Role Badge -->
            <div class="px-4 py-3 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-100">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Role</span>
                    @role('admin')
                        <span class="px-3 py-1 bg-gradient-to-r from-purple-500 to-purple-600 text-white text-xs font-bold rounded-full shadow-sm">
                            <i class="fas fa-crown mr-1"></i> Admin
                        </span>
                    @else
                        <span class="px-3 py-1 bg-gradient-to-r from-green-500 to-green-600 text-white text-xs font-bold rounded-full shadow-sm">
                            <i class="fas fa-user mr-1"></i> User
                        </span>
                    @endrole
                </div>
            </div>
            
            <!-- Navigation Menu -->
            <nav class="flex-1 mt-2 px-3 overflow-y-auto">
                <div class="space-y-1">
                    <!-- Dashboard -->
                     @role('admin')
                    <a href="{{ route('dashboard') }}" @\
                       class="nav-link flex items-center px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:text-blue-600 rounded-lg transition-all mb-1 group relative"
                       data-page="dashboard">
                    @endrole
                    @role('user')
                       <a href="{{ route('users.dashboard') }}" @\
                       class="nav-link flex items-center px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:text-blue-600 rounded-lg transition-all mb-1 group relative"
                       data-page="dashboard">
                    @endrole
                        <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-100 group-hover:bg-blue-100 transition-colors">
                            <i class="fas fa-home text-gray-600 group-hover:text-blue-600"></i>
                        </div>
                        <span class="ml-3 font-medium">Dashboard</span>
                    </a>
                    
                    <!-- Books -->
                    <a href="{{ route('books.index') }}" 
                       class="nav-link flex items-center px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:text-blue-600 rounded-lg transition-all mb-1 group relative"
                       data-page="books">
                        <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-100 group-hover:bg-blue-100 transition-colors">
                            <i class="fas fa-book text-gray-600 group-hover:text-blue-600"></i>
                        </div>
                        <span class="ml-3 font-medium">Buku</span>
                    </a>
                    
                    <!-- Transactions -->
                    <a href="{{ route('transactions.index') }}" 
                       class="nav-link flex items-center px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:text-blue-600 rounded-lg transition-all mb-1 group relative"
                       data-page="transactions">
                        <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-100 group-hover:bg-blue-100 transition-colors">
                            <i class="fas fa-exchange-alt text-gray-600 group-hover:text-blue-600"></i>
                        </div>
                        @role('user')
                            <span class="ml-3 font-medium">Transaksiku</span>
                        @else
                            <span class="ml-3 font-medium">Transaksi</span>
                        @endrole
                    </a>

                    @role('admin')
                        <!-- Admin Section Divider -->
                        <div class="pt-4 pb-2 px-4">
                            <div class="flex items-center">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Admin Panel</span>
                                <div class="flex-1 ml-3 border-t border-gray-200"></div>
                            </div>
                        </div>

                        <!-- Categories -->
                        <a href="{{ route('categories.index') }}" 
                           class="nav-link flex items-center px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:text-blue-600 rounded-lg transition-all mb-1 group relative"
                           data-page="categories">
                            <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-100 group-hover:bg-blue-100 transition-colors">
                                <i class="fas fa-tags text-gray-600 group-hover:text-blue-600"></i>
                            </div>
                            <span class="ml-3 font-medium">Kategori</span>
                        </a>

                        <!-- Users Management -->
                        <a href="{{ route('users.index') }}" 
                           class="nav-link flex items-center px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:text-blue-600 rounded-lg transition-all mb-1 group relative"
                           data-page="users">
                            <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-100 group-hover:bg-blue-100 transition-colors">
                                <i class="fas fa-users text-gray-600 group-hover:text-blue-600"></i>
                            </div>
                            <span class="ml-3 font-medium">Kelola User</span>
                        </a>
                        
                        <!-- Audit Log -->
                        <a href="{{ route('audit.index') }}" 
                           class="nav-link flex items-center px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:text-blue-600 rounded-lg transition-all mb-1 group relative"
                           data-page="audit">
                            <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-100 group-hover:bg-blue-100 transition-colors">
                                <i class="fas fa-clipboard-list text-gray-600 group-hover:text-blue-600"></i>
                            </div>
                            <span class="ml-3 font-medium">Audit Log</span>
                        </a>
                        <a href="{{ route('admin.fines.index') }}" 
                        class="nav-link flex items-center px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:text-blue-600 rounded-lg transition-all mb-1 group relative"
                        data-page="fines">
                            <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-100 group-hover:bg-blue-100 transition-colors">
                                <i class="fas fa-money-bill-wave text-gray-600 group-hover:text-blue-600"></i>
                            </div>
                            <span class="ml-3 font-medium">Kelola Denda</span>
                        </a>
                    @endrole
                    @role('user')
                        <a href="{{ route('fines.index') }}" 
                        class="nav-link flex items-center px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:text-blue-600 rounded-lg transition-all mb-1 group relative"
                        data-page="fines">
                            <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-100 group-hover:bg-blue-100 transition-colors">
                                <i class="fas fa-money-bill-wave text-gray-600 group-hover:text-blue-600"></i>
                            </div>
                            <span class="ml-3 font-medium">Denda Saya</span>
                        </a>
                    @endrole
                </div>
            </nav>
            
            <!-- User Info and Logout at Bottom -->
            <div class="border-t border-gray-200 px-4 py-4 bg-gradient-to-r from-gray-50 to-blue-50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3 flex-1 min-w-0">
                        <div class="relative">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center flex-shrink-0 shadow-lg ring-2 ring-blue-200">
                                <span class="text-white font-bold text-sm">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                </span>
                            </div>
                            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">
                                {{ Auth::user()->name ?? 'User' }}
                            </p>
                            <p class="text-xs text-gray-500 truncate">
                                {{ Auth::user()->email ?? 'user@example.com' }}
                            </p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="flex-shrink-0">
                        @csrf
                        <button type="submit"
                                class="p-2.5 text-red-600 hover:bg-red-50 rounded-lg transition-all hover:shadow-md"
                                title="Logout"
                                onclick="return confirm('Yakin ingin keluar?')">
                            <i class="fas fa-sign-out-alt text-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Overlay for mobile -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden backdrop-blur-sm"></div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-md z-10 border-b border-gray-200">
                <div class="flex items-center justify-between px-4 lg:px-8 py-4">
                    <div class="flex items-center space-x-4">
                        <!-- Burger Menu Button -->
                        <button id="openSidebar" class="lg:hidden text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-300 rounded-lg p-2 transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <div>
                            <h1 class="text-xl lg:text-2xl font-bold text-gray-800">@yield('header', 'Dashboard')</h1>
                            <p class="text-xs text-gray-500 mt-0.5">@yield('subtitle', 'Sistem Manajemen Perpustakaan')</p>
                        </div>
                    </div>

                    <!-- Header Actions -->
                    <div class="flex items-center space-x-3">
                        <!-- Current Date/Time -->
                        <div class="hidden md:flex items-center space-x-2 px-4 py-2 bg-blue-50 rounded-lg">
                            <i class="fas fa-calendar-alt text-blue-600"></i>
                            <span class="text-sm font-medium text-blue-900" id="currentDateTime"></span>
                        </div>

                        <!-- User Avatar (Mobile) -->
                        <div class="lg:hidden">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center shadow">
                                <span class="text-white font-bold text-xs">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto bg-gradient-to-br from-gray-50 to-gray-100 p-4 lg:p-8">
                <!-- Flash Messages (moved here from content for consistency) -->
                @if (session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg mb-6 shadow-md animate-slide-in">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-check text-white"></i>
                            </div>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg mb-6 shadow-md animate-slide-in">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-exclamation-circle text-white"></i>
                            </div>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 px-4 py-3 rounded-lg mb-6 shadow-md animate-slide-in">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-exclamation-triangle text-white"></i>
                            </div>
                            <span class="font-medium">{{ session('warning') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('info'))
                    <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 px-4 py-3 rounded-lg mb-6 shadow-md animate-slide-in">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-info-circle text-white"></i>
                            </div>
                            <span class="font-medium">{{ session('info') }}</span>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 py-4 shadow-inner">
                <div class="px-4 lg:px-8">
                    <div class="flex flex-col md:flex-row items-center justify-between text-sm text-gray-600">
                        <div class="flex items-center space-x-2 mb-2 md:mb-0">
                            <i class="fas fa-copyright text-gray-400"></i>
                            <span>2024 Library System. All rights reserved.</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-gray-400">v1.0.0</span>
                            <span class="text-gray-300">|</span>
                            <span>Made with <i class="fas fa-heart text-red-500"></i> by Dev Team</span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Back to Top Button -->
    <button id="backToTop" 
            class="fixed bottom-8 right-8 w-12 h-12 bg-blue-600 text-white rounded-full shadow-lg hover:bg-blue-700 transition-all transform hover:scale-110 hidden z-50">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
        // Sidebar toggle functionality
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const openBtn = document.getElementById('openSidebar');
        const closeBtn = document.getElementById('closeSidebar');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        openBtn?.addEventListener('click', openSidebar);
        closeBtn?.addEventListener('click', closeSidebar);
        overlay?.addEventListener('click', closeSidebar);

        // Close sidebar on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeSidebar();
            }
        });

        // Highlight active menu item
        const currentPath = window.location.pathname;
        document.querySelectorAll('.nav-link').forEach(link => {
            const href = link.getAttribute('href');
            if (href && (currentPath === href || currentPath.startsWith(href + '/'))) {
                link.classList.add('menu-item-active', 'bg-gradient-to-r', 'from-blue-50', 'to-indigo-50', 'text-blue-600', 'shadow-sm');
                const icon = link.querySelector('i');
                const iconBox = link.querySelector('div');
                if (icon) icon.classList.add('text-blue-600');
                if (iconBox) {
                    iconBox.classList.remove('bg-gray-100');
                    iconBox.classList.add('bg-blue-100');
                }
            }
        });

        // Current date and time
        function updateDateTime() {
            const now = new Date();
            const options = { 
                weekday: 'short', 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };
            const dateTimeString = now.toLocaleDateString('id-ID', options);
            const dateTimeElement = document.getElementById('currentDateTime');
            if (dateTimeElement) {
                dateTimeElement.textContent = dateTimeString;
            }
        }
        
        updateDateTime();
        setInterval(updateDateTime, 60000); // Update every minute

        // Back to top button
        const backToTopBtn = document.getElementById('backToTop');
        const mainContent = document.querySelector('main');
        
        if (mainContent && backToTopBtn) {
            mainContent.addEventListener('scroll', () => {
                if (mainContent.scrollTop > 300) {
                    backToTopBtn.classList.remove('hidden');
                } else {
                    backToTopBtn.classList.add('hidden');
                }
            });

            backToTopBtn.addEventListener('click', () => {
                mainContent.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }

        // Auto-hide flash messages after 5 seconds
        setTimeout(() => {
            const flashMessages = document.querySelectorAll('.animate-slide-in');
            flashMessages.forEach(message => {
                message.style.transition = 'opacity 0.5s, transform 0.5s';
                message.style.opacity = '0';
                message.style.transform = 'translateX(100%)';
                setTimeout(() => message.remove(), 500);
            });
        }, 5000);
    </script>

    <style>
        @keyframes slide-in {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .animate-slide-in {
            animation: slide-in 0.3s ease-out;
        }
    </style>

    @stack('scripts')
</body>
</html>