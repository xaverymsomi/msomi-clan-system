<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use App\Models\Tradition;
use App\Models\Event;
use App\Models\Announcement;
use App\Models\Document;
use App\Models\Contribution;
use App\Models\Conversation;
use App\Models\Message;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Comprehensive statistics
        $stats = [
            'members_count' => Member::count(),
            'active_members' => Member::where('membership_status', 'active')->count(),
            'traditions_count' => Tradition::where('status', 'published')->count(),
            'upcoming_events_count' => Event::upcoming()->count(),
            'documents_count' => Document::count(),
            'active_announcements' => Announcement::active()->count(),
            'recent_registrations' => Member::where('created_at', '>=', now()->subDays(30))->count(),
        ];

        // User's personal contribution total (if member linked)
        $myContributions = 0;
        if ($user->member) {
            $myContributions = Contribution::where('member_id', $user->member->id)
                ->where('status', 'completed')
                ->sum('amount');
        }
        $stats['my_contributions'] = $myContributions;

        // Financial overview
        $financialStats = [
            'total_collected' => Contribution::where('status', 'completed')->sum('amount'),
            'this_month' => Contribution::where('status', 'completed')
                ->whereMonth('payment_date', now()->month)
                ->whereYear('payment_date', now()->year)
                ->sum('amount'),
            'pending' => Contribution::where('status', 'pending')->sum('amount'),
            'total_contributors' => Contribution::distinct('member_id')->count('member_id'),
        ];

        // Top contributors (last 3 months)
        $topContributors = Contribution::select('member_id', DB::raw('SUM(amount) as total'))
            ->where('status', 'completed')
            ->where('payment_date', '>=', now()->subMonths(3))
            ->groupBy('member_id')
            ->orderByDesc('total')
            ->limit(5)
            ->with('member')
            ->get();

        // Chart data: Member growth (last 6 months)
        $memberGrowthData = [];
        $memberGrowthLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $memberGrowthLabels[] = $date->format('M');
            $memberGrowthData[] = Member::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // Chart data: Contributions by type
        $contributionsByType = [
            'dues' => Contribution::where('contribution_type', 'dues')->where('status', 'completed')->sum('amount'),
            'event' => Contribution::where('contribution_type', 'event')->where('status', 'completed')->sum('amount'),
            'project' => Contribution::where('contribution_type', 'project')->where('status', 'completed')->sum('amount'),
            'donation' => Contribution::where('contribution_type', 'donation')->where('status', 'completed')->sum('amount'),
        ];

        // Chart data: Events by month (next 6 months)
        $eventTimelineData = [];
        $eventTimelineLabels = [];
        for ($i = 0; $i < 6; $i++) {
            $date = now()->addMonths($i);
            $eventTimelineLabels[] = $date->format('M');
            $eventTimelineData[] = Event::whereYear('start_date', $date->year)
                ->whereMonth('start_date', $date->month)
                ->count();
        }

        // Chart data: Document categories
        $documentCategories = Document::select('category_id', DB::raw('COUNT(*) as count'))
            ->groupBy('category_id')
            ->with('category')
            ->get();

        // Recent activity feed
        $recentAnnouncements = Announcement::active()
            ->with('creator')
            ->latest()
            ->take(3)
            ->get();

        $recentDocuments = Document::with('category', 'uploader')
            ->latest()
            ->take(3)
            ->get();

        $recentTraditions = Tradition::where('status', 'published')
            ->with('category')
            ->latest()
            ->take(3)
            ->get();

        $upcomingEvents = Event::upcoming()
            ->take(5)
            ->get();

        $recentMembers = Member::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Quick stats
        $unreadMessagesCount = Conversation::forUser($user)
            ->get()
            ->filter(fn($conv) => $conv->hasUnread($user))
            ->count();

        $quickStats = [
            'today_events' => Event::whereDate('start_date', today())->count(),
            'urgent_announcements' => Announcement::active()->where('category', 'urgent')->count(),
            'pending_contributions_count' => Contribution::where('status', 'pending')->count(),
            'unread_messages' => $unreadMessagesCount,
        ];

        return view('dashboard', compact(
            'user',
            'stats',
            'financialStats',
            'topContributors',
            'memberGrowthData',
            'memberGrowthLabels',
            'contributionsByType',
            'eventTimelineData',
            'eventTimelineLabels',
            'documentCategories',
            'recentAnnouncements',
            'recentDocuments',
            'recentTraditions',
            'upcomingEvents',
            'recentMembers',
            'quickStats'
        ));
    }
}
