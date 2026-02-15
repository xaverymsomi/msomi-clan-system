<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\AnnouncementComment;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AnnouncementCommentController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request, Announcement $announcement, NotificationService $notificationService)
    {
        $validated = $request->validate([
            'comment' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:announcement_comments,id',
        ]);

        $validated['announcement_id'] = $announcement->id;
        $validated['user_id'] = auth()->id();

        $comment = AnnouncementComment::create($validated);

        // Notify parent comment owner if this is a reply
        if ($comment->parent_id) {
            $notificationService->notifyCommentReply($comment->parent, $comment);
        }

        return redirect()->route('announcements.show', $announcement)
            ->with('success', __('announcements.comment_added'));
    }

    public function destroy(AnnouncementComment $comment)
    {
        // Only allow user to delete their own comments or Super Admin
        if (auth()->id() !== $comment->user_id && !auth()->user()->hasRole('Super Admin')) {
            abort(403);
        }

        $announcementId = $comment->announcement_id;
        $comment->delete();

        return redirect()->route('announcements.show', $announcementId)
            ->with('success', __('announcements.comment_deleted'));
    }
}
