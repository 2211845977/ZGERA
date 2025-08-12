<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.html" class="brand-link">
        <img src="{{asset('adminlte/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">StudyGate</span>
    </a>
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('adminlte/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="" class="d-block">
                    {{ Auth::user()->name }}
                </a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="البحث" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('teacher.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>لوحة التحكم</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('teacher.profile') }}" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>الملف الشخصي</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('teacher.subjects') }}" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>المواد المكلف بها</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('teacher.schedules') }}" class="nav-link">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>الجدول الدراسي</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('teacher.monitor-grades') }}" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>رصد الدرجات</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('teacher.notifications') }}" class="nav-link">
                        <i class="nav-icon fas fa-bell"></i>
                        <p>الإشعارات</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>تسجيل الخروج</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside> 
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>