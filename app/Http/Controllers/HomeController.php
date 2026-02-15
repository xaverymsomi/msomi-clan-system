<?php

namespace App\Http\Controllers;

use App\Models\Tradition;
use App\Models\Event;
use App\Models\Announcement;
use App\Models\Member;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured traditions
        $traditions = Tradition::published()
            ->latest()
            ->take(6)
            ->get();

        // Get upcoming events
        $events = Event::upcoming()
            ->orderBy('start_date')
            ->take(4)
            ->get();

        // Get latest announcements
        $announcements = Announcement::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where(function($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        // Get member statistics
        $stats = [
            'total_members' => Member::active()->count(),
            'total_traditions' => Tradition::published()->count(),
            'upcoming_events' => Event::upcoming()->count(),
        ];

        return view('welcome', compact('traditions', 'events', 'announcements', 'stats'));
    }
}
