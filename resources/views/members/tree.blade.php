@extends('layouts.admin')

@section('header')
    {{ __('members.family_tree') }}
@endsection

@section('content')
    <style>
        .tree ul {
            padding-top: 20px; position: relative;
            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        .tree li {
            float: left; text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 5px 0 5px;
            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        .tree li::before, .tree li::after{
            content: '';
            position: absolute; top: 0; right: 50%;
            border-top: 1px solid #ccc;
            width: 50%; height: 20px;
        }

        .tree li::after{
            right: auto; left: 50%;
            border-left: 1px solid #ccc;
        }

        .tree li:only-child::after, .tree li:only-child::before {
            display: none;
        }

        .tree li:only-child{ padding-top: 0;}

        .tree li:first-child::before, .tree li:last-child::after{
            border: 0 none;
        }

        .tree li:last-child::before{
            border-right: 1px solid #ccc;
            border-radius: 0 5px 0 0;
            -webkit-border-radius: 0 5px 0 0;
            -moz-border-radius: 0 5px 0 0;
        }
        .tree li:first-child::after{
            border-radius: 5px 0 0 0;
            -webkit-border-radius: 5px 0 0 0;
            -moz-border-radius: 5px 0 0 0;
        }

        .tree ul ul::before{
            content: '';
            position: absolute; top: 0; left: 50%;
            border-left: 1px solid #ccc;
            width: 0; height: 20px;
        }

        .tree li a {
            border: 1px solid #ccc;
            padding: 10px 15px;
            text-decoration: none;
            color: #666;
            font-family: arial, verdana, tahoma;
            font-size: 14px;
            display: inline-block;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
            background-color: white;
        }

        .tree li a:hover, .tree li a:hover+ul li a {
            background: #c8e4f8; color: #000; border: 1px solid #94a0b4;
        }

        .tree li a:hover+ul li::after, 
        .tree li a:hover+ul li::before, 
        .tree li a:hover+ul::before, 
        .tree li a:hover+ul ul::before{
            border-color:  #94a0b4;
        }
        
        /* Specific Styles */
        .member-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 120px;
        }
        .member-photo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 5px;
            border: 2px solid #ddd;
        }
        .current-member {
            background-color: #f3e8ff !important; /* purple-100 */
            border-color: #d8b4fe !important; /* purple-300 */
            color: #6b21a8 !important; /* purple-800 */
            font-weight: bold;
        }
    </style>

    <div class="mb-6 flex justify-between items-center no-print">
        <a href="{{ route('members.index') }}" class="text-purple-600 hover:text-purple-800 flex items-center transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            {{ __('messages.back') }}
        </a>
        <button onclick="window.print()" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded shadow transition-colors flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
            </svg>
            {{ __('messages.print') }}
        </button>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-auto p-8 min-h-[500px] flex justify-center">
        <div class="tree">
            <ul>
                <li>
                    <!-- Parents -->
                    @if($root->father || $root->mother)
                    <div class="flex justify-center space-x-8 mb-8 border-b border-dashed pb-4">
                        @if($root->father)
                            <a href="{{ route('members.tree', $root->father->id) }}" class="member-card">
                                @if($root->father->profile_photo)
                                    <img src="{{ Storage::url($root->father->profile_photo) }}" alt="{{ $root->father->first_name }}" class="member-photo">
                                @else
                                    <div class="member-photo bg-gray-200 flex items-center justify-center text-gray-500 font-bold">
                                        {{ substr($root->father->first_name, 0, 1) }}
                                    </div>
                                @endif
                                <span>{{ $root->father->first_name }} ({{ __('members.father') }})</span>
                            </a>
                        @endif
                        @if($root->mother)
                            <a href="{{ route('members.tree', $root->mother->id) }}" class="member-card">
                                @if($root->mother->profile_photo)
                                    <img src="{{ Storage::url($root->mother->profile_photo) }}" alt="{{ $root->mother->first_name }}" class="member-photo">
                                @else
                                    <div class="member-photo bg-gray-200 flex items-center justify-center text-gray-500 font-bold">
                                        {{ substr($root->mother->first_name, 0, 1) }}
                                    </div>
                                @endif
                                <span>{{ $root->mother->first_name }} ({{ __('members.mother') }})</span>
                            </a>
                        @endif
                    </div>
                    @endif

                    <!-- Current Member (Root of this view) -->
                    <a href="#" class="member-card current-member">
                        @if($root->profile_photo)
                            <img src="{{ Storage::url($root->profile_photo) }}" alt="{{ $root->first_name }}" class="member-photo" style="border-color: #a855f7;">
                        @else
                            <div class="member-photo bg-purple-200 flex items-center justify-center text-purple-700 font-bold" style="border-color: #a855f7;">
                                {{ substr($root->first_name, 0, 1) }}
                            </div>
                        @endif
                        <span>{{ $root->full_name }}</span>
                    </a>

                    <!-- Children -->
                    @if($root->children->count() > 0)
                        <ul>
                            @foreach($root->children as $child)
                                <li>
                                    <a href="{{ route('members.tree', $child->id) }}" class="member-card">
                                        @if($child->profile_photo)
                                            <img src="{{ Storage::url($child->profile_photo) }}" alt="{{ $child->first_name }}" class="member-photo">
                                        @else
                                            <div class="member-photo bg-gray-200 flex items-center justify-center text-gray-500 font-bold">
                                                {{ substr($child->first_name, 0, 1) }}
                                            </div>
                                        @endif
                                        <span>{{ $child->first_name }}</span>
                                    </a>
                                    
                                    <!-- Grandchildren (Optional, showing one level deep) -->
                                    @if($child->children->count() > 0)
                                        <ul>
                                            @foreach($child->children as $grandchild)
                                                <li>
                                                    <a href="{{ route('members.tree', $grandchild->id) }}" class="member-card">
                                                        <span>{{ $grandchild->first_name }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            </ul>
        </div>
    </div>
@endsection
