<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventAttendee;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EventController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Event::query();

        // Filter by type
        if ($request->has('type') && $request->type) {
            $query->byType($request->type);
        }

        // Upcoming vs Past
        if ($request->has('view') && $request->view === 'past') {
            $query->past()->orderBy('start_date', 'desc');
        } else {
            $query->upcoming()->orderBy('start_date', 'asc');
        }

        $events = $query->paginate(9);

        return view('events.index', compact('events'));
    }

    public function show(Event $event)
    {
        $event->load(['attendees.user', 'attendees.member', 'creator']);
        
        // Check if current user is attending
        $attendance = null;
        if (auth()->check()) {
            $attendance = $event->attendees()
                ->where('user_id', auth()->id())
                ->first();
                
            if (!$attendance && auth()->user()->member) {
                 $attendance = $event->attendees()
                    ->where('member_id', auth()->user()->member->id)
                    ->first();
            }
        }

        return view('events.show', compact('event', 'attendance'));
    }

    public function create()
    {
        $this->authorize('create', Event::class);
        return view('events.create');
    }

    public function store(Request $request, NotificationService $notificationService)
    {
        $this->authorize('create', Event::class);

        $validated = $request->validate([
            'title_sw' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_sw' => 'nullable|string',
            'description_en' => 'nullable|string',
            'event_type' => 'required|in:meeting,ceremony,celebration,funeral,other',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'venue' => 'nullable|string|max:255',
            'max_attendees' => 'nullable|integer|min:1',
        ]);

        $validated['created_by'] = auth()->id();

        $event = Event::create($validated);

        // Notify all users about the new event
        $users = User::all();
        $notificationService->notifyNewEvent($event, $users);

        return redirect()->route('events.show', $event)
            ->with('success', __('events.event_saved'));
    }

    public function edit(Event $event)
    {
        $this->authorize('update', $event);
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $validated = $request->validate([
            'title_sw' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_sw' => 'nullable|string',
            'description_en' => 'nullable|string',
            'event_type' => 'required|in:meeting,ceremony,celebration,funeral,other',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'venue' => 'nullable|string|max:255',
            'max_attendees' => 'nullable|integer|min:1',
        ]);

        $event->update($validated);

        return redirect()->route('events.show', $event)
            ->with('success', __('events.event_saved'));
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);
        $event->delete();

        return redirect()->route('events.index')
            ->with('success', __('events.event_deleted'));
    }

    public function register(Request $request, Event $event, NotificationService $notificationService)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'status' => 'required|in:registered,cancelled',
            'guests_count' => 'nullable|integer|min:0|max:10',
        ]);

        $user = auth()->user();
        $member = $user->member;

        // Check if exists
        $attendance = $event->attendees()->where('user_id', $user->id)->first();

        if ($attendance) {
            $attendance->update([
                'status' => $validated['status'],
                'guests_count' => $validated['guests_count'] ?? 0,
            ]);
        } else {
            // Check capacity
            if ($event->is_full && $validated['status'] === 'registered') {
                return back()->with('error', __('events.event_full'));
            }

            $attendance = EventAttendee::create([
                'event_id' => $event->id,
                'user_id' => $user->id,
                'member_id' => $member ? $member->id : null,
                'name' => $member ? $member->full_name : $user->name,
                'email' => $user->email,
                'guests_count' => $validated['guests_count'] ?? 0,
                'status' => $validated['status'],
            ]);

            // Notify event creator about the new RSVP if registered
            if ($validated['status'] === 'registered') {
                $notificationService->notifyEventRSVP($event, $attendance);
            }
        }

        return back()->with('success', __('events.registration_updated'));
    }
}
