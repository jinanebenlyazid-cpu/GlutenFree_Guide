<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Location;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingRecipes = Recipe::pending()->with('user')->latest()->get();
        $pendingLocations = Location::pending()->with('user')->latest()->get();
        $approvedRecipesCount = Recipe::approved()->count();
        $refusedRecipesCount = Recipe::refused()->count();
        $approvedLocationsCount = Location::approved()->count();
        $productsCount = Product::count();

        return view('admin.dashboard', compact(
            'pendingRecipes', 'pendingLocations',
            'approvedRecipesCount', 'refusedRecipesCount', 'approvedLocationsCount', 'productsCount'
        ));
    }

    // --- Recipes Management ---

    public function recipesIndex(Request $request)
    {
        $counts = [
            'total' => Recipe::count(),
            'pending' => Recipe::pending()->count(),
            'approved' => Recipe::approved()->count(),
            'refused' => Recipe::refused()->count(),
        ];

        $query = Recipe::with('user')->latest();
        
        if ($request->has('status') && in_array($request->status, ['pending', 'approved', 'refused'])) {
            $query->where('status', $request->status);
        }
        
        $recipes = $query->paginate(5)->appends($request->all());
        $status = $request->status ?? 'all';
        
        return view('admin.recipes.index', compact('recipes', 'status', 'counts'));
    }

    public function recipeEdit(Recipe $recipe)
    {
        return view('admin.recipes.edit', compact('recipe'));
    }

    public function recipeUpdate(Request $request, Recipe $recipe)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'prep_time' => 'required|integer|min:1',
            'status' => 'required|in:pending,approved,refused',
            'ingredients' => 'required|array',
            'steps' => 'required|array',
        ]);

        $recipe->update($validated);

        return redirect()->route('admin.recipes.index')->with('success', __('Recette mise à jour avec succès !'));
    }

    public function recipeDestroy(Recipe $recipe)
    {
        $recipe->delete();
        return back()->with('success', __('Recette supprimée avec succès !'));
    }

    public function approveRecipe(Recipe $recipe)
    {
        $recipe->update(['status' => 'approved']);
        return back()->with('success', __('Recette approuvée avec succès !'));
    }

    public function refuseRecipe(Recipe $recipe)
    {
        $recipe->update(['status' => 'refused']);
        return back()->with('success', __('Recette refusée.'));
    }

    // --- Locations ---

    public function approveLocation(Location $location)
    {
        $location->update(['status' => 'approved']);
        return back()->with('success', __('Lieu approuvé avec succès !'));
    }

    public function refuseLocation(Location $location)
    {
        $location->delete();
        return back()->with('success', __('Lieu refusé et supprimé.'));
    }

    // --- Products Management ---

    public function productsIndex()
    {
        $products = Product::latest()->paginate(5);
        return view('admin.products.index', compact('products'));
    }

    public function productCreate()
    {
        return view('admin.products.create');
    }

    public function productStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'city' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'image_url' => 'nullable|string|max:1000',
            'is_certified' => 'boolean',
        ]);

        $validated['user_id'] = Auth::id();
        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', __('Produit ajouté avec succès !'));
    }

    public function productEdit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function productUpdate(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'city' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'image_url' => 'nullable|string|max:1000',
            'is_certified' => 'boolean',
        ]);

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', __('Produit mis à jour avec succès !'));
    }

    public function productDestroy(Product $product)
    {
        $product->delete();
        return back()->with('success', __('Produit supprimé avec succès !'));
    }

    // --- Users Management ---

    public function usersIndex(Request $request)
    {
        $query = \App\Models\User::query();
        
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }
        
        $users = $query->latest()->paginate(10)->appends($request->all());
        
        return view('admin.users.index', compact('users'));
    }

    public function usersShow(\App\Models\User $user)
    {
        $user->loadCount(['recipes', 'locations', 'comments', 'favorites']);
        $user->load(['recipes' => function($q) { $q->latest()->take(5); }]);
        return view('admin.users.show', compact('user'));
    }

    public function toggleBlockUser(\App\Models\User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', __('Vous ne pouvez pas vous bloquer vous-même.'));
        }
        
        $user->update(['is_blocked' => !$user->is_blocked]);
        
        $message = $user->is_blocked ? __('Utilisateur bloqué avec succès.') : __('Utilisateur débloqué avec succès.');
        return back()->with('success', $message);
    }
}
