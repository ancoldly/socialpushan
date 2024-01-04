<!DOCTYPE html>
<html lang="en">

<head>
    @include('head');
    <title>Profile Pushan</title>
</head>

<body class="overflow-x-hidden">
    @include('users/header');
    @include('users/notification');
    <main class="w-full h-max flex pt-[90px] items-cente py-[10px] px-[50px] bg-gray-200 gap-[10px]">
        <div class="grid bg-white w-[450px] p-[20px] rounded-[10px] gap-[20px] fixed">
            <div>
                <div class="flex items-center gap-[5px]">
                    <a href="group" class="font-semibold text-blue-500">Groups</a>
                    <span> > </span>
                    <p class="text-gray-500">Create group</p>
                </div>

                <h1 class="text-[22px] font-semibold">Create group</h1>
            </div>

            <div class="flex items-center gap-[10px] border-b-[2px] pb-[10px]">
                <img src="/avatar/avt.jpg" class="w-[40px] h-[40px] rounded-full" alt="">

                <div>
                    <span class="font-semibold">Nguyen Hong An</span>
                    <p class="text-gray-500">Admin</p>
                </div>
            </div>

            <form id="createGroup-form" action="{{ route('createGroup') }}" method="POST" class="grid gap-[20px]"
                enctype="multipart/form-data">
                @csrf

                <div class="flex items-center justify-between">
                    <img id="AvatarGroup" src="/image/groups-default.png" alt="" class="w-[50px] h-[50px] rounded-full">

                    <input type="file" id="imageGroup" name="imageGroup" accept="image/*" class="hidden">
                    <label for="imageGroup"
                        class="font-semibold w-max px-[20px] rounded-[5px] h-[40px] text-blue-500 bg-gray-200 flex items-center gap-[10px] justify-center cursor-pointer">Upload
                        Avatar</label>
                </div>

                <div class="flex items-center justify-between">
                    <span class="font-semibold">Group name</span>

                    <div class="p-[10px] border-[2px] border-blue-200 rounded-[10px] w-[270px]">
                        <input type="text" name="nameGroup" class="outline-none" placeholder="Enter group name">
                    </div>
                </div>

                <button type="submit" id="createButton" class="bg-gray-200 font-semibold rounded-[5px] p-[10px] cursor-no-drop" disabled>Create</button>
            </form>
        </div>

        <div class="bg-white w-[70%] p-[20px] rounded-[10px] grid gap-[20px] ml-[470px] pointer-events-none cursor-not-allowed opacity-50">
            <h1 class="font-semibold">Group preview</h1>

            <div class="grid gap-[20px]">
                <div class="flex items-center gap-[20px] border-b-[2px] pb-[20px]">
                    <div>
                        <img src="/image/groups-default.png" id="DemoAvatarGroup" class="h-[160px] w-[160px] rounded-full" alt="">
                    </div>

                    <div>
                        <h1 id="demoNameGroup" class="text-[28px] font-bold">Group name</h1>

                        <p class="flex items-center gap-[5px]"><i class='bx bx-world'></i> Public group <span
                                class="text-gray-500 font-medium">1 member</span></p>
                    </div>
                </div>

                <div class="flex items-center border-b-[2px] pb-[20px]">
                    <button class="p-[10px] hover:bg-gray-200 rounded-[5px] font-medium">Post</button>
                    <button class="p-[10px] hover:bg-gray-200 rounded-[5px] font-medium">About</button>
                    <button class="p-[10px] hover:bg-gray-200 rounded-[5px] font-medium">Members</button>
                </div>

                <div class="flex items-start bg-gray-100 p-[20px] rounded-[10px] w-full gap-[20px]">
                    <form id="createPost-form" action="{{ route('create-post') }}"
                        class="grid w-[70%] justify-start items-center bg-white rounded-[10px] p-[20px] gap-[20px]"
                        method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
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
                            <img id="imagePost-preview" src="" alt="" class="rounded-[10px]">
                            <button
                                class="delete-imagePost-preview hidden w-[40px] h-[40px] bg-gray-200 rounded-full text-blue-500 text-[24px] bx bx-x absolute top-[10px] right-[10px]"
                                type="button"></button>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-[10px] cursor-pointer">
                                <input type="file" id="image-post" name="image-post" accept="image/*" class="hidden"
                                    onchange="previewImagePost(event)">
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

                    <div class="bg-white p-[20px] rounded-[10px] w-[30%] grid gap-[20px]">
                        <span class="font-medium">About</span>

                        <div>
                            <p class="flex items-center gap-[5px]"><i class='bx bx-world'></i> Public group <span
                                class="text-gray-500 font-medium">1 member</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="/Script/group.js"></script>
    <script src="/Script/home.js"></script>
    <script src="/Script/ajax.js"></script>

</body>

</html>
