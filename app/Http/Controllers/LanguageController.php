<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Switch the application language
     */
    public function switch(Request $request, $lang)
    {
        // Validate language
        if (!in_array($lang, ['en', 'sw'])) {
            abort(400, 'Invalid language');
        }

        // Set application locale
        App::setLocale($lang);

        // Store in session
        Session::put('locale', $lang);

        // Update user preference if authenticated
        if (auth()->check()) {
            auth()->user()->update(['language_preference' => $lang]);
        }

        return redirect()->back()->with('success', __('messages.language_changed'));
    }
}
