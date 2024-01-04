<!DOCTYPE html>
<html lang="en">

<head>
    @include('head');
    <title>Register Pushan</title>
</head>

<body class="bg-gray-200">
    <section class="flex w-full h-[800px] items-center justify-center text-center">

        <div class="w-max grid justify-center items-center shadow-md h-max p-[50px] bg-white rounded-[10px]">
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <h1 class="text-[20px] font-semibold">Register Account</h1>
                <p class="text-gray-500 text-left">It's quick and easy.</p>

                <div class="grid gap-[20px] my-[30px]">
                    <div class="w-[420px] border-b-[2px] border-black">
                        <input type="text" name="email" placeholder="Email address or phone number" value="{{ old('email') }}"
                            class="outline-none py-[5px] w-full">
                    </div>

                    <div class="w-[420px] border-b-[2px] border-black flex items-center">
                        <input type="password" name="password" placeholder="Password" value="{{ old('password') }}"
                            class="outline-none py-[5px] w-full pr-[10px] password">
                        <i class='bx bx-low-vision'></i>
                    </div>

                    <div class="w-[420px] border-b-[2px] border-black">
                        <input type="text" name="username" placeholder="User Name" value="{{ old('username') }}"
                            class="outline-none py-[5px] w-full">
                    </div>

                    <div class="w-[420px] border-b-[2px] border-black">
                        <input type="date" name="birth" value="{{ old('birth') }}" class="outline-none py-[5px] w-full">
                    </div>

                    <div class="w-[420px] border-b-[2px] border-black flex items-center justify-between">
                        <input type="text" name="gender" class="gender outline-none" value="{{ old('gender') }}" readonly
                            placeholder="Gender">
                        <select name="gender-save" id="gender" class="outline-none">
                            <option value="1" disabled selected>Select Gender</option>
                            <option value="2">Male</option>
                            <option value="3">Female</option>
                            <option value="4">Other</option>
                        </select>
                    </div>

                    @if (session('success'))
                        <p class="text-blue-500">{{ session('success') }}</p>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger text-red-500">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <button type="submit"
                        class="font-semibold text-[20px] w-full h-[50px] text-center bg-mainColors rounded-[5px] text-white">Register</button>

                    <a href="" class="text-right">Forgotten password?</a>

                    <div class="w-full h-[1px] bg-gray-500"></div>

                    <a href="login" class="text-blue-400">If you have an account, Login.</a>
                </div>
            </form>
        </div>
    </section>

    <script src="/Auth/register.js"></script>
</body>

</html>
