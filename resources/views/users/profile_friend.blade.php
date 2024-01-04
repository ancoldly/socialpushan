<!DOCTYPE html>
<html lang="en">

<head>
    @include('head');
    <title>Profile Pushan</title>
</head>

<body class="overflow-x-hidden">
    @include('users/header');
    @include('users/notification');
    <main class="w-full h-max grid pt-[90px] items-cente py-[10px] px-[150px] bg-gray-200 gap-[10px]">
        @include('users.profile_info')

        <div id="dynamic-content">
            @include('users.friend')
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="/Script/home.js"></script>
    <script src="/Script/ajax.js"></script>
</body>

</html>
