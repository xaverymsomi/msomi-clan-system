<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class DirectoryController extends Controller
{
    /**
     * Display the professional directory.
     */
    public function index(Request $request)
    {
        $query = Member::active();

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('profession', 'like', "%{$search}%")
                  ->orWhere('skills', 'like', "%{$search}%");
            });
        }

        if ($request->filled('profession')) {
            $query->where('profession', $request->profession);
        }

        $members = $query->paginate(12);
        
        // Get unique professions for filter
        $professions = Member::whereNotNull('profession')
            ->distinct()
            ->pluck('profession');

        return view('members.directory', compact('members', 'professions'));
    }
}
