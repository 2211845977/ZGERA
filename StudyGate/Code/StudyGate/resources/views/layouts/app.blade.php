<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
    <div class="wrapper">

        {{-- Navbar --}}
        @if(auth()->check())
            @if(auth()->user()->role == 'admin')
                @include('partials.navbar')
            @elseif(auth()->user()->role == 'teacher')
                @include('partials.navbar-teacher')
            @elseif(auth()->user()->role == 'student')
                @include('partials.navbar-std')
            @endif
        @endif
        {{-- Sidebar --}}
        @if(auth()->check())
            @if(auth()->user()->role == 'admin')
                @include('partials.sidebar-admin')
            @elseif(auth()->user()->role == 'teacher')
                @include('partials.sidebar-teacher')
            @elseif(auth()->user()->role == 'student')
                @include('partials.sidebar-std')
            @endif
        @endif

        {{-- Page Content --}}
        <div class="content-wrapper">
            @yield('content')
        </div>

        {{-- Footer --}}
        @include('partials.footer')


    </div>

    {{-- Scripts --}}
    @include( 'partials.scripts')

</body>

</html>