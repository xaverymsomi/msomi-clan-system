@extends('layouts.admin')

@section('header')
    {{ __('messages.dashboard') }}
@endsection

@section('content')
    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <!-- Members Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 border-l-4 border-blue-500">
            <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <p class="mb-1 text-sm font-medium text-gray-600">{{ __('members.members') }}</p>
                <p class="text-2xl font-bold text-gray-700">{{ $stats['members_count'] }}</p>
                <p class="text-xs text-gray-500">{{ $stats['active_members'] }} {{ __('members.active') }}</p>
            </div>
        </div>
        
        <!-- Traditions Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 border-l-4 border-purple-500">
            <div class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <div>
                <p class="mb-1 text-sm font-medium text-gray-600">{{ __('traditions.traditions') }}</p>
                <p class="text-2xl font-bold text-gray-700">{{ $stats['traditions_count'] }}</p>
                <p class="text-xs text-gray-500">{{ __('traditions.published') }}</p>
            </div>
        </div>
        
        <!-- Events Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 border-l-4 border-green-500">
            <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <p class="mb-1 text-sm font-medium text-gray-600">{{ __('events.upcoming_events') }}</p>
                <p class="text-2xl font-bold text-gray-700">{{ $stats['upcoming_events_count'] }}</p>
                <p class="text-xs text-gray-500">{{ $quickStats['today_events'] }} {{ __('events.today') }}</p>
            </div>
        </div>

        <!-- My Contributions Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 border-l-4 border-orange-500">
            <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="mb-1 text-sm font-medium text-gray-600">{{ __('contributions.my_contributions') }}</p>
                <p class="text-2xl font-bold text-gray-700">KES {{ number_format($stats['my_contributions']) }}</p>
                <a href="{{ route('contributions.my') }}" class="text-xs text-orange-600 hover:underline">{{ __('messages.view_details') }}</a>
            </div>
        </div>
    </div>

    <!-- Secondary Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-indigo-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">{{ __('messages.messages') }}</p>
                    <p class="text-xl font-bold text-gray-700">{{ $quickStats['unread_messages'] }}</p>
                    <a href="{{ route('messages.index') }}" class="text-xs text-indigo-600 hover:underline">{{ __('messages.unread') }}</a>
                </div>
                <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-indigo-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">{{ __('documents.documents') }}</p>
                    <p class="text-xl font-bold text-gray-700">{{ $stats['documents_count'] }}</p>
                </div>
                <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">{{ __('announcements.announcements') }}</p>
                    <p class="text-xl font-bold text-gray-700">{{ $stats['active_announcements'] }}</p>
                    @if($quickStats['urgent_announcements'] > 0)
                        <p class="text-xs text-red-600 font-semibold">{{ $quickStats['urgent_announcements'] }} {{ __('announcements.urgent') }}</p>
                    @endif
                </div>
                <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-teal-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">{{ __('members.new_members') }}</p>
                    <p class="text-xl font-bold text-gray-700">{{ $stats['recent_registrations'] }}</p>
                    <p class="text-xs text-gray-500">{{ __('members.last_30_days') }}</p>
                </div>
                <svg class="w-8 h-8 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('messages.quick_actions') }}</h3>
        <div class="flex flex-wrap gap-3">
            @can('create', App\Models\Event::class)
                <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    {{ __('events.create_event') }}
                </a>
            @endcan
            @can('create', App\Models\Announcement::class)
                <a href="{{ route('announcements.create') }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium rounded-md transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                    {{ __('announcements.create_announcement') }}
                </a>
            @endcan
            @can('create', App\Models\Document::class)
                <a href="{{ route('documents.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    {{ __('documents.upload_document') }}
                </a>
            @endcan
            @can('create', App\Models\Contribution::class)
                <a href="{{ route('contributions.create') }}" class="inline-flex items-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium rounded-md transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ __('contributions.record_contribution') }}
                </a>
            @endcan
            <a href="{{ route('contributions.my') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                {{ __('contributions.my_contributions') }}
            </a>
            <a href="{{ route('messages.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                {{ __('messages.new_message') }}
            </a>
        </div>
    </div>

    <!-- Financial Overview & Recent Activity -->
    <div class="grid gap-6 mb-8 md:grid-cols-2">
        <!-- Financial Overview -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">{{ __('contributions.financial_overview') }}</h3>
                <a href="{{ route('contributions.index') }}" class="text-sm text-indigo-600 hover:underline">{{ __('messages.view_all') }}</a>
            </div>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                    <span class="text-sm font-medium text-gray-700">{{ __('contributions.total_collected') }}</span>
                    <span class="text-lg font-bold text-green-600">KES {{ number_format($financialStats['total_collected']) }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                    <span class="text-sm font-medium text-gray-700">{{ __('contributions.this_month') }}</span>
                    <span class="text-lg font-bold text-blue-600">KES {{ number_format($financialStats['this_month']) }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-yellow-50 rounded-lg">
                    <span class="text-sm font-medium text-gray-700">{{ __('contributions.pending') }}</span>
                    <span class="text-lg font-bold text-yellow-600">KES {{ number_format($financialStats['pending']) }}</span>
                </div>
            </div>

            @if($topContributors->count() > 0)
                <div class="mt-6">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">{{ __('contributions.top_contributors') }} ({{ __('contributions.last_3_months') }})</h4>
                    <ul class="space-y-2">
                        @foreach($topContributors as $contributor)
                            <li class="flex justify-between items-center text-sm">
                                <span class="text-gray-700">{{ $contributor->member->first_name }} {{ $contributor->member->last_name }}</span>
                                <span class="font-semibold text-gray-900">KES {{ number_format($contributor->total) }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Recent Activity Feed -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('messages.recent_activity') }}</h3>
            <div class="space-y-4 max-h-96 overflow-y-auto">
                @foreach($recentAnnouncements as $announcement)
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $announcement->title }}</p>
                            <p class="text-xs text-gray-500">{{ $announcement->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach

                @foreach($recentDocuments as $document)
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $document->title }}</p>
                            <p class="text-xs text-gray-500">{{ $document->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach

                @foreach($recentMembers->take(3) as $member)
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $member->first_name }} {{ $member->last_name }} {{ __('members.joined') }}</p>
                            <p class="text-xs text-gray-500">{{ $member->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid gap-6 mb-8 md:grid-cols-2">
        <!-- Member Growth Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h4 class="mb-4 font-semibold text-gray-800">{{ __('members.member_growth') }}</h4>
            <div class="relative h-64">
                <canvas id="membersChart"></canvas>
            </div>
        </div>
        
        <!-- Contributions by Type Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h4 class="mb-4 font-semibold text-gray-800">{{ __('contributions.by_type') }}</h4>
            <div class="relative h-64 flex justify-center">
                <canvas id="contributionsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Upcoming Events Table -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="flex justify-between items-center mb-4">
            <h4 class="font-semibold text-gray-800">{{ __('events.upcoming_events') }}</h4>
            <a href="{{ route('events.index') }}" class="text-sm text-indigo-600 hover:underline">{{ __('messages.view_all') }}</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-xs font-semibold text-left text-gray-500 uppercase border-b">
                        <th class="px-4 py-3">{{ __('events.title') }}</th>
                        <th class="px-4 py-3">{{ __('events.date') }}</th>
                        <th class="px-4 py-3">{{ __('events.location') }}</th>
                        <th class="px-4 py-3">{{ __('events.attendees') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($upcomingEvents as $event)
                    <tr class="text-gray-700">
                        <td class="px-4 py-3">
                            <a href="{{ route('events.show', $event) }}" class="font-semibold text-indigo-600 hover:underline">{{ $event->title }}</a>
                        </td>
                        <td class="px-4 py-3 text-sm">{{ $event->start_date->format('M d, Y') }}</td>
                        <td class="px-4 py-3 text-sm">{{ $event->location }}</td>
                        <td class="px-4 py-3 text-sm">{{ $event->attendees->count() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-500">{{ __('events.no_upcoming_events') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Chart Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Member Growth Chart
            const ctxMembers = document.getElementById('membersChart').getContext('2d');
            new Chart(ctxMembers, {
                type: 'line',
                data: {
                    labels: @json($memberGrowthLabels),
                    datasets: [{
                        label: '{{ __("members.new_members") }}',
                        backgroundColor: 'rgba(124, 58, 237, 0.1)',
                        borderColor: '#7c3aed',
                        data: @json($memberGrowthData),
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: true } },
                    scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                }
            });

            // Contributions by Type Chart
            const ctxContributions = document.getElementById('contributionsChart').getContext('2d');
            new Chart(ctxContributions, {
                type: 'doughnut',
                data: {
                    labels: ['{{ __("contributions.dues") }}', '{{ __("contributions.event") }}', '{{ __("contributions.project") }}', '{{ __("contributions.donation") }}'],
                    datasets: [{
                        data: [
                            {{ $contributionsByType['dues'] }},
                            {{ $contributionsByType['event'] }},
                            {{ $contributionsByType['project'] }},
                            {{ $contributionsByType['donation'] }}
                        ],
                        backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444'],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        });
    </script>
@endsection
