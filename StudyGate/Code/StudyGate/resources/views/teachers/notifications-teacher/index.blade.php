@extends('layouts.app')

@section('title', 'الإشعارات')

@section('content')
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>الإشعارات</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active">الإشعارات</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bell mr-2"></i>الإشعارات
                        <span class="badge badge-danger ml-2">{{ $notifications->where('is_read', false)->count() }}
                            جديد</span>
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-filter"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                                <a class="dropdown-item" href="#">جميع الإشعارات</a>
                                <a class="dropdown-item" href="#">غير المقروءة</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">المحاضرات</a>
                                <a class="dropdown-item" href="#">الإعلانات</a>
                                <a class="dropdown-item" href="#">المهام</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-tabs" id="notification-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="unread-tab" data-toggle="pill" href="#unread" role="tab">
                                غير المقروءة <span
                                    class="badge badge-danger">{{ $notifications->where('is_read', false)->count() }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="all-tab" data-toggle="pill" href="#all" role="tab">الكل</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="archived-tab" data-toggle="pill" href="#archived"
                                role="tab">المؤرشفة</a>
                        </li>
                    </ul>
                    <div class="tab-content p-0">
                        <!-- تبويب الإشعارات غير المقروءة -->
                        <div class="tab-pane fade show active" id="unread" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped mb-0">
                                    <tbody>
                                        @forelse($notifications->where('is_read', false) as $notification)
                                            <tr class="notification-unread">
                                                <td width="50" class="text-center">
                                                    @if($notification->type == 'lecture')
                                                        <i class="fas fa-calendar-exclamation fa-2x text-warning"></i>
                                                    @elseif($notification->type == 'announcement')
                                                        <i class="fas fa-bullhorn fa-2x text-info"></i>
                                                    @elseif($notification->type == 'task')
                                                        <i class="fas fa-tasks fa-2x text-success"></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="font-weight-bold">{{ $notification->title }}</div>
                                                    <div class="text-sm">{{ $notification->body }}</div>
                                                    <div class="text-xs text-muted">
                                                        {{ $notification->created_at->diffForHumans() }}</div>
                                                </td>
                                                <td width="120" class="text-center">
                                                    <form method="POST"
                                                        action="{{ route('notifications.read', $notification->id) }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-primary">تعيين
                                                            كمقروء</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">لا توجد إشعارات غير مقروءة</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- تبويب جميع الإشعارات -->
                        <div class="tab-pane fade" id="all" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped mb-0">
                                    <tbody>
                                        @forelse($notifications as $notification)
                                            <tr class="{{ $notification->is_read ? '' : 'notification-unread' }}">
                                                <td width="50" class="text-center">
                                                    @if($notification->type == 'lecture')
                                                        <i class="fas fa-calendar-exclamation fa-2x text-warning"></i>
                                                    @elseif($notification->type == 'announcement')
                                                        <i class="fas fa-bullhorn fa-2x text-info"></i>
                                                    @elseif($notification->type == 'task')
                                                        <i class="fas fa-tasks fa-2x text-success"></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="font-weight-bold">{{ $notification->title }}</div>
                                                    <div class="text-sm">{{ $notification->body }}</div>
                                                    <div class="text-xs text-muted">
                                                        {{ $notification->created_at->diffForHumans() }}</div>
                                                </td>
                                                <td width="120" class="text-center">
                                                    @if(!$notification->is_read)
                                                        <form method="POST"
                                                            action="{{ route('notifications.read', $notification->id) }}">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-outline-primary">تعيين
                                                                كمقروء</button>
                                                        </form>
                                                    @else
                                                        <span class="badge badge-secondary">مقروء</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">لا توجد إشعارات</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- تبويب الإشعارات المؤرشفة -->
                        <div class="tab-pane fade" id="archived" role="tabpanel">
                            <div class="p-3 text-center text-muted">
                                لا توجد إشعارات مؤرشفة
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <button class="btn btn-sm btn-default float-left">
                        <i class="fas fa-check-double mr-1"></i> تعيين الكل كمقروء
                    </button>
                    <form action="{{ route('teacher.notifications.destroyAll') }}" method="POST" class="float-left ml-2"
                        onsubmit="return confirm('هل أنت متأكد من حذف كل الإشعارات؟')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-default">
                            <i class="fas fa-trash-alt mr-1"></i> حذف الكل
                        </button>
                    </form>


                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        // تفعيل وظيفة تعيين الإشعار كمقروء
        document.addEventListener('DOMContentLoaded', function () {
            const notifications = document.querySelectorAll('.notification-unread');

            notifications.forEach(notification => {
                notification.addEventListener('click', function (e) {
                    if (!e.target.closest('button')) {
                        this.classList.remove('notification-unread');
                        this.querySelector('.font-weight-bold').style.color = '';
                        updateUnreadCount();
                    }
                });
            });

            function updateUnreadCount() {
                const unreadCount = document.querySelectorAll('.notification-unread').length;
                document.querySelectorAll('.badge-danger').forEach(badge => {
                    badge.textContent = unreadCount;
                    if (unreadCount === 0) badge.style.display = 'none';
                });
            }
        });
    </script>
@endsection