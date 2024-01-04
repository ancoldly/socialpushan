<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')
    <title>Login Pushan</title>
</head>

<body class="bg-gray-200">
    <section class="flex flex-col gap-[50px] w-full h-[800px] items-center justify-center text-center">
        <div class="w-full">
            <h1 class="font-bold text-[32px] text-mainColors">Fushan</h1>
            <p class="text-[20px] font-semibold">Pushan helps you connect and share with people in your life.</p>
        </div>

        <div class="w-max grid justify-center items-center shadow-md h-max p-[50px] bg-white rounded-[10px]">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h1 class="text-[20px] font-semibold">Login Account</h1>

                <div class="grid gap-[20px] my-[30px]">
                    <div class="w-[420px] border-b-[2px] border-black">
                        <input type="text" placeholder="Email address or phone number" name="email"
                            value="{{ old('email') }}" class="outline-none py-[5px] w-full">
                    </div>

                    <div class="w-[420px] border-b-[2px] border-black">
                        <input type="password" placeholder="Password" name="password" value="{{ old('password') }}"
                            class="outline-none py-[5px] w-full">
                    </div>

                    <div class="flex items-center gap-[10px]">
                        <input id="remember" type="checkbox" name="remember" value="" class="w-4 h-4 bg-gray-100 rounded-full">
                        <label for="remember" class="text-blue-500">Remember me?</label>
                    </div>

                    @if (session('error'))
                        <p class="text-red-500">{{ session('error') }}</p>
                    @endif

                    <button type="submit" class="font-semibold text-[20px] w-full h-[50px] text-center bg-mainColors rounded-[5px] text-white">Login</button>

                    <a href="forgotten_password" class="text-right">Forgotten password?</a>

                    <div class="w-full h-[1px] bg-gray-500"></div>

                    <a href="register" class="text-blue-400">If you don't have an account, Register.</a>
                </div>
            </form>
        </div>
    </section>
</body>

</html>
