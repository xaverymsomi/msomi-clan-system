<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AnnouncementController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Announcement::with(['creator'])->active();

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        // Filter by priority
        if ($request->has('priority') && $request->priority) {
            $query->byPriority($request->priority);
        } else {
            // Default: order by priority (high first)
            $query->byPriority();
        }

        // Get urgent announcements separately (pinned at top)
        $urgentAnnouncements = Announcement::active()
            ->urgent()
            ->with(['creator'])
            ->latest()
            ->take(3)
            ->get();

        $announcements = $query->latest()->paginate(10);

        return view('announcements.index', compact('announcements', 'urgentAnnouncements'));
    }

    public function show(Announcement $announcement)
    {
        $this->authorize('view', $announcement);
        
        $announcement->load(['creator', 'comments.user', 'comments.replies.user']);
        
        return view('announcements.show', compact('announcement'));
    }

    public function create()
    {
        $this->authorize('create', Announcement::class);
        
        return view('announcements.create');
    }

    public function store(Request $request, NotificationService $notificationService)
    {
        $this->authorize('create', Announcement::class);

        $validated = $request->validate([
            'title_sw' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'content_sw' => 'required|string',
            'content_en' => 'required|string',
            'category' => 'required|in:general,urgent,event,financial',
            'priority' => 'required|in:low,medium,high',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:published_at',
        ]);

        $validated['created_by'] = auth()->id();
        
        // If no publish date set, publish immediately
        if (!isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $announcement = Announcement::create($validated);

        // Notify all users about the new announcement if it's published now
        if ($announcement->isPublished()) {
            $users = User::all();
            $notificationService->notifyNewAnnouncement($announcement, $users);
        }

        return redirect()->route('announcements.index')
            ->with('success', __('announcements.announcement_created'));
    }

    public function edit(Announcement $announcement)
    {
        $this->authorize('update', $announcement);
        
        return view('announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $this->authorize('update', $announcement);

        $validated = $request->validate([
            'title_sw' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'content_sw' => 'required|string',
            'content_en' => 'required|string',
            'category' => 'required|in:general,urgent,event,financial',
            'priority' => 'required|in:low,medium,high',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:published_at',
        ]);

        $announcement->update($validated);

        return redirect()->route('announcements.show', $announcement)
            ->with('success', __('announcements.announcement_updated'));
    }

    public function destroy(Announcement $announcement)
    {
        $this->authorize('delete', $announcement);

        $announcement->delete();

        return redirect()->route('announcements.index')
            ->with('success', __('announcements.announcement_deleted'));
    }
}
