<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MapController extends Controller
{
    /**
     * Show the global clan map.
     */
    public function index()
    {
        return view('members.map');
    }

    /**
     * Get member distribution data.
     */
    public function data()
    {
        // Aggregate members by region
        $distribution = Member::select('region', \DB::raw('count(*) as count'))
            ->whereNotNull('region')
            ->groupBy('region')
            ->get();

        // Hardcoded coordinates for Tanzania regions (Example subset)
        $coordinates = [
            'Dar es Salaam' => [-6.7924, 39.2083],
            'Dodoma' => [-6.1630, 35.7516],
            'Mwanza' => [-2.5167, 32.9000],
            'Arusha' => [-3.3667, 36.6833],
            'Mbeya' => [-8.9000, 33.4500],
            'Morogoro' => [-6.8278, 37.6636],
            'Tanga' => [-5.0689, 39.0988],
            'Kilimanjaro' => [-3.3094, 37.3533],
            'Pwani' => [-7.2188, 38.9818],
            'Iringa' => [-7.7667, 35.7000],
            'Kagera' => [-1.3333, 31.8167],
            'Kigoma' => [-4.8833, 29.6333],
            'Lindi' => [-9.9969, 39.7144],
            'Manyara' => [-4.3532, 36.0125],
            'Mara' => [-1.7500, 34.0000],
            'Mtwara' => [-10.2764, 40.1806],
            'Njombe' => [-9.3333, 34.7667],
            'Rukwa' => [-7.0000, 31.5000],
            'Ruvuma' => [-10.6833, 35.6500],
            'Shinyanga' => [-3.6667, 33.4167],
            'Simiyu' => [-2.8532, 34.0125],
            'Singida' => [-4.8167, 34.7500],
            'Songwe' => [-8.5333, 32.7667],
            'Tabora' => [-5.0167, 32.8167],
            'Geita' => [-2.8667, 32.2333],
            'Katavi' => [-6.3333, 31.0000],
        ];

        $mapData = $distribution->map(function($item) use ($coordinates) {
            return [
                'region' => $item->region,
                'count' => $item->count,
                'lat' => $coordinates[$item->region][0] ?? -6.3690, // Default to center of TZ if not found
                'lng' => $coordinates[$item->region][1] ?? 34.8888,
            ];
        });

        return response()->json($mapData);
    }
}
