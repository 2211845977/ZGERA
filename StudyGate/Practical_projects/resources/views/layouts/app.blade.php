<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head')
</head>
<body>
    
    @include('partials.navbar') 

    @include('partials.sidebar')

    <div >

        @yield('content')
    </div>
    
    


    @include('partials.scripts')
</body>
</html>