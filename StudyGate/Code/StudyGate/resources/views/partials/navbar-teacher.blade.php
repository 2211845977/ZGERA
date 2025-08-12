<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('adminlte/dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="" class="nav-link">الرئيسية</a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Navbar Search -->
    <li class="nav-item">
      <a class="nav-link" data-widget="navbar-search" href="#" role="button">
        <i class="fas fa-search"></i>
      </a>
      <div class="navbar-search-block">
        <form class="form-inline">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="البحث" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
              <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </li>

    <!-- User Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fas fa-user"></i>
        {{ Auth::user()->name }}
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">{{ Auth::user()->name }}</span>
        <div class="dropdown-divider"></div>
        <a href="" class="dropdown-item">
          <i class="fas fa-user mr-2"></i> الملف الشخصي
        </a>
        <div class="dropdown-divider"></div>
        <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="fas fa-sign-out-alt mr-2"></i> تسجيل الخروج
        </a>
      </div>
    </li>

    <!-- Notifications Dropdown Menu -->
    @php
    use App\Models\Notification;

    // جلب آخر 5 إشعارات
    $notifications = Notification::latest()->take(5)->get();

    // عدد الإشعارات غير المقروءة
    $unreadCount = Notification::where('is_read', false)->count();
@endphp

<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        @if($unreadCount > 0)
            <span class="badge badge-warning navbar-badge">{{ $unreadCount }}</span>
        @endif
    </a>

    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">
            {{ $unreadCount }} إشعار غير مقروء
        </span>

        <div class="dropdown-divider"></div>

        @forelse($notifications as $notification)
            <a href="{{ route('teacher.notifications') }}" class="dropdown-item">
                <i class="fas fa-info-circle mr-2"></i> {{ $notification->title }}
                <span class="float-right text-muted text-sm">
                    {{ $notification->created_at->diffForHumans() }}
                </span>
            </a>
            <div class="dropdown-divider"></div>
        @empty
            <span class="dropdown-item text-center text-muted">لا توجد إشعارات</span>
        @endforelse

        <a href="{{ route('teacher.notifications') }}" class="dropdown-item dropdown-footer">
            عرض كل الإشعارات
        </a>
    </div>
</li>

  </ul>
</nav>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>