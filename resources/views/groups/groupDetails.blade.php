<!DOCTYPE html>
<html lang="en">

<head>
    @include('head');
    <title>Group Pushan</title>
</head>

<body class="overflow-x-hidden">
    @include('users/header');
    @include('users/notification');
    <main class="w-full h-max flex pt-[90px] items-cente py-[10px] px-[50px] bg-gray-200 gap-[10px]">
        <div class="grid bg-white w-[400px] p-[20px] rounded-[10px] gap-[20px] fixed">
            <div class="flex items-center gap-[10px]">
                <img src="{{ $group->avatar }}" alt="" class="h-[50px] w-[50px] rounded-[5px]">

                <div>
                    <h1 class="font-semibold text-[20px]">{{ $group->name }}</h1>

                    <span class="text-gray-500 font-medium">{{ $group->users->count() }} members</span>
                </div>
            </div>

            <div class="flex items-center justify-between">
                @if (Auth::user() && $group->users->contains(Auth::user()))
                    <button class="p-[10px] bg-blue-500 text-white font-semibold rounded-[5px] w-[80%]">+
                        Invite</button>
                @else
                    <form action="{{ route('JoinGroup') }}" method="POST" class="w-[80%] joinGroup-form">
                        @csrf
                        <input type="hidden" name="codeGroup" value="{{ $group->code_group }}">
                        <button class="p-[10px] bg-gray-200 font-semibold rounded-[5px] w-full">Join group</button>
                    </form>
                @endif

                <button
                    class="p-[10px] bx bx-dots-horizontal-rounded bg-gray-200 text-[22px] font-semibold rounded-[5px] w-[15%]"></button>
            </div>

            <a href="">
                <div>
                    <button
                        class="p-[10px] bg-gray-200 font-semibold rounded-[5px] w-full text-left flex items-center gap-[5px]"><i
                            class='bx bxs-home text-[22px]'></i>Community home</button>
                </div>
            </a>

            <div class="grid gap-[10px] border-t-[2px] pt-[10px]">
                <span class="font-semibold">List members</span>

                <div class="flex flex-col overflow-y-scroll h-[300px] scroll-container">
                    @foreach ($allUsers as $allUser)
                        <div class="flex gap-[20px] items-center w-full relative py-[5px]">
                            <img src="{{ $allUser->user->avatar ? $allUser->user->avatar : '/image/user.png' }}"
                                alt="" class="w-[40px] h-[40px] rounded-full avatar-user">

                            <div class="flex justify-between items-center w-full">
                                <form action="{{ route('show-profileDetails') }}" method="GET">
                                    <input type="hidden" name="userId" value="{{ $allUser->user->id }}">
                                    <button type="submit" class="font-semibold flex items-center gap-[5px]">
                                        {{ $allUser->user->name }}
                                    </button>
                                </form>

                                @if ($allUser->user->id == $group->created_by)
                                    <i class='bx bxs-group text-[22px] text-blue-500 mr-[10px]'></i>
                                @else
                                    @if (Auth::id() == $group->created_by)
                                        <form class="deleteUserGroup-form" action="{{ route('deleteUserGroup') }}"
                                            data-member-id="{{ $allUser->id }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <input type="hidden" name="member_id" value="{{ $allUser->id }}">
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

        <div class="bg-white w-[70%] p-[20px] rounded-[10px] grid gap-[20px] ml-[420px]">
            <div class="grid">
                <div class="flex items-center gap-[20px] border-b-[2px] pb-[20px]">
                    <div>
                        <img src="{{ $group->avatar }}" class="h-[160px] w-[160px] rounded-full" alt="">
                    </div>

                    <div>
                        <h1 class="text-[28px] font-bold">{{ $group->name }}</h1>

                        <p class="flex items-center gap-[5px]"><i class='bx bx-world'></i> Public group <span
                                class="text-gray-500 font-medium">{{ $group->users->count() }} Members</span></p>
                    </div>
                </div>

                <div class="flex items-center justify-between border-b-[2px] mb-[20px]">
                    <div class="flex items-center">
                        <button class="p-[10px] hover:bg-gray-200 font-medium">Post</button>
                        <button class="p-[10px] hover:bg-gray-200 font-medium">About</button>
                        <button class="p-[10px] hover:bg-gray-200 font-medium">Members</button>
                    </div>

                    @if ($group->created_by != Auth::id() && $group->users->contains(Auth::user()))
                        <form class="deleteUserGroup-form" action="{{ route('deleteUserGroup') }}"
                            data-member-id="{{ $group->members->where('user_id', Auth::id())->first()->id }}"
                            method="POST">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" name="member_id"
                                value="{{ $group->members->where('user_id', Auth::id())->first()->id }}">
                            <button type="submit"
                                class="w-[40px] h-[40px] text-[30px] rounded-full text-red-500 bx bx-log-out-circle flex items-center justify-center"></button>
                        </form>
                    @elseif ($group->created_by == Auth::id())
                        <button class=""></button>
                        <div>
                            <input type="hidden" name="group_id" value="{{ $group->id }}">
                            <button type="submit" data-group-id="{{ $group->id }}"
                                class="group_id_edit w-[40px] h-[40px] text-[30px] rounded-full text-red-500 bx bx-edit flex items-center justify-center"></button>
                        </div>
                    @endif
                </div>

                <div class='absolute bg-gray-100 rounded-[10px] border-[2px] border-gray-500 hidden justify-center items-center'
                    id='form-editGroup'>
                    <i class='cancel-editGroup bx bx-x-circle text-right text-[30px] text-blue-500 cursor-pointer'></i>
                    <form action='{{ route('editGroup') }}' method='POST'
                        class='editGroup-form grid items-center gap-[20px] p-[20px]' enctype='multipart/form-data'
                        data-group-id="">
                        @csrf
                        <div class='flex items-center justify-between'>
                            <img id='previewAvatarGroupEdit' src='' alt=''
                                class='w-[100px] h-[100px] rounded-full'>
                            <input type='file' id='imageGroupEdit' value='' name='imageGroupEdit'
                                accept='image/*' class='hidden'>
                            <label for='imageGroupEdit'
                                class='font-semibold w-max px-[20px] rounded-[5px] h-[40px] text-blue-500 bg-gray-200 flex items-center gap-[10px] justify-center cursor-pointer'>Upload
                                Avatar</label>
                        </div>
                        <div class='flex items-center gap-[20px]'>
                            <p>Name group</p>
                            <input type="hidden" value="" id="group_id_edit" name="group_id">
                            <div class='w-[200px] border-[2px] p-[10px] border-blue-200 rounded-[5px]'>
                                <input type='text' value='' id='group_name' name='group_name'
                                    class='outline-none w-full h-full bg-gray-100' placeholder='Enter name group'
                                    autocomplete='off'>
                            </div>
                            <button class='bg-gray-200 font-semibold rounded-[5px] p-[10px]'>Edit Group</button>
                        </div>
                    </form>
                </div>

                <div class="flex items-start bg-gray-100 p-[20px] rounded-[10px] w-full gap-[20px]">
                    <div class="grid gap-[20px] w-[70%]">
                        @if (Auth::user() && $group->users->contains(Auth::user()))
                            <form id="createPost-form" action="{{ route('createPostGroup') }}"
                                class="grid justify-start items-center bg-white rounded-[10px] p-[20px] gap-[20px]"
                                method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="group_id" value="{{ $group->id }}">
                                <div class="flex items-center gap-[10px] cursor-pointer">
                                    <button
                                        class="w-[40px] h-[40px] bg-gray-200 rounded-full text-blue-500 text-[24px] bx bx-edit-alt"></button>
                                    <span class="text-gray-500 font-semibold">Create Post</span>
                                </div>

                                <div
                                    class="w-full h-[120px] border-[2px] rounded-[10px] flex items-start justify-between p-[10px] gap-[10px]">
                                    <img src="{{ $user->avatar ? $user->avatar : $avatar_temp }}" alt=""
                                        class="w-[40px] h-[40px] rounded-full avatar-user">
                                    <textarea name="content-post" id="content-post" cols="100" rows="10"
                                        class="w-full h-full outline-none pr-[10px] resize-none" placeholder="What's on your mind?" class="create-post"></textarea>
                                </div>

                                <div class="relative">
                                    <img id="imagePost-preview" src="" alt=""
                                        class="rounded-[10px]">
                                    <button
                                        class="delete-imagePost-preview hidden w-[40px] h-[40px] bg-gray-200 rounded-full text-blue-500 text-[24px] bx bx-x absolute top-[10px] right-[10px]"
                                        type="button"></button>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-[10px] cursor-pointer">
                                        <input type="file" id="image-post" name="image-post" accept="image/*"
                                            class="hidden" onchange="previewImagePost(event)">
                                        <label for="image-post"
                                            class="font-semibold w-max px-[20px] rounded-[5px] h-[40px] text-blue-500 bg-gray-200 flex items-center gap-[10px] justify-center cursor-pointer"><i
                                                class='bx bx-image-add text-[24px]'></i>Photo/Video</label>
                                    </div>

                                    <div class="flex items-center gap-[10px] cursor-pointer">
                                        <button id=""
                                            class="createPost font-semibold w-max px-[20px] rounded-[5px] h-[40px] text-mainColors bg-gray-200 flex items-center gap-[10px] justify-center cursor-no-drop"
                                            type="submit" name="submit-create-post" disabled><i
                                                class='bx bx-edit text-[24px]'></i>Create
                                            Post</button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="bg-white rounded-[10px] p-[20px]">
                                <p class="text-red-500">Please join the group to be able to create post.</p>
                            </div>
                        @endif

                        @foreach ($posts as $post)
                            @if ($post->group_id != null && $post->group_id == $group->id)
                                @include('groups.post_group')
                            @endif
                        @endforeach
                    </div>

                    <div class="bg-white p-[20px] rounded-[10px] w-[35%] grid gap-[20px]">
                        <span class="font-medium text-blue-500">About</span>

                        <div class="grid gap-[10px]">
                            <p class="flex items-center gap-[5px] font-semibold">
                                Name group: <span class="font-normal">{{ $group->name }}</span>
                            </p>

                            <p class="flex items-center gap-[5px] font-semibold">
                                Code group: <span class="font-normal text-blue-500">{{ $group->code_group }}</span>
                            </p>

                            <p class="flex items-center gap-[5px] font-semibold">
                                Privacy: <span class="font-normal flex items-center gap-[5px]"><i
                                        class='bx bx-world'></i>
                                    Public group</span>
                            </p>

                            <p class="flex items-center gap-[5px] font-semibold">
                                Members: <span class="font-normal">{{ $group->users->count() }}</span>
                            </p>

                            <p class="flex items-center gap-[5px] font-semibold">
                                History: <span class="font-normal">{{ $group->created_at }}</span>
                            </p>

                            <div class="flex items-center gap-[5px] font-semibold">
                                Admin: <form action="{{ route('show-profileDetails') }}" method="GET">
                                    <input type="hidden" name="userId" value="{{ $group->createdBy->id }}">
                                    <button type="submit" class="font-normal flex items-center gap-[5px]">
                                        {{ $group->createdBy->name }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="/Script/home.js"></script>
    <script src="/Script/group_edit.js"></script>
    <script src="/Script/ajax.js"></script>
</body>

</html>
