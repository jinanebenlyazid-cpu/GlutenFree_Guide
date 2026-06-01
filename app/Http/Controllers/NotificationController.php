<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class NotificationController extends Controller
{
    /**
     * Return recent notifications as JSON for the dropdown.
     */
    public function index()
    {
        $notifications = Notification::with(['actor', 'recipe', 'contactMessage'])
            ->where('user_id', auth()->id())
            ->latest()
            ->take(20)
            ->get()
            ->map(function ($n) {
                $actor = $n->actor;
                $url = $n->type === 'contact_reply' && $n->contact_message_id
                    ? route('messages.show', $n->contact_message_id)
                    : route('recipes.index') . '?recipe=' . $n->recipe_id
                        . ($n->comment_id ? '&comment=' . $n->comment_id : '');

                return [
                    'id'         => $n->id,
                    'message'    => $n->message,
                    'icon'       => $n->icon,
                    'type'       => $n->type,
                    'is_read'    => (bool) $n->is_read,
                    'recipe_id'  => $n->recipe_id,
                    'avatar'     => ($actor && $actor->profile_photo_path)
                                    ? asset('storage/' . $actor->profile_photo_path)
                                    : null,
                    'actor_name' => $actor->name ?? '?',
                    'time_ago'   => Carbon::parse($n->created_at)->diffForHumans(),
                    'url'        => $url,
                    'recipe_url' => $url,
                ];
            });

        $unread_count = Notification::where('user_id', auth()->id())
            ->unread()
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count'  => $unread_count,
        ]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Mark a single notification as read.
     */
    public function markRead($id)
    {
        Notification::where('user_id', auth()->id())
            ->where('id', $id)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}
