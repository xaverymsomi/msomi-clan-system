<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\Member;
use App\Models\Event;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ContributionsExport;
use Barryvdh\DomPDF\Facade\Pdf;

class ContributionController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Contribution::class);

        $query = Contribution::with(['member', 'event', 'recorder']);

        // Filters
        if ($request->has('type') && $request->type) {
            $query->where('contribution_type', $request->type);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('event_id') && $request->event_id) {
            $query->where('event_id', $request->event_id);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('member', function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        $contributions = $query->latest()->paginate(15);
        $events = Event::select('id', 'title_sw', 'title_en')->latest()->take(10)->get();

        return view('contributions.index', compact('contributions', 'events'));
    }

    public function create()
    {
        $this->authorize('create', Contribution::class);
        
        $members = Member::orderBy('first_name')->get();
        $events = Event::upcoming()->orderBy('start_date')->get();
        
        return view('contributions.create', compact('members', 'events'));
    }

    public function store(Request $request, NotificationService $notificationService)
    {
        $this->authorize('create', Contribution::class);

        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'contribution_type' => 'required|in:dues,event,project,donation',
            'event_id' => 'nullable|required_if:contribution_type,event|exists:events,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'reference_number' => 'nullable|string',
            'status' => 'required|in:pending,completed,failed',
            'payment_date' => 'nullable|date',
            'purpose_sw' => 'nullable|string',
            'purpose_en' => 'nullable|string',
        ]);

        $validated['recorded_by'] = auth()->id();
        $validated['currency'] = 'TZS'; // Default

        $contribution = Contribution::create($validated);

        // Notify member about the contribution receipt if completed
        if ($contribution->status === 'completed') {
            $notificationService->notifyContributionReceipt($contribution);
        }

        return redirect()->route('contributions.index')
            ->with('success', __('contributions.contribution_recorded'));
    }

    public function show(Contribution $contribution)
    {
        $this->authorize('view', $contribution);
        $contribution->load(['member', 'event', 'recorder']);
        return view('contributions.show', compact('contribution'));
    }

    public function myContributions()
    {
        $user = auth()->user();
        
        // If user has no linked member profile, show empty state
        if (!$user->member) {
            $contributions = collect(); // Empty collection
            return view('contributions.my_contributions', [
                'contributions' => new \Illuminate\Pagination\LengthAwarePaginator([], 0, 15),
                'noMemberProfile' => true
            ]);
        }

        $contributions = Contribution::where('member_id', $user->member->id)
            ->with(['event'])
            ->latest()
            ->paginate(15);

        return view('contributions.my_contributions', compact('contributions'));
    }

    /**
     * Export contributions to Excel.
     */
    public function export()
    {
        $this->authorize('viewAny', Contribution::class);
        return Excel::download(new ContributionsExport, 'msomi_clan_contributions_' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Export contributions to PDF.
     */
    public function exportPdf()
    {
        $this->authorize('viewAny', Contribution::class);
        $contributions = Contribution::with(['member', 'event', 'recorder'])->latest()->get();
        $total = $contributions->sum('amount');
        
        $pdf = Pdf::loadView('contributions.pdf', compact('contributions', 'total'));
        return $pdf->download('msomi_clan_financial_report_' . date('Y-m-d') . '.pdf');
    }
}
