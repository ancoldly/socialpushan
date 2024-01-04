<header class="w-full h-[100px] flex items-center justify-between py-[20px] px-[50px] fixed top-0 bg-white z-[1000]">
    <a href="home">
        <div class="flex items-center cursor-pointer">
            <img src="/image/logo.png" class="w-[50px] h-[50px]" alt="">
            <h1 class="text-[30px] font-bold text-blue-500">Fushan.</h1>
        </div>
    </a>

    <div class="flex items-center gap-[30px] justify-center">
        <form id="search-form" class="relative" action="{{ route('search') }}" method="GET">
            <div class="w-[350px] flex h-[50px] px-[10px] items-center gap-[5px] bg-gray-200 rounded-[30px]">
                <i class='bx bx-search text-[22px] text-gray-500'></i>
                <input type="text" id="search-input" name="search" placeholder="Start typing to search.."
                    class="outline-none w-full bg-gray-200" autocomplete="off">
            </div>

            <div id="search-results"
                class="absolute mt-[10px] p-[15px] rounded-[10px] bg-blue-100 gap-[15px] w-full hidden">

            </div>
        </form>

        <div class="flex items-center justify-center gap-[15px]">
            <a href="home">
                <button
                    class="w-[50px] h-[50px] bg-gray-200 rounded-full bx bx-home text-gray-500 text-[26px]"></button>
            </a>
            <a href="stories">
                <button
                    class="w-[50px] h-[50px] bg-gray-200 rounded-full bx bxs-zap text-gray-500 text-[26px]"></button>
            </a>
            <button
                class="w-[50px] h-[50px] bg-gray-200 rounded-full text-gray-500 text-[26px] bx bx-camera-movie"></button>
            <a href="profile">
                <button
                    class="w-[50px] h-[50px] bg-gray-200 rounded-full text-gray-500 text-[26px] bx bx-user"></button>
            </a>
            <button class="w-[50px] h-[50px] bg-gray-200 rounded-full text-gray-500 text-[26px] bx bx-cart"></button>
        </div>
    </div>

    <div class="flex items-center justify-center gap-[15px]">
        <button class="w-[50px] h-[50px] text-mainColors rounded-full bx bx-bell text-[30px] show-tools-tell"></button>
        <button
            class="w-[50px] h-[50px] text-mainColors rounded-full bx bx-chat text-[30px] show-tools-message"></button>
        <a href="changeInfo">
            <button class="w-[50px] h-[50px] text-mainColors rounded-full bx bx-cog bx-spin text-[30px]"></button>
        </a>
        <button class="w-[30px] h-[30px] text-mainColors rounded-full text-[30px] show-tools-profile">
            <img src="{{ $user->avatar ? $user->avatar : $avatar_temp }}" alt=""
                class="rounded-full w-[30px] h-[30px] avatar-user">
        </button>
    </div>

    <div
        class="w-[25%] h-max p-[10px] fixed bg-blue-50 right-[50px] top-[110px] hidden rounded-[10px] cursor-pointer tools-tell border-[2px] border-blue-500">
        <div class="flex justify-between items-center border-b-[2px] pb-[5px]">
            <h1 class="font-medium text-[18px]">Notifications</h1>

            <form action="{{ route('deleteTell') }}" method="POST" id="deleteTell-form">
                @csrf
                @method('DELETE')
                <button type="submit">
                    <i class='bx bxs-trash-alt text-[25px]'></i>
                </button>
            </form>
        </div>

        <div class="overflow-y-scroll h-[400px] scroll w-full scroll-container pt-[10px]">
            @foreach ($userActivities as $activity)
                <div class="flex items-center pb-[10px]">
                    <img src="{{ $activity->user->avatar }}" class="rounded-full w-[60px] h-[60px]" alt="">

                    <div class="px-[10px]">
                        <p>
                            <span class="font-medium">{{ $activity->user->name }}</span>
                            @if ($activity->type == 'like')
                                Your post was liked.
                            @elseif ($activity->type == 'comment')
                                Your post was comment.
                            @else
                                Your post was share.
                            @endif
                        </p>

                        <span class="text-[14px] text-gray-500">{{ $activity->created_at }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div
        class="hidden items-center gap-[20px] w-[25%] rounded-[10px] p-[20px] fixed bg-blue-50 right-[50px] top-[110px] tools-message border-[2px] border-blue-500">
        <div class="flex items-center justify-between">
            <h1 class="font-semibold">Chats</h1>

            <button class="w-[40px] h-[40px] text-[30px] rounded-full bg-gray-200 transition-all">
                <i class='bx bx-dots-horizontal-rounded'></i>
            </button>
        </div>

        <div>
            <form id="" class="relative" action="" method="GET">
                <div class="w-full flex h-[40px] px-[10px] items-center gap-[5px] bg-gray-200 rounded-[30px]">
                    <i class='bx bx-search text-[22px] text-gray-500'></i>
                    <input type="text" id="search-input" name="search" placeholder="Start typing to search.."
                        class="outline-none w-full bg-gray-200" autocomplete="off">
                </div>
            </form>
        </div>

        @if ($firstJoinedGroup && optional($firstJoinedGroup)->room_id)
            <div class="flex items-center gap-[10px]">
                <button class="p-[10px] bg-gray-200 rounded-[10px] font-semibold text-blue-500">Inbox</button>

                <form action="{{ route('chatGroupDetails') }}" method="GET">
                    <input type="hidden" name="room_id" value="{{ optional($firstJoinedGroup)->room_id }}">
                    <button class="p-[10px] bg-gray-200 rounded-[10px] font-semibold text-blue-500">Group Chat</button>
                </form>
            </div>
        @else
            <form id="joinChatGroup-form" action="{{ route('JoinGroupChat') }}" method="POST"
                class="flex items-center justify-between border-t-[2px] pt-[20px]">
                @csrf
                <p class="font-semibold">Code group</p>

                <div class="w-[180px] border-[2px] p-[10px] border-blue-200 rounded-[5px]">
                    <input type="text" name="room_id" class="outline-none w-full h-full bg-blue-50"
                        placeholder="Enter code group">
                </div>

                <button class="bg-gray-200 font-semibold rounded-[5px] p-[10px]">Join</button>
            </form>
        @endif

        <div class="overflow-y-scroll h-[400px] scroll w-full pr-[10px] scroll-container">
            @foreach ($friends as $friend)
                @if ($friend->status == 'accepted')
                    @if ($friend->user_id == Auth::id())
                        @if ($friend->friend)
                            <div class="flex gap-[20px] items-center w-full py-[10px]">
                                <img src="{{ $friend->friend->avatar ? $friend->friend->avatar : $avatar_temp }}"
                                    alt="" class="w-[50px] h-[50px] rounded-full avatar-user">
                                <div class="flex justify-between items-center w-full">
                                    <div>
                                        <form action="messageDetails" method="GET">
                                            <input type="hidden" name="roomId" value="{{ $friend->room_id }}">
                                            <button type="submit" class="font-semibold flex items-center gap-[5px]">
                                                {{ $friend->friend->name }}
                                                <i class="bx bxs-check-circle text-blue-500"></i>
                                            </button>
                                        </form>

                                        <p class="text-gray-500">
                                            {{ \Illuminate\Support\Str::limit(optional($friend->friend->messagesWith(Auth::user())->first())->content, 25) }}
                                        </p>
                                    </div>

                                    <div id="notification" data-id="{{ $friend->friend->id }}">
                                        @if ($friend->friend->status == 'online')
                                            <i class='bx bxs-circle text-[12px] text-green-500'></i>
                                        @else
                                            <i class='bx bxs-circle text-[12px] text-red-500'></i>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @elseif ($friend->friend_id == Auth::id())
                        @if ($friend->user)
                            <div class="flex gap-[20px] items-center w-full py-[10px]">
                                <img src="{{ $friend->user->avatar ? $friend->user->avatar : $avatar_temp }}"
                                    alt="" class="w-[50px] h-[50px] rounded-full avatar-user">
                                <div class="flex justify-between items-center w-full">
                                    <div>
                                        <form action="messageDetails" method="GET">
                                            <input type="hidden" name="roomId" value="{{ $friend->room_id }}">
                                            <button type="submit" class="font-semibold flex items-center gap-[5px]">
                                                {{ $friend->user->name }}
                                                <i class="bx bxs-check-circle text-blue-500"></i>
                                            </button>
                                        </form>

                                        <p class="text-gray-500">
                                            {{ \Illuminate\Support\Str::limit(optional($friend->user->messagesWith(Auth::user())->first())->content, 25) }}
                                        </p>
                                    </div>

                                    <div class="notification" data-id="{{ $friend->user->id }}">
                                        @if ($friend->user->status == 'online')
                                            <i class='bx bxs-circle text-[12px] text-green-500'></i>
                                        @else
                                            <i class='bx bxs-circle text-[12px] text-red-500'></i>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                @endif
            @endforeach
        </div>
    </div>

    <div
        class="w-[25%] h-max p-[10px] fixed bg-blue-50 right-[50px] top-[110px] rounded-[10px] gap-[10px] cursor-pointer tools-profile hidden border-[2px] border-blue-500">
        <a href="profile" class="flex items-center gap-[10px] border-b-2 border-gray-300 pb-[10px]">
            <div class="w-[40px] h-[40px] bg-gray-200 rounded-full text-gray-500 text-[26px]"><img
                    class="rounded-full w-[40px] h-[40px]" src="{{ $user->avatar ? $user->avatar : $avatar_temp }}"
                    alt=""></div>
            <p class="font-semibold text-gray-500 flex items-center gap-[5px]">{{ $user->name }}<i
                    class='bx bxs-check-circle text-blue-500'></i></p>
        </a>

        <a href="changeInfo" class="flex items-center gap-[10px] border-b-2 border-gray-300 pb-[10px]">
            <div
                class="w-[40px] h-[40px] bg-gray-300 rounded-full text-gray-500 text-[26px] bx bx-cog flex items-center justify-center">
            </div>
            <p class="font-semibold text-gray-500">Edit Infomation</p>
        </a>

        <a href="{{ route('logout') }}" class="flex items-center gap-[10px]">
            <div
                class="w-[40px] h-[40px] bg-gray-300 rounded-full text-gray-500 text-[26px] bx bx-log-out flex items-center justify-center">
            </div>
            <p class="font-semibold text-gray-500">Logout</p>
        </a>
    </div>
</header>
