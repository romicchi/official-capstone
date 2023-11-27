<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->where('read', false)->get();
        
        return view('layout.topbar', compact('notifications'));
    }

    public function getNotifications()
    {
        $notifications = auth()->user()->unreadNotifications; // Fetch unread notifications

        return response()->json(['notifications' => $notifications]);
    }

    public function markAllAsRead(Notification $notification)
    {
        $user = auth()->user();
        $user->notifications()->update(['read' => true]);

        // just redirect back
        return redirect()->back();
    }

    public function markAsRead(Notification $notification)
    {
        $notification->update(['read' => true]);

        // redirect to selected notification
        return redirect()->route('discussions.show', $notification->discussion_slug);
    }
}
