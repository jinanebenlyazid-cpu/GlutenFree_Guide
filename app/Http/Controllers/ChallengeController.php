<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChallengeController extends Controller
{
    /**
     * Get the daily mission based on the current date.
     */
    public function getDailyChallenge()
    {
        $missions = Challenge::all();
        if ($missions->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No missions found.']);
        }

        // Use day of the year to rotate missions daily
        $dayOfYear = date('z');
        $missionIndex = $dayOfYear % $missions->count();
        $mission = $missions->get($missionIndex);

        return response()->json([
            'success' => true,
            'challenge' => $mission,
        ]);
    }
}
