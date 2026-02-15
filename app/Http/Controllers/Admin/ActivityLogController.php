<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with('causer', 'subject')->latest();

        // Search by causer or subject type
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('subject_type', 'like', "%{$search}%")
                    ->orWhereHas('causer', function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by log name/module
        if ($request->has('log_name') && $request->log_name) {
            $query->where('log_name', $request->log_name);
        }

        $activities = $query->paginate(20);

        return view('admin.activity_logs.index', compact('activities'));
    }

    public function show(Activity $activity)
    {
        return view('admin.activity_logs.show', compact('activity'));
    }
}
