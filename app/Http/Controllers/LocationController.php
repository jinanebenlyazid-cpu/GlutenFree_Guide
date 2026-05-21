<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class LocationController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth', only: ['create', 'store']),
        ];
    }

    public function index()
    {
        $locations = Location::approved()->get()->map(function($l) {
            return (object) [
                'id' => $l->id,
                'name' => __($l->name),
                'type' => __($l->type),
                'city' => __($l->city),
                'address' => __($l->address),
                'description' => __($l->description),
                'latitude' => $l->latitude,
                'longitude' => $l->longitude,
            ];
        });
        return view('locations.index', compact('locations'));
    }

    public function create()
    {
        return view('locations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'description' => 'nullable|string|max:1000',
            'image_url' => 'nullable|string|max:500',
        ]);

        Location::create([
            ...$validated,
            'user_id' => Auth::id(),
            'status' => 'pending',
        ]);

        return redirect()->route('locations.index')->with('success', __('Votre lieu a été soumis et est en attente de validation par un administrateur.'));
    }

    public function show(Location $location)
    {
        //
    }

    public function edit(Location $location)
    {
        //
    }

    public function update(Request $request, Location $location)
    {
        //
    }

    public function destroy(Location $location)
    {
        //
    }
}
