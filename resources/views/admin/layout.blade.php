<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    @include('head')
</head>

<body>
    @include('admin.header')
    <div id="container" class="flex">
        @include('admin.sidebar')

        @yield('content')
    </div>
</body>

</html>
