<?php

namespace App\Http\Controllers;

use App\Models\NotificationPreference;
use Illuminate\Http\Request;

class NotificationPreferenceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $types = NotificationPreference::getDefaultTypes();
        
        // Get user's current preferences
        $preferences = NotificationPreference::where('user_id', $user->id)
            ->pluck('enabled', 'notification_type')
            ->toArray();

        return view('notifications.preferences', compact('types', 'preferences'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $types = array_keys(NotificationPreference::getDefaultTypes());

        foreach ($types as $type) {
            $enabled = $request->has($type);
            
            NotificationPreference::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'notification_type' => $type,
                ],
                [
                    'enabled' => $enabled,
                ]
            );
        }

        return back()->with('success', __('notifications.preferences_updated'));
    }
}
