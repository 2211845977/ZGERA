<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index()
    {
        // جلب جميع الإشعارات المطلوبة مرتبة من الأحدث
        $notifications = Notification::whereIn('type', ['lecture', 'announcement', 'task'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('teachers.notifications-teacher.index', compact('notifications'));
    }

    // تعيين إشعار كمقروء
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->is_read = true;
        $notification->save();

        return back();
    }
    public function destroyAll()
    {
        Notification::truncate();
        return back()->with('success', 'تم حذف كل الإشعارات بنجاح.');
    }

}
