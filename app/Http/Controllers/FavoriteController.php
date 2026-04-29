<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Recipe;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $favoriteProducts = Product::whereHas('favorites', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get();

        $favoriteRecipes = Recipe::whereHas('favorites', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get();

        return view('favorites.index', compact('favoriteProducts', 'favoriteRecipes'));
    }

    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => __('Veuillez vous connecter.')], 401);
            }
            return redirect()->route('login');
        }

        $request->validate([
            'id' => 'required|integer',
            'type' => 'required|string|in:product,recipe',
        ]);

        $modelClass = $request->type === 'product' ? \App\Models\Product::class : \App\Models\Recipe::class;
        $model = $modelClass::findOrFail($request->id);

        $favorite = $model->favorites()->where('user_id', Auth::id())->first();

        if ($favorite) {
            $favorite->delete();
            $status = 'removed';
            $message = __('Retiré des favoris.');
        } else {
            $model->favorites()->create([
                'user_id' => Auth::id()
            ]);
            $status = 'added';
            $message = __('Ajouté aux favoris.');
        }

        if ($request->ajax()) {
            return response()->json(['status' => $status, 'message' => $message]);
        }

        return back()->with('success', $message);
    }
}
