<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\TraditionController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AnnouncementCommentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NotificationPreferenceController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Language switcher
Route::get('/language/{lang}', [LanguageController::class, 'switch'])->name('language.switch');

// Public traditions (Mila na Desturi)
Route::get('/traditions', [TraditionController::class, 'index'])->name('traditions.index');
Route::get('/traditions/{tradition}', [TraditionController::class, 'show'])->name('traditions.show')->whereNumber('tradition');

// Public events
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show')->whereNumber('event');

// Public documents
Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show')->whereNumber('document');
Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download')->whereNumber('document');

// Public announcements
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show')->whereNumber('announcement');

// Dashboard (authenticated users)
use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/search', [\App\Http\Controllers\SearchController::class, 'global'])->name('search.global');

    // Members map & directory
    Route::get('/members/directory', [App\Http\Controllers\DirectoryController::class, 'index'])->name('members.directory');
    Route::get('/members/map', [App\Http\Controllers\MapController::class, 'index'])->name('members.map');
    Route::get('/api/members/map-data', [App\Http\Controllers\MapController::class, 'data'])->name('members.map-data');

    // Members (requires authentication)
    Route::get('/members/family-tree', [MemberController::class, 'familyTree'])->name('members.tree');
    Route::get('/api/members/family-tree-data', [MemberController::class, 'familyTreeData'])->name('members.tree-data');
    Route::get('/members/{member}/id-card', [MemberController::class, 'downloadIdCard'])->name('members.id-card');
    Route::resource('members', MemberController::class);

    // Roles & Permissions (requires authentication & permission)
    Route::resource('roles', \App\Http\Controllers\RoleController::class);

    // Traditions management (requires authentication)
    Route::get('/traditions/create', [TraditionController::class, 'create'])->name('traditions.create');
    Route::post('/traditions', [TraditionController::class, 'store'])->name('traditions.store');
    Route::get('/traditions/{tradition}/edit', [TraditionController::class, 'edit'])->name('traditions.edit');
    Route::put('/traditions/{tradition}', [TraditionController::class, 'update'])->name('traditions.update');
    Route::delete('/traditions/{tradition}', [TraditionController::class, 'destroy'])->name('traditions.destroy');
    Route::post('/traditions/{tradition}/voice-memo', [App\Http\Controllers\TraditionMediaController::class, 'storeVoiceMemo'])->name('traditions.voice-memo');

    // Events management (requires authentication)
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::post('/events/{event}/register', [EventController::class, 'register'])->name('events.register');

    // Contributions management
    Route::get('/contributions/export', [ContributionController::class, 'export'])->name('contributions.export');
    Route::get('/contributions/export-pdf', [ContributionController::class, 'exportPdf'])->name('contributions.export-pdf');
    Route::get('/my-contributions', [ContributionController::class, 'myContributions'])->name('contributions.my');
    Route::post('/contributions/{contribution}/pay', [App\Http\Controllers\PaymentController::class, 'initialize'])->name('payments.pay');
    Route::get('/payments/callback', [App\Http\Controllers\PaymentController::class, 'callback'])->name('payments.callback');
    Route::resource('contributions', ContributionController::class);

    // Documents management
    Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');

    // Announcements management
    Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('/announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
    Route::put('/announcements/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
    
    // Announcement comments
    Route::post('/announcements/{announcement}/comments', [AnnouncementCommentController::class, 'store'])->name('announcements.comments.store');
    Route::delete('/announcement-comments/{comment}', [AnnouncementCommentController::class, 'destroy'])->name('announcements.comments.destroy');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/notifications/preferences', [NotificationPreferenceController::class, 'index'])->name('notifications.preferences');
    Route::post('/notifications/preferences', [NotificationPreferenceController::class, 'update'])->name('notifications.preferences.update');

    // Messaging
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/create', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{conversation}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}/reply', [MessageController::class, 'reply'])->name('messages.reply');

    // Admin Only
    Route::middleware(['role:super-admin|admin'])->group(function() {
        Route::get('/admin/activity-logs', [App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('admin.activity-logs.index');
    });
});
// Webhooks (Exclude from CSRF)
Route::post('/webhooks/payments/{slug}', [PaymentController::class, 'webhook'])->name('payments.webhook');

require __DIR__.'/auth.php';
