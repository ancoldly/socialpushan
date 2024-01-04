<div class="grid items-center bg-white rounded-[10px] p-[20px]">
    <div class="flex items-center justify-between">
        <h1 class="font-semibold text-[20px]">Friends request</h1>
    </div>

    <div class="grid grid-cols-4 gap-[10px] py-[50px]">
        @if ($FriendRequests->isNotEmpty())
            @foreach ($FriendRequests as $FriendRequest)
                <div class="grid gap-[20px] bg-blue-50 pt-[10px] justify-center items-center border-[2px] p-[10px] rounded-[10px]">
                    <div class="grid items-center gap-[20px]">
                        <img src="{{ $FriendRequest->user->avatar ? $FriendRequest->user->avatar : $avatar_temp }}" alt="" class="w-[100px] h-[100px] mx-auto rounded-[5px]">
                        
                        <div class="grid">
                            <form action="{{ route('show-profileDetails') }}" method="GET">
                                <input type="hidden" name="userId" value="{{ $FriendRequest->user->id }}">
                                <button type="submit" class="font-semibold flex items-center gap-[5px]">
                                    {{ $FriendRequest->user->name }}
                                </button>
                            </form>
                            <p class="text-gray-500 text-[14px]">{{ $FriendRequest->created_at }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-[20px]">
                        <form class="acceptedFriend-form" action="{{ route('acceptedFriend') }}"
                            method="POST">
                            @csrf
                            <input type="hidden" name="friend_id" value="{{ $FriendRequest->user->id }}">
                            <button
                                class="w-[100px] h-[35px] bg-mainColors rounded-[20px] text-white font-semibold"
                                type="submit">Confirm</button>
                        </form>

                        <form class="addFriend-form" action="{{ route('deleteFriend') }}" method="POST">
                            @csrf
                            <input type="hidden" name="friend_id" value="{{ $FriendRequest->user->id }}">
                            <button class="w-[100px] h-[35px] bg-gray-200 rounded-[20px] font-semibold"
                                type="submit">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        @else
            <p>There are no friend requests.</p>
        @endif
    </div>
</div>
