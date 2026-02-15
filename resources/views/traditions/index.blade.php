@extends('layouts.admin')

@section('header')
    {{ __('traditions.customs_and_traditions') }}
@endsection

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                {{ __('traditions.explore_our_heritage') }}
            </h2>
        </div>
        @can('create', App\Models\Tradition::class)
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <a href="{{ route('traditions.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                {{ __('traditions.add_new_tradition') }}
            </a>
        </div>
        @endcan
    </div>

    <!-- Filters -->
    <div class="mb-8 bg-white p-4 rounded-lg shadow-sm border border-gray-100">
        <form action="{{ route('traditions.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="col-span-1 md:col-span-1">
                <select name="category" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm" onchange="this.form.submit()">
                    <option value="">{{ __('traditions.all_categories') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-1 md:col-span-2">
                <div class="relative rounded-md shadow-sm">
                    <input type="text" name="search" value="{{ request('search') }}" class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-4 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="{{ __('traditions.search_placeholder') }}">
                    <div class="absolute inset-y-0 right-0 flex items-center">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-r-md">
                            {{ __('messages.search') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Categories Grid -->
    @if(!request('category') && !request('search'))
    <div class="mb-10">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">{{ __('traditions.browse_by_category') }}</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($categories as $category)
                <a href="{{ route('traditions.index', ['category' => $category->id]) }}" class="group relative bg-white rounded-xl shadow-sm hover:shadow-md transition-all p-6 flex flex-col items-center justify-center text-center border-2 border-transparent hover:border-{{ $category->color ?? 'gray' }}-500">
                    <div class="h-12 w-12 rounded-full bg-{{ $category->color ?? 'purple' }}-100 text-{{ $category->color ?? 'purple' }}-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <!-- Icon Placeholder -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <span class="font-medium text-gray-900 group-hover:text-{{ $category->color ?? 'purple' }}-700">{{ $category->name }}</span>
                    <span class="text-xs text-gray-500 mt-1">{{ $category->traditions_count ?? 0 }} {{ __('traditions.items') }}</span>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Traditions Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($traditions as $tradition)
            <article class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow overflow-hidden flex flex-col h-full border border-gray-100">
                <a href="{{ route('traditions.show', $tradition) }}" class="block relative h-48 bg-gray-200 overflow-hidden">
                    @if($tradition->featured_image)
                        <img src="{{ Storage::url($tradition->featured_image) }}" alt="{{ $tradition->title }}" class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-purple-500 to-indigo-600 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    @endif
                    <div class="absolute top-4 right-4 bg-white px-2 py-1 rounded-md text-xs font-bold text-gray-800 shadow-sm uppercase tracking-wider">
                        {{ $tradition->category->name }}
                    </div>
                </a>
                
                <div class="p-6 flex-1 flex flex-col">
                    <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">
                        <a href="{{ route('traditions.show', $tradition) }}" class="hover:text-purple-600 transition-colors">
                            {{ $tradition->title }}
                        </a>
                    </h3>
                    <p class="text-gray-600 mb-4 line-clamp-3 flex-1 text-sm">
                        {{ $tradition->description }}
                    </p>
                    
                    <div class="mt-auto border-t border-gray-100 pt-4 flex items-center justify-between text-xs text-gray-500">
                        <div class="flex items-center space-x-2">
                             <span>{{ $tradition->created_at->format('M d, Y') }}</span>
                             <span>&bull;</span>
                             <span>{{ $tradition->views_count }} {{ __('traditions.views') }}</span>
                        </div>
                        <a href="{{ route('traditions.show', $tradition) }}" class="text-purple-600 font-semibold hover:text-purple-800">
                            {{ __('traditions.read_more') }} &rarr;
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-1 md:col-span-3 text-center py-12 bg-white rounded-lg shadow-sm">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('traditions.no_traditions_found') }}</h3>
                <p class="mt-1 text-sm text-gray-500">{{ __('traditions.try_adjusting_filters') }}</p>
                @can('create', App\Models\Tradition::class)
                <div class="mt-6">
                    <a href="{{ route('traditions.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        {{ __('traditions.add_new_tradition') }}
                    </a>
                </div>
                @endcan
            </div>
        @endforelse
    </div>
    
    <div class="mt-8">
        {{ $traditions->links() }}
    </div>
@endsection
