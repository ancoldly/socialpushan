<!DOCTYPE html>
<html lang="en">

<head>
    @include('head');
    <title>Group Chat Pushan</title>
</head>

<body class="overflow-x-hidden">
    @include('users/header');
    @include('users/notification');

    <main class="flex w-full h-max py-[10px] gap-[10px] pt-[90px] px-[50px]">
        <div
            class="grid items-center gap-[20px] w-[30%] rounded-[10px] p-[20px] bg-blue-50 border-[2px] border-blue-500">
            <div class="flex items-center justify-between">
                <h1 class="font-semibold">Group Chats</h1>

                <a href="managerGroupChat">
                    <button class="w-max p-[10px] rounded-[5px] bg-blue-200 transition-all font-medium">
                        Manager chat
                    </button>
                </a>
            </div>

            <form id="joinChatGroup-form" action="{{ route('JoinGroupChat') }}" method="POST"
                class="flex items-center justify-between border-t-[2px] pt-[20px]">
                @csrf
                <p class="font-semibold">Code group</p>

                <div class="w-[150px] border-[2px] p-[10px] border-blue-200 rounded-[5px]">
                    <input type="text" name="room_id" class="outline-none w-full h-full bg-blue-50"
                        placeholder="Enter code group" autocomplete="off">
                </div>

                <button class="bg-gray-200 font-semibold rounded-[5px] p-[10px]">Join Group</button>
            </form>

            <div>
                <form id="" class="relative" action="" method="GET">
                    <div class="w-full flex h-[40px] px-[10px] items-center gap-[5px] bg-gray-200 rounded-[30px]">
                        <i class='bx bx-search text-[22px] text-gray-500'></i>
                        <input type="text" id="search-input" name="search" placeholder="Start typing to search.."
                            class="outline-none w-full bg-gray-200" autocomplete="off">
                    </div>
                </form>
            </div>

            <div class="overflow-y-scroll h-[400px] scroll w-full pr-[10px] scroll-container">
                @foreach ($groupMembers as $groupMember)
                    @if ($groupMember->user_id == Auth::id())
                        <form action="{{ route('chatGroupDetails') }}" method="GET">
                            <div class="flex gap-[20px] items-center w-full py-[10px]">
                                <input type="hidden" name="room_id" value="{{ $groupMember->group->room_id }}">
                                <img src="{{ $groupMember->group->avatar }}" alt=""
                                    class="w-[50px] h-[50px] rounded-full avatar-user">
                                <div class="flex justify-between items-center w-full">
                                    <div>
                                        <button type="submit" class="font-semibold flex items-center gap-[5px]">
                                            {{ $groupMember->group->group_name }}
                                            <i class="bx bxs-check-circle text-blue-500"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="grid w-[70%] border-[2px] border-blue-200 rounded-[10px] items-start">
            <div class="border-b-[2px] border-blue-200">
                <div class="flex justify-between items-center p-[20px]">
                    <div class="flex gap-[20px] items-center w-full relative">
                        <img src="{{ $chatGroups->avatar }}" alt=""
                            class="w-[45px] h-[45px] rounded-full avatar-user">

                        <div class="flex justify-between items-center w-full">
                            <div>
                                <button type="submit" class="font-semibold flex items-center gap-[5px]">
                                    {{ $chatGroups->group_name }}
                                    <i class="bx bxs-check-circle text-blue-500"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div>
                        @if ($chatGroups->created_by != Auth::id() && $chatGroups->members->contains('user_id', Auth::id()))
                            <form class="deleteMemberGroup-form" action="{{ route('deleteMemberGroup') }}"
                                data-member-id="{{ $chatGroups->members->where('user_id', Auth::id())->first()->id }}"
                                method="POST">
                                @method('DELETE')
                                @csrf
                                <input type="hidden" name="member_id"
                                    value="{{ $chatGroups->members->where('user_id', Auth::id())->first()->id }}">
                                <input type="hidden" name="action" value="out">
                                <button type="submit"
                                    class="w-[40px] h-[40px] text-[30px] rounded-full bg-gray-200 bx bx-log-out-circle flex items-center justify-center"></button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex items-start w-full">
                <div class="w-[65%] p-[20px] flex flex-col justify-between border-blue-100 overflow-y-scroll h-[510px] scroll-container border-r-[2px]"
                    id="container-message">
                    <div class="grid gap-[10px]">
                        @if ($chatGroups->members->contains('user_id', Auth::id()))
                            <div id="chat-messages">
                                @foreach ($groupMessages as $groupMessage)
                                    <div class="mb-4" data-sender-id="">
                                        <div class="flex justify-star items-end gap-[10px] message-result">
                                            <img src="{{ $groupMessage->user->avatar ? $groupMessage->user->avatar : '/image/user.png' }}"
                                                class="w-[35px] h-[35px] rounded-full" alt="">
                                            <div class="p-[10px] rounded-[10px] bg-blue-100 max-w-[500px] h-max"
                                                message-id="">
                                                <span class="font-medium flex items-center gap-[5px]">
                                                    {{ $groupMessage->user->name }}
                                                    @if ($groupMessage->user_id == $chatGroups->created_by)
                                                        <i class='bx bxs-group text-[20px] text-blue-500'></i>
                                                    @endif
                                                </span>
                                                <p>{{ $groupMessage->content }}</p>
                                                @if ($groupMessage->image !== null)
                                                    <img src="{{ $groupMessage->image }}" alt=""
                                                        class="w-[250px] my-[10px] rounded-[10px]">
                                                @endif
                                                <p class="text-[14px] font-medium text-gray-500">
                                                    {{ $groupMessage->created_at }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div>
                                <p class="text-blue-500 text-center">You're not a member of the group, so you can't see
                                    the conversation.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="w-[35%] grid gap-[10px] p-[20px]">
                    <div class="border-b-[2px] pb-[10px]">
                        <p class="font-medium">Code group: <span class="text-red-500">{{ $chatGroups->room_id }}</span>
                        </p>
                        <span class="font-semibold text-blue-500">List member group</span>
                    </div>

                    <div class="overflow-y-scroll h-[400px] scroll w-full scroll-container">
                        @foreach ($allMembers as $allMember)
                            <div class="flex gap-[20px] items-center w-full relative py-[10px]">
                                <img src="{{ $allMember->user->avatar ? $allMember->user->avatar : '/image/user.png' }}"
                                    alt="" class="w-[40px] h-[40px] rounded-full avatar-user">

                                <div class="flex justify-between items-center w-full">
                                    <form action="{{ route('show-profileDetails') }}" method="GET">
                                        <input type="hidden" name="userId" value="{{ $allMember->user->id }}">
                                        <button type="submit" class="font-semibold flex items-center gap-[5px]">
                                            {{ $allMember->user->name }}
                                        </button>
                                    </form>

                                    @if ($allMember->user->id == $chatGroups->created_by)
                                        <i class='bx bxs-group text-[22px] text-blue-500 mr-[10px]'></i>
                                    @else
                                        @if (Auth::id() == $chatGroups->created_by)
                                            <form class="deleteMemberGroup-form"
                                                action="{{ route('deleteMemberGroup') }}"
                                                data-member-id="{{ $allMember->id }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <input type="hidden" name="member_id" value="{{ $allMember->id }}">
                                                <input type="hidden" name="action" value="delete">
                                                <button type="submit"
                                                    class="bx bx-x-circle text-[22px] text-red-500 flex items-center mr-[10px]"></button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            @if ($chatGroups->members->contains('user_id', Auth::id()))
                <form class="chatMessageGroup-form" action="chatMessageGroup" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $chatGroups->room_id }}" name="room_id" id="roomGroup_id">
                    <input type="hidden" value="{{ $chatGroups->id }}" name="group_id" id="group_id">
                    <input type="hidden" value="{{ $chatGroups->created_by }}" name="create_by"
                        id="createGroup_id">
                    <div class="flex gap-[10px] w-full px-[20px] border-t-[2px] border-blue-200 py-[20px]">
                        <div
                            class="flex items-center p-[10px] gap-[10px] border-[2px] border-gray-500 rounded-[10px] w-full h-[70px] ">
                            <textarea name="message" id="message"
                                class="h-full w-full resize-none outline-none overflow-y-scroll scroll-container"></textarea>
                            <img id="image-preview" src="" alt=""
                                class="w-[60px] h-[60px] rounded-[10px] hidden">
                        </div>

                        <input type="file" id="image" name="image" accept="image/*" class="hidden"
                            onchange="previewImage(event)">
                        <label for="image" class="flex items-center justify-center text-[25px] cursor-pointer"><i
                                class='bx bx-image-add'></i></label>

                        <button class="bx bx-send w-[5%] text-[30px] text-blue-500" type="submit"
                            id="send"></button>
                    </div>
                </form>
            @else
                <div class="border-t-[2px] py-[20px] border-blue-200">
                    <p class="text-red-500 text-center">Please join the group to join the conversation.</p>
                </div>
            @endif

            <script>
                function previewImage(event) {
                        const input = event.target;
                        if (input.files && input.files[0]) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const imagePreview = document.getElementById("image-preview");
                                imagePreview.classList.add('flex');
                                imagePreview.classList.remove('hidden');
                                imagePreview.src = e.target.result;
                            };
                            reader.readAsDataURL(input.files[0]);
                        }
                    }

                const container_message = document.getElementById("container-message");
                container_message.scrollTop = container_message.scrollHeight;
            </script>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="/Script/ajax.js"></script>
    <script src="/Script/groupChat.js"></script>
    <script src="/Script/home.js"></script>
</body>

</html>
