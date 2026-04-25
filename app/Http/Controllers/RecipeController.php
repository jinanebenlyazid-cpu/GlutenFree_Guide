<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RecipeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth', only: ['create', 'store']),
        ];
    }

    public function index(Request $request)
    {
        $query = Recipe::approved();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('ingredients', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        if ($request->filled('max_time')) {
            $query->where('prep_time', '<=', $request->max_time);
        }

        $recipes = $query->with(['comments.user', 'user'])->latest()->paginate(5)->withQueryString();
        return view('recipes.index', compact('recipes'));
    }

    public function myRecipes(Request $request)
    {
        $user = Auth::user();
        $query = Recipe::where('user_id', $user->id);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('ingredients', 'like', '%' . $search . '%');
            });
        }

        $recipes = $query->with(['comments.user', 'user'])->latest()->paginate(5)->withQueryString();
        return view('recipes.my', compact('recipes'));
    }

    public function create()
    {
        return view('recipes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image_url' => 'nullable|string|max:500',
            'ingredients' => 'required|array|min:1',
            'ingredients.*' => 'required|string',
            'steps' => 'required|array|min:1',
            'steps.*' => 'required|string',
            'prep_time' => 'required|integer|min:1',
            'difficulty' => 'required|in:facile,moyen,difficile',
        ]);

        Recipe::create([
            'name' => $validated['name'],
            'image_url' => $validated['image_url'] ?? null,
            'ingredients' => $validated['ingredients'],
            'steps' => $validated['steps'],
            'prep_time' => $validated['prep_time'],
            'difficulty' => $validated['difficulty'],
            'user_id' => Auth::id(),
            'status' => 'pending',
            'likes' => 0,
        ]);

        return redirect()->route('recipes.index')->with('success', __('Votre recette a été soumise et est en attente de validation par un administrateur.'));
    }

    public function show($id)
    {
        return redirect()->route('recipes.index', ['recipe' => $id]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
