<!DOCTYPE html>
<html lang="en">

<head>
    @include('head');
    <title>Change Infomation Pushan</title>
</head>

<body class="overflow-x-hidden">
    @include('users/header');
    @include('users/notification');
    <main class="grid w-full justify-center items-center gap-[20px] py-[10px] mt-[100px] pb-[50px]">
        <div class="grid gap-[10px] py-[20px] bg-blue-50 rounded-[10px] px-[20px] w-full">
            <div class="border-[2px] w-full h-max px-[20px] rounded-[10px] grid gap-[10px] pt-[10px]">
                <span class="font-semibold">Infomation Profile</span>

                <form id="changeInfo-form" action="{{ route('changeInfo') }}" class="border-t-[2px] py-[10px]"
                    method="POST">
                    @csrf
                    <div class="flex items-center gap-[20px] justify-between border-b-[2px] pb-[10px]">
                        <span class="font-semibold text-gray-500 w-[20%]">Name User</span>
                        <div
                            class="w-[60%] h-[40px] border-[2px] rounded-[5px] border-blue-200 flex items-center px-[10px]">
                            <input type="text" name="username" id=""
                                class="outline-none ip-userName bg-blue-50" readonly value="{{ $user->name }}">
                        </div>
                        <button class="w-[25%] h-[40px] bg-gray-200 font-semibold rounded-[5px] edit-username"
                            type="button">Edit</button>
                    </div>

                    <div class="flex items-center gap-[20px] justify-between border-b-[2px] py-[10px]">
                        <span class="font-semibold text-gray-500 w-[20%]">Tele Phone</span>
                        <div
                            class="w-[60%] h-[40px] border-[2px] rounded-[5px] border-blue-200 flex items-center px-[10px]">
                            <input type="text" name="telephone" id=""
                                class="outline-none bg-blue-50 ip-telePhone" readonly value="{{ $user->telephone }}">
                        </div>
                        <button class="w-[25%] h-[40px] bg-gray-200 font-semibold rounded-[5px] edit-telePhone"
                            type="button">Edit</button>
                    </div>

                    <div class="flex items-center gap-[20px] justify-between border-b-[2px] py-[10px]">
                        <span class="font-semibold text-gray-500 w-[20%]">Birth date</span>
                        <div
                            class="w-[60%] h-[40px] border-[2px] rounded-[5px] border-blue-200 flex items-center px-[10px]">
                            <input type="date" name="birthdate" id=""
                                class="outline-none bg-blue-50 ip-birthDate" readonly value="{{ $user->birth }}">
                        </div>
                        <button class="w-[25%] h-[40px] bg-gray-200 font-semibold rounded-[5px] edit-birthDate"
                            type="button">Edit</button>
                    </div>

                    <div class="flex items-center gap-[20px] justify-between border-b-[2px] py-[10px]">
                        <span class="font-semibold text-gray-500 w-[20%]">Gender</span>
                        <div
                            class="w-[60%] h-[40px] border-[2px] rounded-[5px] border-blue-200 flex items-center px-[10px]">
                            <input type="text" name="gender" id="selected-gender"
                                class="gender outline-none bg-blue-50 ip-Gender" value="{{ $user->gender }}" readonly>
                            <select name="gender-save" id="gender" class="outline-none bg-blue-50" disabled>
                                <option value="1" disabled selected>Gender</option>
                                <option value="2">Male</option>
                                <option value="3">Female</option>
                                <option value="4">Other</option>
                            </select>
                        </div>
                        <button class="w-[25%] h-[40px] bg-gray-200 font-semibold rounded-[5px] edit-Gender"
                            type="button">Edit</button>
                    </div>

                    <div class="flex items-center gap-[20px] justify-between border-b-[2px] py-[10px]">
                        <span class="font-semibold text-gray-500 w-[20%]">Address</span>
                        <div
                            class="w-[60%] h-[40px] border-[2px] rounded-[5px] border-blue-200 flex items-center px-[10px]">
                            <input type="text" name="address" id=""
                                class="outline-none bg-blue-50 ip-address" readonly value="{{ $user->address }}">
                        </div>
                        <button class="w-[25%] h-[40px] bg-gray-200 font-semibold rounded-[5px] edit-address"
                            type="button">Edit</button>
                    </div>

                    <p id="err" class="text-blue-500 py-[10px]"></p>

                    <div class="flex items-center gap-[20px] py-[10px]">
                        <button class="save-infomation w-[40%] h-[50px] bg-blue-300 rounded-[5px] font-semibold" type="submit">Save
                            Infomation</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="grid gap-[10px] py-[20px] bg-blue-50 rounded-[10px] px-[20px] w-full">
            <form id="changePassword-form" action="changePassword" method="POST">
                @csrf
                <div class="grid items-center gap-[10px] border-[2px] rounded-[10px] p-[20px]">
                    <div class="flex items-center gap-[10px] border-b-[2px] pb-[10px]">
                        <i class='bx bx-key text-[32px]'></i>
                        <div>
                            <span class="font-semibold">Change password</span>
                            <p class="text-gray-500">You should use a strong password that you haven't used elsewhere.
                            </p>
                        </div>
                    </div>

                    <div class="grid w-[70%] gap-[20px]">
                        <div class="flex items-center">
                            <span class="w-[45%] font-semibold text-gray-500">Current password</span>

                            <div class="border-[2px] border-blue-200 rounded-[5px] p-[5px] w-[55%]">
                                <input id="currentPassword" type="password" name="currentPassword" class="outline-none bg-blue-50 w-full"
                                    placeholder="Enter current password" value="">
                            </div>
                        </div>

                        <div class="flex items-center">
                            <span class="w-[45%] font-semibold text-gray-500">New password</span>

                            <div class="border-[2px] border-blue-200 rounded-[5px] p-[5px] w-[55%]">
                                <input id="newPassword" type="password" name="newPassword" class="outline-none bg-blue-50 w-full"
                                    placeholder="Enter new password" value="">
                            </div>
                        </div>

                        <div class="flex items-center">
                            <span class="w-[45%] font-semibold text-gray-500">Confirm password</span>

                            <div class="border-[2px] border-blue-200 rounded-[5px] p-[5px] w-[55%]">
                                <input id="confirmPassword" type="password" name="confirmPassword" class="outline-none bg-blue-50 w-full"
                                    placeholder="Enter confirm new password" value="">
                            </div>
                        </div>

                        <a href="" class="text-blue-500">You forgot your password?</a>
                    </div>

                    <p id="err-password" class="text-red-500"></p>

                    <div class="border-t-[2px] pt-[10px]">
                        <button name="submit-editPassword"
                            class="submit-editPassword w-[40%] h-[50px] rounded-[5px] bg-blue-300 font-semibold">Save changes
                            password</button>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="/Script/changeInfo.js"></script>
    <script src="/Script/ajax.js"></script>
    <script src="/Script/home.js"></script>
</body>

</html>
