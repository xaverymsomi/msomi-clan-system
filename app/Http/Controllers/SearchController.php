<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Tradition;
use App\Models\Event;
use App\Models\Announcement;
use App\Models\Document;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function global(Request $request)
    {
        $query = $request->input('q');
        
        if (empty($query)) {
            return back();
        }

        $results = [
            'members' => Member::where('first_name', 'like', "%{$query}%")
                ->orWhere('last_name', 'like', "%{$query}%")
                ->orWhere('middle_name', 'like', "%{$query}%")
                ->take(5)->get(),
                
            'traditions' => Tradition::where('title_sw', 'like', "%{$query}%")
                ->orWhere('title_en', 'like', "%{$query}%")
                ->orWhere('description_sw', 'like', "%{$query}%")
                ->orWhere('description_en', 'like', "%{$query}%")
                ->take(5)->get(),
                
            'events' => Event::where('title_sw', 'like', "%{$query}%")
                ->orWhere('title_en', 'like', "%{$query}%")
                ->orWhere('location', 'like', "%{$query}%")
                ->take(5)->get(),
                
            'announcements' => Announcement::where('title', 'like', "%{$query}%")
                ->orWhere('content', 'like', "%{$query}%")
                ->take(5)->get(),
                
            'documents' => Document::where('title', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->take(5)->get(),
        ];

        return view('search.results', compact('results', 'query'));
    }
}
