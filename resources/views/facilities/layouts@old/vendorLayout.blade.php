<!DOCTYPE html>
<html lang="en">

<head>
    @include('facilities.layouts.head')
</head>

<body>

    @include('facilities.layouts.sidebar')
    <!-- /# sidebar -->

    @include('facilities.layouts.header')


    <div class="content-wrap">
        <div class="main">
            @yield('content')
        </div>
    </div>

    @include('facilities.layouts.scripts')
    @yield('scripts')
</body>

</html>
