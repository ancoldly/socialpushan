<!DOCTYPE html>
<html lang="en">

<head>
    @include('head');
    <title>Group Chat Pushan</title>
</head>

<body class="overflow-x-hidden">
    @include('users/header');
    @include('users/notification');

    <main class="flex w-full h-max py-[10px] gap-[20px] pt-[90px] px-[50px] relative justify-center">
        <div class="grid gap-[20px] items-center border-[2px] border-blue-500 p-[20px] rounded-[10px] w-[30%] h-[200px]">
            <form id="createChatGroup-form" action="{{ route('createGroupChat') }}" method="POST"
                class="grid items-center gap-[20px]" enctype="multipart/form-data">
                @csrf
                <div class="flex items-center justify-between">
                    <img id="previewAvatarGroup" src="image/user.png" alt=""
                        class="w-[50px] h-[50px] rounded-full">

                    <input type="file" id="imageGroup" name="imageGroup" accept="image/*" class="hidden">
                    <label for="imageGroup"
                        class="font-semibold w-max px-[20px] rounded-[5px] h-[40px] text-blue-500 bg-gray-200 flex items-center gap-[10px] justify-center cursor-pointer">Upload
                        Avatar</label>
                </div>

                <div class="flex items-center justify-between">
                    <p>Name group</p>

                    <div class="w-[200px] border-[2px] p-[10px] border-blue-200 rounded-[5px]">
                        <input type="text" name="nameGroup" class="outline-none w-full h-full"
                            placeholder="Enter name group" autocomplete="off">
                    </div>

                    <button class="bg-gray-200 font-semibold rounded-[5px] p-[10px]">Create</button>
                </div>
            </form>
        </div>

        <div class="w-[70%]">
            @if ($groupChats->count() > 0)
                <div class="grid gap-[20px] border-[2px] border-blue-500 rounded-[10px] p-[20px]">
                    <div>
                        <h1 class="uppercase font-semibold">list of chat groups</h1>
                    </div>

                    <table class="border-[2px] w-full border-blue-200 rounded-[10px]">
                        <tr class="border-[2px] text-center border-blue-200">
                            <td class="border-[2px] border-blue-200 font-semibold p-[10px]">Avatar Group</td>
                            <td class="border-[2px] border-blue-200 font-semibold p-[10px]">Name Group</td>
                            <td class="border-[2px] border-blue-200 font-semibold p-[10px]">Quantity members</td>
                            <td class="border-[2px] border-blue-200 font-semibold p-[10px]">Code group</td>
                            <td class="border-[2px] border-blue-200 font-semibold p-[10px]">Delete group</td>
                            <td class="border-[2px] border-blue-200 font-semibold p-[10px]">Edit group</td>
                        </tr>

                        @foreach ($groupChats as $groupChat)
                            <tr class="border-[2px] border-blue-200 text-center">
                                <td class="border-[2px] border-blue-200 p-[10px]"><img src="{{ $groupChat->avatar }}"
                                        class="w-[40px] h-[40px] rounded-full mx-auto" alt=""></td>
                                <td class="border-[2px] border-blue-200 p-[10px]">{{ $groupChat->group_name }}</td>
                                <td class="border-[2px] border-blue-200 p-[10px]">{{ $groupChat->members->count() }}</td>
                                <td class="border-[2px] border-blue-200 p-[10px]">{{ $groupChat->room_id }}</td>
                                <td class="border-[2px] border-blue-200 p-[10px]">
                                    <form class="deleteGroupChat-form" action="{{ route('deleteGroupChat') }}"
                                        method="POST" data-group-id="{{ $groupChat->id }}">
                                        @method('DELETE')
                                        @csrf
                                        <input type="hidden" name="group_id" value="{{ $groupChat->id }}">
                                        <button type="submit"
                                            class="w-full font-medium bg-red-200 p-[10px] rounded-[10px]">Delete</button>
                                    </form>
                                </td>
                                <td class="border-[2px] border-blue-200 p-[10px]">
                                    <div>
                                        <input type="hidden" name="group_id" value="{{ $groupChat->id }}">
                                        <button type="submit" data-group-id="{{ $groupChat->id }}"
                                            class="groupChat_id_edit w-full font-medium bg-red-200 p-[10px] rounded-[10px]">Edit</button>
                                    </div>
                                </td>
                        @endforeach
                    </table>
                </div>
            @else
                <p class="font-medium text-blue-500 text-center">There is no information about the group chat you
                    manager.</p>
            @endif
        </div>

        <div class='absolute bg-gray-100 rounded-[10px] border-[2px] border-gray-500 hidden justify-center items-center'
            id='form-editGroupChat'>
            <i class='cancel-editGroupChat bx bx-x-circle text-right text-[30px] text-blue-500 cursor-pointer'></i>
            <form action='{{ route('editGroupChat') }}' method='POST'
                class='editChatGroup-form grid items-center gap-[20px] p-[20px]' enctype='multipart/form-data' data-group-id="">
                @csrf
                <div class='flex items-center justify-between'>
                    <img id='previewAvatarGroupEdit' src='' alt=''
                        class='w-[100px] h-[100px] rounded-full'>
                    <input type='file' id='imageGroupEdit' value='' name='imageGroupEdit' accept='image/*'
                        class='hidden'>
                    <label for='imageGroupEdit'
                        class='font-semibold w-max px-[20px] rounded-[5px] h-[40px] text-blue-500 bg-gray-200 flex items-center gap-[10px] justify-center cursor-pointer'>Upload
                        Avatar</label>
                </div>
                <div class='flex items-center gap-[20px]'>
                    <p>Name group</p>
                    <input type="hidden" value="" name="group_id" id="group_id">
                    <div class='w-[200px] border-[2px] p-[10px] border-blue-200 rounded-[5px]'>
                        <input type='text' value='' id='group_name' name='group_name'
                            class='outline-none w-full h-full bg-gray-100' placeholder='Enter name group'
                            autocomplete='off'>
                    </div>
                    <button class='bg-gray-200 font-semibold rounded-[5px] p-[10px]'>Edit Group</button>
                </div>
            </form>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="/Script/ajax.js"></script>
    <script src="/Script/groupChat.js"></script>
    <script src="/Script/home.js"></script>
</body>

</html>
