<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Display a listing of personal conversations.
     */
    public function index()
    {
        $conversations = Conversation::forUser(auth()->user())
            ->with(['users', 'lastMessage'])
            ->orderBy('last_message_at', 'desc')
            ->paginate(15);

        return view('messages.index', compact('conversations'));
    }

    /**
     * Show the form for starting a new conversation.
     */
    public function create()
    {
        $users = User::where('id', '!=', auth()->id())
            ->orderBy('name')
            ->get();
            
        return view('messages.create', compact('users'));
    }

    /**
     * Start a new conversation and send the first message.
     */
    public function store(Request $request, NotificationService $notificationService)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id|not_in:' . auth()->id(),
            'body' => 'required|string|max:2000',
        ]);

        $recipientId = $request->recipient_id;
        $body = $request->body;
        $senderId = auth()->id();

        // Check if conversation already exists between these two users
        $conversation = Conversation::whereHas('users', function ($q) use ($senderId) {
                $q->where('users.id', $senderId);
            })
            ->whereHas('users', function ($q) use ($recipientId) {
                $q->where('users.id', $recipientId);
            })
            ->first();

        DB::beginTransaction();
        try {
            if (!$conversation) {
                $conversation = Conversation::create([
                    'last_message_at' => now(),
                ]);
                $conversation->users()->attach([$senderId, $recipientId]);
            } else {
                $conversation->update(['last_message_at' => now()]);
            }

            $message = Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => $senderId,
                'body' => $body,
            ]);

            // Update sender's last_read_at
            $conversation->users()->updateExistingPivot($senderId, ['last_read_at' => now()]);

            // Notify recipient
            $notificationService->notifyNewMessage($message);

            DB::commit();

            return redirect()->route('messages.show', $conversation)
                ->with('success', __('messages.message_sent'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to send message: ' . $e->getMessage());
        }
    }

    /**
     * Display the conversation thread.
     */
    public function show(Conversation $conversation)
    {
        // Authorize: user must be part of the conversation
        if (!$conversation->users()->where('users.id', auth()->id())->exists()) {
            abort(403);
        }

        $conversation->load(['users', 'messages.sender']);
        $messages = $conversation->messages()->oldest()->paginate(50);

        // Mark as read
        $conversation->users()->updateExistingPivot(auth()->id(), ['last_read_at' => now()]);

        return view('messages.show', compact('conversation', 'messages'));
    }

    /**
     * Reply to an existing conversation.
     */
    public function reply(Request $request, Conversation $conversation, NotificationService $notificationService)
    {
        if (!$conversation->users()->where('users.id', auth()->id())->exists()) {
            abort(403);
        }

        $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        DB::beginTransaction();
        try {
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => auth()->id(),
                'body' => $request->body,
            ]);

            $conversation->update(['last_message_at' => now()]);
            $conversation->users()->updateExistingPivot(auth()->id(), ['last_read_at' => now()]);

            // Notify other user
            $notificationService->notifyNewMessage($message);

            DB::commit();

            return back()->with('success', __('messages.message_sent'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to send reply.');
        }
    }
}
