@extends('layouts.admin')

@section('header')
    {{ __('messages.audit_logs') ?? 'Audit Logs' }}
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6 border-b border-gray-200 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h2 class="text-xl font-semibold text-gray-800">{{ __('messages.system_activity') ?? 'System Activity' }}</h2>
        
        <form action="{{ route('admin.activity-logs.index') }}" method="GET" class="flex flex-wrap gap-2">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="{{ __('messages.search_logs') ?? 'Search logs...' }}"
                   class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md text-sm transition-colors">
                {{ __('messages.search') }}
            </button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('messages.date') }}</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('messages.user') }}</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('messages.action') }}</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('messages.subject') }}</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('messages.details') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($activities as $activity)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $activity->created_at->format('Y-m-d H:i') }}
                            <div class="text-xs opacity-70">{{ $activity->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs mr-3">
                                    {{ $activity->causer ? substr($activity->causer->name, 0, 1) : 'S' }}
                                </div>
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $activity->causer->name ?? 'System' }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $activity->description === 'created' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $activity->description === 'updated' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $activity->description === 'deleted' ? 'bg-red-100 text-red-800' : '' }}
                                {{ !in_array($activity->description, ['created', 'updated', 'deleted']) ? 'bg-gray-100 text-gray-800' : '' }}">
                                {{ ucfirst($activity->description) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if($activity->subject_type)
                                <span class="font-medium">{{ class_basename($activity->subject_type) }}</span>
                                @if($activity->subject_id)
                                    <span class="text-gray-400">#{{ $activity->subject_id }}</span>
                                @endif
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            @if($activity->changes())
                                <div class="max-w-xs truncate" title="{{ json_encode($activity->changes()) }}">
                                    @php 
                                        $changes = $activity->changes();
                                        $attributes = $changes['attributes'] ?? [];
                                        $old = $changes['old'] ?? [];
                                    @endphp
                                    @foreach($attributes as $key => $value)
                                        @if($key !== 'updated_at')
                                            <div class="truncate">
                                                <span class="font-semibold">{{ $key }}:</span> 
                                                @if(isset($old[$key]))
                                                    <span class="text-red-400 line-through">{{ is_array($old[$key]) ? '...' : $old[$key] }}</span> →
                                                @endif
                                                <span class="text-green-600">{{ is_array($value) ? '...' : $value }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @elseif($activity->description === 'created')
                                <span class="italic text-gray-400">{{ __('messages.initial_creation') ?? 'Initial creation' }}</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <p class="text-lg font-medium">{{ __('messages.no_activity_found') ?? 'No system activity found.' }}</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($activities->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $activities->links() }}
        </div>
    @endif
</div>
@endsection
