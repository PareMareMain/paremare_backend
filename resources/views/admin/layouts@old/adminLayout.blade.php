<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layouts.head')
</head>

<body>

    @include('admin.layouts.sidebar')
    <!-- /# sidebar -->

    @include('admin.layouts.header')


    <div class="content-wrap">
        <div class="main">
            @yield('content')
        </div>
    </div>

    @include('admin.layouts.scripts')
    @yield('scripts')
</body>

</html>
