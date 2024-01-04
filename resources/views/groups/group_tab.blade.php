<div class="grid bg-gray-100 w-[450px] p-[20px] rounded-[10px] gap-[10px] fixed">
    <div class="flex items-center justify-between">
        <h1 class="font-semibold text-[20px]">Groups</h1>

        <button class="w-[40px] h-[40px] bg-gray-300 flex items-center justify-center rounded-full"><i
                class='bx bxs-cog text-[25px]'></i></button>
    </div>

    <form id="joinGroup-form" action="{{ route('JoinGroup') }}" method="POST" class="joinGroup-form w-full">
        @csrf

        <div class="bg-gray-100 flex items-center justify-between border-[2px]">
            <input type="text" name="codeGroup" placeholder="Enter code group"
                class="outline-none w-[70%] bg-gray-100 p-[10px]" autocomplete="off">
            <button type="submit" class="font-semibold bg-gray-200 p-[10px]">Join group</button>
        </div>
    </form>

    <div class="overflow-y-scroll scroll-container h-[560px]">
        <div class="grid">
            <a href="group">
                <button
                    class="w-full p-[10px] flex items-center gap-[10px] font-semibold hover:bg-gray-200 rounded-[5px]"><i
                        class='bx bxs-news text-[25px] bg-gray-200 rounded-full p-[10px]'></i>Your feed</button>
            </a>

            <a href="group.discover">
                <button
                    class="w-full p-[10px] flex items-center gap-[10px] font-semibold hover:bg-gray-200 rounded-[5px]"><i
                        class='bx bxs-compass text-[25px] bg-gray-200 rounded-full p-[10px]'></i>Discover</button>
            </a>

            <a href="group.yourGroup">
                <button
                class="w-full p-[10px] flex items-center gap-[10px] font-semibold hover:bg-gray-200 rounded-[5px]"><i
                    class='bx bxs-group text-[25px] bg-gray-200 rounded-full p-[10px]'></i>Your groups</button>
            </a>
        </div>

        <a href="create_Group">
            <button
                class="text-blue-500 bg-blue-100 p-[10px] rounded-[5px] font-semibold flex items-center justify-center gap-[10px] w-full my-[10px]"><i
                    class='bx bx-plus text-[25px]'></i>Create New Group</button>
        </a>

        <div class="border-t-[2px] py-[10px] grid gap-[10px]">
            <h1 class="font-semibold text-[18px] py-[10px]">Groups you manage</h1>

            <div class="grid">
                @if ($groups->count() > 0)
                    @foreach ($groups as $group)
                        <div
                            class="flex items-center justify-between hover:bg-gray-200 rounded-[5px] cursor-pointer p-[10px]">
                            <div class="flex items-center gap-[10px]">
                                <img src="{{ $group->avatar }}" class="w-[50px] h-[50px] rounded-[10px]" alt="">

                                <div class="grid">
                                    <form action="{{ route('groupDetails') }}" method="GET">
                                        <input type="hidden" name="idGroup" value="{{ $group->id }}">
                                        <button type="submit" class="font-semibold">{{ $group->name }}</button>
                                    </form>

                                    <p class="text-gray-500">{{ $group->created_at }}</p>
                                </div>
                            </div>

                            <form class="deleteGroup-form" action="{{ route('deleteGroup') }}" method="POST"
                                data-group-id="{{ $group->id }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="group_id" value="{{ $group->id }}">
                                <button type="submit"
                                    class="w-[40px] h-[40px] text-[30px] rounded-full text-red-500 bx bx-x-circle flex items-center justify-center"></button>
                            </form>
                        </div>
                    @endforeach
                @else
                    <p class="font-medium text-red-500 text-center pb-[20px]">No group created</p>
                @endif
            </div>
        </div>

        <div class="border-t-[2px] pt-[10px] grid gap-[10px]">
            <div class="flex items-center justify-between">
                <h1 class="font-semibold text-[18px]">Groups you've joined</h1>

                <button class="text-blue-500 p-[10px] hover:bg-gray-100 rounded-[5px] font-medium">See
                    all</button>
            </div>

            <div class="grid">
                @php
                    $count = 0;
                @endphp

                @foreach ($groupUsers as $groupUser)
                    @if ($groupUser->user_id == Auth::id())
                        <div
                            class="flex items-center gap-[10px] p-[10px] hover:bg-gray-200 rounded-[5px] cursor-pointer">
                            <img src="{{ $groupUser->group->avatar }}" class="w-[50px] h-[50px] rounded-[10px]"
                                alt="">

                            <div class="grid">
                                <form action="{{ route('groupDetails') }}" method="GET">
                                    <input type="hidden" name="idGroup" value="{{ $groupUser->group->id }}">
                                    <button type="submit" class="font-semibold">{{ $groupUser->group->name }}</button>
                                </form>

                                <p class="text-gray-500">{{ $groupUser->group->created_at }}</p>
                            </div>
                        </div>

                        @php
                            $count++;
                            if ($count == 3) {
                                break;
                            }
                        @endphp
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
