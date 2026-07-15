<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Full notifications page (all notifications for the current user).
     */
    public function index(Request $request)
    {
        $notifications = $request->user()
            ->notifications()
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark a single notification as read.
     */
    public function markRead(Request $request, $id)
    {
        $notification = $request->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        // Follow the notification's link if present, else go back.
        $url = $notification->data['url'] ?? null;

        return $url ? redirect($url) : redirect()->back();
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    /**
     * Delete a single notification.
     */
    public function destroy(Request $request, $id)
    {
        $request->user()->notifications()->findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Notification deleted.');
    }

    /**
     * Delete all notifications.
     */
    public function clear(Request $request)
    {
        $request->user()->notifications()->delete();

        return redirect()->back()->with('success', 'All notifications cleared.');
    }
}
