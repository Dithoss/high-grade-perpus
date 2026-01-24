@extends('layouts.app')

@section('title', 'Audit Log')
@section('header', 'Audit Log')

@section('content')
<div>
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl shadow-lg p-6 mb-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">System Activity Monitor</h2>
                <p class="text-purple-100">Track all user actions and system events</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-clipboard-list text-6xl opacity-20"></i>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Logs</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $logs->total() }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <i class="fas fa-list text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Today</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $logs->where('created_at', '>=', today())->count() }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <i class="fas fa-calendar-day text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">This Week</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $logs->where('created_at', '>=', now()->startOfWeek())->count() }}</p>
                </div>
                <div class="bg-yellow-100 rounded-full p-3">
                    <i class="fas fa-calendar-week text-yellow-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Active Users</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $logs->pluck('user_id')->unique()->count() }}</p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <i class="fas fa-users text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Audit Log Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800">Activity Timeline</h3>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500">
                        <i class="fas fa-filter mr-1"></i>
                        Filter options coming soon
                    </span>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="fas fa-user mr-2"></i>User
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="fas fa-bolt mr-2"></i>Action
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="fas fa-bullseye mr-2"></i>Target
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="fas fa-info-circle mr-2"></i>Description
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <i class="fas fa-clock mr-2"></i>Timestamp
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($logs as $log)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $log->user->name ?? 'System' }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $log->user->email ?? 'system@library.com' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $actionColors = [
                                    'create' => 'bg-green-100 text-green-800 border-green-200',
                                    'update' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'delete' => 'bg-red-100 text-red-800 border-red-200',
                                    'restore' => 'bg-purple-100 text-purple-800 border-purple-200',
                                    'login' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                    'logout' => 'bg-gray-100 text-gray-800 border-gray-200',
                                ];
                                $actionIcons = [
                                    'create' => 'fa-plus-circle',
                                    'update' => 'fa-edit',
                                    'delete' => 'fa-trash',
                                    'restore' => 'fa-undo',
                                    'login' => 'fa-sign-in-alt',
                                    'logout' => 'fa-sign-out-alt',
                                ];
                                $action = strtolower($log->action);
                                $colorClass = $actionColors[$action] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                $iconClass = $actionIcons[$action] ?? 'fa-circle';
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $colorClass }}">
                                <i class="fas {{ $iconClass }} mr-1"></i>
                                {{ strtoupper($log->action) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @php
                                    $targetIcons = [
                                        'Book' => 'fa-book',
                                        'Transaction' => 'fa-exchange-alt',
                                        'Category' => 'fa-tags',
                                        'User' => 'fa-user',
                                    ];
                                    $target = class_basename($log->target_type);
                                    $targetIcon = $targetIcons[$target] ?? 'fa-cube';
                                @endphp
                                <i class="fas {{ $targetIcon }} text-gray-400 mr-2"></i>
                                <span class="text-sm font-medium text-gray-900">{{ $target }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-md">
                                {{ $log->description }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex flex-col">
                                <span class="font-medium text-gray-700">
                                    {{ $log->created_at->format('d M Y') }}
                                </span>
                                <span class="text-xs text-gray-500">
                                    {{ $log->created_at->format('H:i:s') }}
                                </span>
                                <span class="text-xs text-gray-400">
                                    {{ $log->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                                <p class="text-gray-500 text-lg font-medium">No audit logs found</p>
                                <p class="text-gray-400 text-sm mt-1">Activity logs will appear here</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection