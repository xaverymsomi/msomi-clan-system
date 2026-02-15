<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\NotificationPreference;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewAnnouncementMail;
use App\Mail\NewEventMail;
use App\Mail\ContributionReceiptMail;

class NotificationService
{
    /**
     * Check if user has enabled this notification type
     */
    private function isEnabled(User $user, string $type): bool
    {
        $preference = NotificationPreference::where('user_id', $user->id)
            ->where('notification_type', $type)
            ->first();

        // If no preference set, default to enabled
        return $preference ? $preference->enabled : true;
    }

    /**
     * Create notification for a user
     */
    private function createNotification(User $user, string $type, string $title, string $message, array $data = []): void
    {
        if (!$this->isEnabled($user, $type)) {
            return;
        }

        Notification::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
        ]);
    }

    /**
     * Notify users about a new event
     */
    public function notifyNewEvent($event, Collection $users): void
    {
        foreach ($users as $user) {
            $this->createNotification(
                $user,
                'event_reminder',
                __('notifications.new_event'),
                __('notifications.new_event_message', ['event' => $event->title]),
                ['event_id' => $event->id]
            );

            // Send Email for new event
            if ($user->email) {
                Mail::to($user->email)->queue(new NewEventMail($event));
            }
        }
    }

    /**
     * Notify attendees about upcoming event (1 day before)
     */
    public function notifyEventReminder($event, Collection $attendees): void
    {
        foreach ($attendees as $attendee) {
            if ($attendee->user) {
                $this->createNotification(
                    $attendee->user,
                    'event_reminder',
                    __('notifications.event_reminder'),
                    __('notifications.event_reminder_message', ['event' => $event->title]),
                    ['event_id' => $event->id]
                );

                // Send SMS Reminder
                if ($attendee->user->phone) {
                    $this->sendSMS($attendee->user->phone, "REMINDER: " . $event->title . " is happening tomorrow at " . $event->location . ".");
                }
            }
        }
    }

    /**
     * Notify users about a new announcement
     */
    public function notifyNewAnnouncement($announcement, Collection $users): void
    {
        $type = $announcement->category === 'urgent' ? 'urgent_announcement' : 'new_announcement';
        
        foreach ($users as $user) {
            $this->createNotification(
                $user,
                $type,
                $announcement->title,
                $announcement->getExcerpt(100),
                ['announcement_id' => $announcement->id]
            );

            // Send Email if urgent or if user preference enabled
            if ($announcement->category === 'urgent' && $user->email) {
                Mail::to($user->email)->queue(new NewAnnouncementMail($announcement));
            }

            // Send SMS if urgent
            if ($announcement->category === 'urgent' && $user->phone) {
                $this->sendSMS($user->phone, "URGENT CLAN ALERT: " . $announcement->title . ". Log in to the portal for details.");
            }
        }
    }

    /**
     * Notify member about contribution receipt
     */
    public function notifyContributionReceipt($contribution): void
    {
        if ($contribution->member && $contribution->member->user) {
            $user = $contribution->member->user;
            
            $this->createNotification(
                $user,
                'contribution_receipt',
                __('notifications.contribution_received'),
                __('notifications.contribution_received_message', ['amount' => number_format($contribution->amount)]),
                ['contribution_id' => $contribution->id]
            );

            // Send Email Receipt
            if ($user->email) {
                Mail::to($user->email)->queue(new ContributionReceiptMail($contribution));
            }
        }
    }

    /**
     * Notify users about a new document upload
     */
    public function notifyDocumentUpload($document, Collection $users): void
    {
        foreach ($users as $user) {
            $this->createNotification(
                $user,
                'document_upload',
                __('notifications.new_document'),
                __('notifications.new_document_message', ['document' => $document->title]),
                ['document_id' => $document->id]
            );
        }
    }

    /**
     * Notify admins about a new member
     */
    public function notifyNewMember($member, Collection $admins): void
    {
        foreach ($admins as $admin) {
            $this->createNotification(
                $admin,
                'new_member',
                __('notifications.new_member'),
                __('notifications.new_member_message', ['member' => $member->first_name . ' ' . $member->last_name]),
                ['member_id' => $member->id]
            );
        }
    }

    /**
     * Notify user about event RSVP
     */
    public function notifyEventRSVP($event, $attendee): void
    {
        if ($event->creator) {
            $this->createNotification(
                $event->creator,
                'event_rsvp',
                __('notifications.event_rsvp'),
                __('notifications.event_rsvp_message', [
                    'name' => $attendee->member->first_name ?? 'Someone',
                    'event' => $event->title
                ]),
                ['event_id' => $event->id, 'attendee_id' => $attendee->id]
            );
        }
    }

    /**
     * Notify user about comment reply
     */
    public function notifyCommentReply($comment, $reply): void
    {
        if ($comment->user_id !== $reply->user_id) {
            $this->createNotification(
                $comment->user,
                'comment_reply',
                __('notifications.comment_reply'),
                __('notifications.comment_reply_message', ['name' => $reply->user->name]),
                ['announcement_id' => $comment->announcement_id, 'comment_id' => $reply->id]
            );
        }
    }
    /**
     * Notify user about new message
     */
    public function notifyNewMessage($message): void
    {
        $recipient = $message->conversation->getOtherUser($message->sender_id);
        
        if ($recipient) {
            $this->createNotification(
                $recipient,
                'new_message',
                __('messages.new_private_message'),
                __('messages.new_message_from', ['name' => $message->sender->name]),
                ['conversation_id' => $message->conversation_id, 'message_id' => $message->id]
            );
        }
    }

    /**
     * Send SMS notification
     */
    protected function sendSMS(string $phone, string $message): void
    {
        // Placeholder for SMS Gateway integration (Twilio / Africa's Talking)
        // \Log::info("Sending SMS to {$phone}: {$message}");
        
        /* Example implementation for Africa's Talking:
        $username = config('services.at.username');
        $apiKey = config('services.at.key');
        $AT = new AfricasTalking($username, $apiKey);
        $sms = $AT->sms();
        $sms->send([
             'to' => $phone,
             'message' => $message
        ]);
        */
    }
}
