<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display notifications based on user role.
     */
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        // Fetch latest 5 notifications for the user
        $notifications = $user->notifications()->latest()->take(5)->get();

        // Choose view based on role
        switch ($role) {
            case 'admin':
                $view = 'admin.notifications.index';
                break;
            case 'employer':
                $view = 'notifications.employer';
                break;
            case 'job_seeker':
                $view = 'notifications.jobseeker';
                break;
            default:
                abort(403, 'Unauthorized');
        }

        return view($view, compact('notifications'));
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead($notificationId)
    {
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($notificationId);
        $notification->markAsRead();

        return redirect()->back();
    }
}