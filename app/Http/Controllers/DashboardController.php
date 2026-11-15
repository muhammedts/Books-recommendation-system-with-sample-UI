<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * The signed-in user's ratings and the recommendations produced for them
     * by the Spark ALS job.
     */
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $recommendations = $user->recommendations()
            ->with('book')
            ->whereHas('book')
            ->orderBy('rank')
            ->get();

        $ratings = $user->ratings()
            ->with('book')
            ->latest('updated_at')
            ->paginate(10);

        return view('dashboard', [
            'recommendations' => $recommendations,
            'generatedAt' => $recommendations->max('generated_at'),
            'ratings' => $ratings,
        ]);
    }
}
