<div class="grid items-center bg-white rounded-[10px] p-[20px]">
    <div class="flex items-center justify-between">
        <h1 class="font-semibold text-[20px]">Friends</h1>

        <div class="flex items-center gap-[20px]">
            <form id="search-form" class="relative" action="{{ route('search') }}" method="GET">
                <div class="w-[250px] flex h-[40px] px-[10px] items-center gap-[5px] bg-gray-200 rounded-[30px]">
                    <i class='bx bx-search text-[22px] text-gray-500'></i>
                    <input type="text" id="search-input" name="search" placeholder="Start typing to search.."
                        class="outline-none w-full bg-gray-200" autocomplete="off">
                </div>

                <div id="search-results"
                    class="search-results absolute mt-[10px] p-[15px] rounded-[10px] bg-blue-100 gap-[15px] w-full hidden">

                </div>
            </form>

            <a href="profile.friends.requests">
                <button type="submit"
                    class="font-semibold text-blue-500 hover:bg-gray-200 p-[10px] rounded-[5px]">Friend
                    requests</button>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-[10px] py-[50px]">
        @foreach ($friends as $friend)
            @if ($friend->status == 'accepted')
                @php
                    $friendUser = $friend->user_id == Auth::id() ? $friend->friend : ($friend->friend_id == Auth::id() ? $friend->user : null);
                @endphp

                @if ($friendUser)
                    <div class="flex justify-between items-center border-[1px] p-[10px] rounded-[10px] border-gray-200">
                        <form action="{{ route('show-profileDetails') }}" method="GET"
                            class="flex gap-[10px] items-center">
                            <img src="{{ $friendUser->avatar ? $friendUser->avatar : $avatar_temp }}" alt=""
                                class="rounded-full h-[60px] w-[60px]">
                            <input type="hidden" name="userId" value="{{ $friendUser->id }}">
                            <button type="submit" class="font-semibold flex items-center gap-[5px]">
                                <span class="font-semibold">{{ $friendUser->name }}</span>
                                <i class="bx bxs-check-circle text-blue-500"></i>
                            </button>
                        </form>

                        <form class="addFriend-form" action="{{ route('deleteFriend') }}" method="POST">
                            @csrf
                            <input type="hidden" name="friend_id" value="{{ $friendUser->id }}">
                            <button
                                class="font-semibold w-max px-[20px] rounded-[5px] h-[40px] text-blue-500 bg-gray-200 flex items-center gap-[10px] justify-center"
                                type="submit" name="addFriend">
                                <i class='bx bx-user-check text-[28px]'></i>Friend
                            </button>
                        </form>
                    </div>
                @endif
            @endif
        @endforeach

    </div>
</div>
