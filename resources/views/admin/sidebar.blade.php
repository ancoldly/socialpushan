<div class="grid w-[300px] border-[2px] border-t-0 h-max items-start">
    <div class="border-b-[2px] p-[20px]">
        <h1 class="font-medium flex items-center gap-[10px]"><img src="/image/logo.png" class="w-[50px] h-[50px]" alt=""> {{ $auth->name }}</h1>
    </div>

    <div>
        <a class="p-[20px] w-full font-medium flex items-center gap-[10px] hover:bg-gray-200" href="{{ route('admin.home') }}"><i class='bx text-[25px] bxs-dashboard'></i> Dashboard</a>
        <a class="p-[20px] w-full font-medium flex items-center gap-[10px] hover:bg-gray-200" href="{{ route('admin.showUser') }}"><i class='bx text-[25px] bxs-user' ></i> All users</a>
        <a class="p-[20px] w-full font-medium flex items-center gap-[10px] hover:bg-gray-200" href="{{ route('admin.showPost') }}"><i class='bx text-[25px] bxs-news' ></i> All posts</a>
    </div>
</div>
