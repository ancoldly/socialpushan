<!DOCTYPE html>
<html lang="en">

<head>
    @include('head');
    <title>Profile Pushan</title>
</head>

<body class="overflow-x-hidden">
    @include('users/header');
    @include('users/notification');

    <main class="flex justify-center w-full h-max py-[10px] gap-[10px] pt-[90px] px-[50px]">
        @if ($friendship->user_id == Auth::id() || $friendship->friend_id == Auth::id())
            <div class="grid w-[60%] border-[2px] border-blue-200 rounded-[10px] items-start">
                <div class="border-b-[2px] border-blue-200">
                    <div class="flex justify-between items-center p-[20px]">
                        <div class="flex gap-[20px] items-center w-full relative">
                            <img src="{{ $friend->avatar ? $friend->avatar : $avatar_temp }}" alt=""
                                class="w-[45px] h-[45px] rounded-full avatar-user">

                            <div class="flex justify-between items-center w-full">
                                <form action="{{ route('show-profileDetails') }}" method="GET">
                                    <input type="hidden" name="userId" value="{{ $friend->id }}">
                                    <button type="submit" class="font-semibold flex items-center gap-[5px]">
                                        {{ $friend->name }}
                                        <i class="bx bxs-check-circle text-blue-500"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div>
                            <button
                                class="w-[40px] h-[40px] text-[30px] rounded-full bg-gray-200 transition-all bx bxs-error-circle bx-tada"></button>
                        </div>
                    </div>
                </div>

                <div class="w-full p-[20px] flex flex-col justify-between overflow-y-scroll h-[500px] scroll-container"
                    id="container-message">
                    <div class="grid gap-[10px]">
                        <div id="chat-messages">
                            @foreach ($messages as $message)
                                <div class="mb-4" data-sender-id="{{ $message->sender_id }}">
                                    <div class="flex justify-star items-center gap-[10px] message-result">
                                        @if ($message->sender_id == Auth::id())
                                            <img src="{{ Auth::user()->avatar ? Auth::user()->avatar : $avatar_temp }}"
                                                class="w-[35px] h-[35px] rounded-full" alt="">
                                            <div class="p-[10px] rounded-[10px] bg-blue-100 max-w-[500px] h-max"
                                                message-id="{{ $message->id }}">
                                                <span class="font-medium">{{ Auth::user()->name }}</span>
                                                <p>{{ $message->content }}</p>
                                                @if ($message->image !== null)
                                                    <img src="{{ $message->image }}" alt=""
                                                        class="w-[250px] my-[10px] rounded-[10px]">
                                                @endif
                                                <p class="text-[14px] font-medium text-gray-500">
                                                    {{ $message->created_at }}
                                                </p>
                                            </div>
                                        @else
                                            <img src="{{ $friend->avatar ? $friend->avatar : $avatar_temp }}"
                                                class="w-[35px] h-[35px] rounded-full" alt="">
                                            <div class="p-[10px] rounded-[10px] bg-blue-100 max-w-[500px] h-max"
                                                message-id="{{ $message->id }}">
                                                <span class="font-medium">{{ $friend->name }}</span>
                                                <div class="grid gap-[10px]">
                                                    <p>{{ $message->content }}</p>
                                                    @if ($message->image !== null)
                                                        <img src="{{ $message->image }}" alt=""
                                                            class="w-[250px] my-[10px] rounded-[10px]">
                                                    @endif
                                                </div>
                                                <p class="text-[14px] font-medium text-gray-500">
                                                    {{ $message->created_at }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <form action="chatMessage" method="POST" class="chatMessage-form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $roomId }}" name="room_id" id="room_id">
                    <input type="hidden" value="{{ $friend->id }}" name="receiver_id" id="receiver_id ">
                    <div class="flex gap-[10px] w-full px-[20px] border-t-[2px] border-blue-200 py-[20px]">
                        <div
                            class="flex items-center p-[10px] gap-[10px] border-[2px] border-gray-500 rounded-[10px] w-full h-[70px] ">
                            <textarea name="message" id="message"
                                class="h-full w-full resize-none outline-none overflow-y-scroll scroll-container"></textarea>
                            <img id="image-preview" src="" alt=""
                                class="w-[60px] h-[60px] rounded-[10px] hidden">
                        </div>

                        <input type="file" id="image" name="image" accept="image/*" class="hidden"1
                            onchange="previewImage(event)">
                        <label for="image" class="flex items-center justify-center text-[25px] cursor-pointer"><i
                                class='bx bx-image-add'></i></label>

                        <button class="bx bx-send w-[5%] text-[30px] text-blue-500" type="submit"
                            id="send"></button>
                    </div>
                </form>

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
                    container_message.scrollTop = Math.ceil(container_message.scrollHeight);
                </script>
            </div>
        @else
            <p class="text-red-500">You cannot access messages here</p>
        @endif
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="/Script/home.js"></script>
    <script src="/Script/ajax.js"></script>
</body>

</html>
