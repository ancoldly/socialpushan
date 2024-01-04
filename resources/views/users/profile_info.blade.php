<div class="grid">
    <form id="avatar-form" method="POST" action="{{ route('edit-avatar') }}" enctype="multipart/form-data"
        class="pt-[auto] flex items-end justify-between w-full h-max bg-white p-[30px] rounded-t-[10px] border-b-[2px]">
        @csrf
        <input type="hidden" name="return_to" value="">
        <div class="flex items-center gap-[20px]">
            <div class="border-[2px] border-blue-500 p-[3px] rounded-full bg-gray-200">
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
            <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden"
                onchange="previewAvatar(event)">
            <label for="avatar"
                class="font-semibold w-max px-[20px] rounded-[5px] h-[40px] text-blue-500 bg-gray-200 flex items-center gap-[10px] justify-center">Upload
                Avatar</label>
            <button
                class="font-semibold w-max px-[20px] rounded-[5px] h-[40px] text-blue-500 bg-gray-200 flex items-center gap-[10px] justify-center"
                type="submit" name="submit">Save avatar</button>
            <button
                class="font-semibold w-max px-[20px] rounded-[5px] h-[40px] text-blue-500 bg-gray-200 flex items-center gap-[10px] justify-center"><a
                    href="changeInfo">Edit Information Profile</a></button>
        </div>
    </form>

    <div class="w-full h-max bg-white px-[30px] flex items-center justify-between py-[10px] rounded-b-[10px]">
        <div class="flex">
            <a href="profile">
                <button id="main-post" class="w-max h-[40px] p-[10px] font-semibold">Posts</button>
            </a>

            <a href="profile.friends">
                <button id="main-friend" class="w-max h-[40px] p-[10px] font-semibold">Friends</button>
            </a>

            <a href="profile.images">
                <button id="main-image" class="w-max h-[40px] p-[10px] font-semibold">Image</button>
            </a>
        </div>

        <div>
            <button class="w-[40px] h-[40px] bx bx-menu bg-gray-200 text-[22px] font-semibold rounded-[5px]"></button>
        </div>
    </div>
</div>
</div>
