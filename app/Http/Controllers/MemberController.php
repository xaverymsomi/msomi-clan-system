<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\NotificationService;
use Barryvdh\DomPDF\Facade\Pdf;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view members')->only(['index', 'show']);
        $this->middleware('permission:create members')->only(['create', 'store']);
        $this->middleware('permission:edit members')->only(['edit', 'update']);
        $this->middleware('permission:delete members')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\Member::with('user');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('member_number', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->get('status') != '') {
            $query->where('membership_status', $request->get('status'));
        }

        $members = $query->latest()->paginate(10);

        return view('members.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $males = \App\Models\Member::where('gender', 'male')->orderBy('first_name')->get();
        $females = \App\Models\Member::where('gender', 'female')->orderBy('first_name')->get();
        return view('members.create', compact('males', 'females'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, NotificationService $notificationService)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'nullable|date',
            'phone' => 'nullable|string|max:20', 
            'email' => 'nullable|email|max:255|unique:users,email',
            'region' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'village' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'profession' => 'nullable|string|max:255',
            'skills' => 'nullable|string',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        // Auto-generate member number
        // Format: MC-YYYY-XXXX (e.g. MC-2026-0001)
        $year = date('Y');
        $lastMember = \App\Models\Member::where('member_number', 'like', "MC-{$year}-%")->latest()->first();
        $sequence = 1;
        if ($lastMember) {
            $parts = explode('-', $lastMember->member_number);
            if (count($parts) === 3) {
                $sequence = intval($parts[2]) + 1;
            }
        }
        $memberNumber = sprintf("MC-%s-%04d", $year, $sequence);

        $data = $request->except(['profile_photo']);
        $data['member_number'] = $memberNumber;
        $data['joined_date'] = now();

        // Handle Photo Upload
        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        // Handle Skills
        if ($request->filled('skills')) {
            $data['skills'] = array_map('trim', explode(',', $request->skills));
        }

        // Create Member
        $member = \App\Models\Member::create($data);

        // Notify admins about the new member
        $admins = User::role(['Admin', 'Super Admin'])->get();
        $notificationService->notifyNewMember($member, $admins);

        return redirect()->route('members.index')
            ->with('success', __('members.member_saved'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $member = \App\Models\Member::with(['father', 'mother', 'childrenAsFather', 'childrenAsMother', 'user'])->findOrFail($id);
        return view('members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $member = \App\Models\Member::with('user')->findOrFail($id);
        
        // Exclude self from parents list
        $males = \App\Models\Member::where('gender', 'male')
            ->where('id', '!=', $id)
            ->orderBy('first_name')
            ->get();
            
        $females = \App\Models\Member::where('gender', 'female')
            ->where('id', '!=', $id)
            ->orderBy('first_name')
            ->get();
            
        return view('members.edit', compact('member', 'males', 'females'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $member = \App\Models\Member::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'nullable|date',
            'phone' => 'nullable|string|max:20', 
            'email' => 'nullable|email|max:255',
            'region' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'village' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'profile_photo' => 'nullable|image|max:2048',
            'father_id' => 'nullable|exists:members,id',
            'mother_id' => 'nullable|exists:members,id',
            'profession' => 'nullable|string|max:255',
            'skills' => 'nullable|string',
        ]);

        $data = $request->except(['profile_photo']);

        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($member->profile_photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($member->profile_photo);
            }
            $data['profile_photo'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        // Handle Skills
        if ($request->has('skills')) {
            $data['skills'] = $request->filled('skills') 
                ? array_map('trim', explode(',', $request->skills))
                : null;
        }

        $member->update($data);

        return redirect()->route('members.show', $member)
            ->with('success', __('members.member_saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $member = \App\Models\Member::findOrFail($id);
        if ($member->profile_photo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($member->profile_photo);
        }
        $member->delete();

        return redirect()->route('members.index')
            ->with('success', __('members.member_deleted'));
    }

    /**
     * Display the family tree.
     */
    public function tree(Request $request, $id = null)
    {
        if ($id) {
            $root = \App\Models\Member::with([
                'father', 
                'mother', 
                'childrenAsFather.childrenAsFather', 
                'childrenAsFather.childrenAsMother',
                'childrenAsMother.childrenAsFather', 
                'childrenAsMother.childrenAsMother'
            ])->findOrFail($id);
            return view('members.tree', compact('root'));
        }

        // Check if current user is a member
        $userMember = $request->user()->member;
        if ($userMember) {
            return redirect()->route('members.tree', $userMember->id);
        }

        // Show search or list of roots
        $roots = \App\Models\Member::whereNull('father_id')->whereNull('mother_id')->limit(20)->get();
        return view('members.tree_index', compact('roots'));
    }

    /**
     * Download Membership ID Card as PDF.
     */
    public function downloadIdCard(string $id)
    {
        $member = \App\Models\Member::findOrFail($id);
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('members.id_card', compact('member'))
            ->setPaper([0, 0, 240, 153], 'portrait');
            
        return $pdf->download("ID_Card_{$member->member_number}.pdf");
    }

    /**
     * Display the interactive family tree.
     */
    public function familyTree()
    {
        return view('members.family_tree');
    }

    /**
     * Get JSON data for the D3 family tree.
     */
    public function familyTreeData()
    {
        $members = \App\Models\Member::all();
        
        $nodes = $members->map(function($member) {
            return [
                'id' => (string)$member->id,
                'name' => $member->full_name,
                'gender' => $member->gender,
                'photo' => $member->profile_photo ? \Illuminate\Support\Facades\Storage::url($member->profile_photo) : null,
                'region' => $member->region,
                'village' => $member->village,
            ];
        });

        $links = [];
        foreach ($members as $member) {
            if ($member->father_id) {
                $links[] = [
                    'source' => (string)$member->father_id,
                    'target' => (string)$member->id,
                    'type' => 'father'
                ];
            }
            if ($member->mother_id) {
                $links[] = [
                    'source' => (string)$member->mother_id,
                    'target' => (string)$member->id,
                    'type' => 'mother'
                ];
            }
        }

        return response()->json([
            'nodes' => $nodes,
            'links' => $links
        ]);
    }
}
