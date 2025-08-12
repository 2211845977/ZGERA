<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" >

    <!-- Brand Logo -->
    <a href="" class="brand-link">
        <img src="{{asset('adminlte/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">
            نظام إدارة المختبرات
        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
    {{ optional(Auth::user())->name }}
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" 
                data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="{{route("dashboard.index")}}" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>لوحة التحكم</p>
                    </a>
                </li>

                <!-- إدارة الحرم الجامعية -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-university"></i>
                        <p>
                            إدارة الحرم الجامعية
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{ route('campuses.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>عرض الحُرُم</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- إدارة المباني -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            إدارة المباني
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{ route('buildings.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>عرض المباني</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- إدارة المختبرات -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-flask"></i>
                        <p>
                            إدارة المختبرات
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{route("labs.index")}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>عرض المختبرات</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- جرد الأجهزة -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-microchip"></i>
                        <p>
                            إدارة الأجهزة
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{ route('instruments.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>عرض الأجهزة</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- إدارة الحجوزات -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>
                            إدارة الحجوزات
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{ route('bookings.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>قائمة الحجوزات</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- إدارة المستخدمين -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            إدارة المستخدمين
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{route('users.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>قائمة المستخدمين</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- تسجيل الخروج -->
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-left p-0" style="color: #c2c7d0; width: 100%; text-align: right;">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p class="d-inline">تسجيل الخروج</p>
                        </button>
                    </form>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
