<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    // Show all conversations for logged-in user
    public function index()
    {
        $userId = Auth::id();

        // Get all distinct users who have messaged with this user
        $conversations = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender', 'receiver', 'job'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('messages.index', compact('conversations'));
    }

    // Show messages in a conversation with a specific user
    public function show($userId)
    {
        $authId = Auth::id();

        $messages = Message::where(function ($q) use ($authId, $userId) {
                $q->where('sender_id', $authId)
                  ->where('receiver_id', $userId);
            })
            ->orWhere(function ($q) use ($authId, $userId) {
                $q->where('sender_id', $userId)
                  ->where('receiver_id', $authId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $receiver = User::findOrFail($userId);

        return view('messages.show', compact('messages', 'receiver'));
    }

    // Store a new message
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
            'job_id' => 'nullable|exists:jobs,id',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'job_id' => $request->job_id,
            'message' => $request->message,
            'is_read' => false,
        ]);

        return back();
    }

    // Optional: mark messages as read
    public function markAsRead($userId)
    {
        $authId = Auth::id();

        Message::where('sender_id', $userId)
            ->where('receiver_id', $authId)
            ->update(['is_read' => true]);

        return back();
    }
}