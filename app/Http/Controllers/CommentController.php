<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Recipe $recipe)
    {
        if (!Auth::check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => __('Veuillez vous connecter pour commenter.')], 401);
            }
            return redirect()->route('login');
        }

        $request->validate([
            'body'      => 'required|string|max:1000',
            'parent_id' => 'nullable|integer|exists:comments,id',
        ]);

        $comment = $recipe->comments()->create([
            'body'      => $request->body,
            'user_id'   => Auth::id(),
            'parent_id' => $request->parent_id ?? null,
        ]);

        $comment->load(['user', 'replies.user']);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'comment' => [
                    'id'          => $comment->id,
                    'parent_id'   => $comment->parent_id,
                    'body'        => $comment->body,
                    'user_name'   => optional($comment->user)->name ?? __('Anonyme'),
                    'user_initial'=> strtoupper(substr(optional($comment->user)->name ?? 'A', 0, 1)),
                    'user_avatar' => optional($comment->user)->profile_photo_path
                                        ? asset('storage/' . $comment->user->profile_photo_path)
                                        : null,
                    'time'        => $comment->created_at->diffForHumans(),
                    'can_delete'  => true,
                    'delete_url'  => route('comments.destroy', $comment->id),
                ],
            ]);
        }

        return back()->with('success', __('Commentaire ajouté avec succès !'));
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', __('Commentaire supprimé.'));
    }
}
