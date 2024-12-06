<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->latest()->get();

        return response()->json([
            'success' => true,
            'notifications' => $notifications,
        ]);
    }

    public function markAsRead(Request $request)
    {
        try {
            $user = auth()->user();
            $user->unreadNotifications->markAsRead();

            return response()->json([
                'success' => true,
                'message' => 'All notifications marked as read.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark notifications as read.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}