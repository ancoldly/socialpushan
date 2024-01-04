<div class="grid">
    <div
        class="pt-[auto] flex items-end justify-between w-full h-max bg-white p-[30px] rounded-t-[10px] border-b-[2px]">
        <input type="hidden" name="return_to" value="">
        <div class="flex items-center gap-[20px]">
            <div class="border-[2px] border-blue-500 p-[3px] rounded-full">
                <img id="avatar-preview" src="{{ $user->avatar ? $user->avatar : $avatar_temp }}" alt=""
                    class="w-[150px] h-[150px] rounded-full">
            </div>

            <div class="grid">
                <span class="font-semibold text-[22px] flex items-center gap-[5px]">{{ $user->name }}<i
                        class='bx bxs-check-circle text-blue-500'></i></span>
                <p class="font-semibold text-[14px] text-gray-500">
                    @if ($acceptedFriends->count() > 0)
                        {{ $acceptedFriends->count() }} Friend
                    @else
                        No friend
                    @endif
                </p>
            </div>
        </div>

        <div class="flex items-center gap-[10px]">
            @if ($status && $status->status !== null)
                @if ($status->status == 'pending')
                    @if ($status->user_id == Auth::id())
                        <form class="addFriend-form" action="{{ route('addFriend') }}" method="POST">
                            @csrf
                            <input type="hidden" name="friend_id" value="{{ $user->id }}">
                            <button
                                class="font-semibold w-max px-[20px] rounded-[5px] h-[40px] text-blue-500 bg-gray-200 flex items-center gap-[10px] justify-center"
                                type="submit" name="addFriend">
                                <i class='bx bx-x text-[28px]'></i>Cancel invitation
                            </button>
                        </form>
                    @else
                        <form class="acceptedFriend-form" action="{{ route('acceptedFriend') }}" method="POST">
                            @csrf
                            <input type="hidden" name="friend_id" value="{{ $user->id }}">
                            <button
                                class="font-semibold w-max px-[20px] rounded-[5px] h-[40px] text-blue-500 bg-gray-200 flex items-center gap-[10px] justify-center"
                                type="submit" name="addFriend">
                                <i class='bx bx-check text-[28px]'></i>Accept invitation
                            </button>
                        </form>

                        <form class="addFriend-form" action="{{ route('deleteFriend') }}" method="POST">
                            @csrf
                            <input type="hidden" name="friend_id" value="{{ $user->id }}">
                            <button
                                class="font-semibold w-max px-[20px] rounded-[5px] h-[40px] text-blue-500 bg-gray-200 flex items-center gap-[10px] justify-center"
                                type="submit" name="addFriend">
                                <i class='bx bx-x text-[28px]'></i>Delete invitation
                            </button>
                        </form>
                    @endif
                @else
                    <form class="addFriend-form" action="{{ route('deleteFriend') }}" method="POST">
                        @csrf
                        <input type="hidden" name="friend_id" value="{{ $user->id }}">
                        <button
                            class="font-semibold w-max px-[20px] rounded-[5px] h-[40px] text-blue-500 bg-gray-200 flex items-center gap-[10px] justify-center"
                            type="submit" name="addFriend">
                            <i class='bx bx-user-check text-[28px]'></i>Friend
                        </button>
                    </form>
                @endif
            @else
                <form class="addFriend-form" action="{{ route('addFriend') }}" method="POST">
                    @csrf
                    <input type="hidden" name="friend_id" value="{{ $user->id }}">
                    <button
                        class="font-semibold w-max px-[20px] rounded-[5px] h-[40px] text-blue-500 bg-gray-200 flex items-center gap-[10px] justify-center"
                        type="submit" name="addFriend">
                        <i class='bx bxs-user-plus text-[28px]'></i>Add friend
                    </button>
                </form>
            @endif

            @if ($roomId == null)
            @else
                <form action="messageDetails" method="GET">
                    <input type="hidden" name="roomId" value="{{ $roomId }}">
                    <button
                        class="font-semibold w-max px-[20px] rounded-[5px] h-[40px] text-blue-500 bg-gray-200 flex items-center gap-[10px] justify-center"><i
                            class='bx bxl-messenger text-[28px]'></i>Messenger</button>
                </form>
            @endif
        </div>
    </div>

    <div class="w-full h-max bg-white px-[30px] flex items-center justify-between py-[10px] rounded-b-[10px]">
        <div class="flex">
            <form action="{{ route('show-profileDetails') }}" method="GET">
                <input type="hidden" name="userId" value="{{ $user->id }}">
                <button id="main-post" class="w-max h-[40px] p-[10px] font-semibold">Posts</button>
            </form>

            <form action="{{ route('profileDetails.friends') }}" method="GET">
                <input type="hidden" name="userId" value="{{ $user->id }}">
                <button id="main-friend" class="w-max h-[40px] p-[10px] font-semibold">Friends</button>
            </form>

            <form action="{{ route('profileDetails.images') }}" method="GET">
                <input type="hidden" name="userId" value="{{ $user->id }}">
                <button id="main-image" class="w-max h-[40px] p-[10px] font-semibold">Image</button>
            </form>
        </div>

        <div>
            <button class="w-[40px] h-[40px] bx bx-menu bg-gray-200 text-[22px] font-semibold rounded-[5px]"></button>
        </div>
    </div>
</div>
