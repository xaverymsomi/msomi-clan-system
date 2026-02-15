<?php

namespace App\Http\Controllers;

use App\Models\Tradition;
use App\Models\TraditionMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TraditionMediaController extends Controller
{
    /**
     * Store a recorded voice memo.
     */
    public function storeVoiceMemo(Request $request, Tradition $tradition)
    {
        $request->validate([
            'audio' => 'required|file|mimes:webm,mp3,wav|max:10240', // 10MB max
            'duration' => 'nullable|integer',
        ]);

        if ($request->hasFile('audio')) {
            $path = $request->file('audio')->store('traditions/audio', 'public');

            $media = $tradition->media()->create([
                'type' => 'audio',
                'file_path' => $path,
                'duration' => $request->duration,
                'caption_sw' => 'Simulizi ya sauti',
                'caption_en' => 'Voice story recording',
            ]);

            return response()->json([
                'status' => 'success',
                'media' => $media,
                'url' => Storage::url($path),
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'No audio file uploaded'], 400);
    }
}
