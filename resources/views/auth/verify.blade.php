<!DOCTYPE html>
<html lang="en">

<head>
    @include('head');
    <title>Login Pushan</title>
</head>

<body class="bg-gray-200">
    <section class="flex flex-col gap-[50px] w-full h-[650px] items-center justify-center text-center">
        <div class="w-[30%] grid gap-[20px]">
            <div>
                <h1 class="text-mainColors text-[22px] font-medium">Verify your account</h1>
                <p>Please enter the verification code I sent to your email to complete
                    your account registration.</p>
            </div>

            <div class="grid items-center gap-[10px]">
                <p>Your code has 5 characters.</p>

                <form action="{{ route('verify') }}" method="post" class="grid gap-[20px]">
                    @csrf
                    <input type="hidden" name="verify_email" value="{{ session('verify_email') }}">
                    <div class="flex justify-center text-center">
                        <label class="py-[5px] mr-3 font-semibold">Enter OTP</label>
                        <input name="verification_code" id="verification_code" placeholder="Enter verification code"
                            class="outline-none px-[10px] py-[5px] w-[190px] border-[2px] border-blue-200 rounded-full">
                    </div>

                    <button type="submit"
                        class="text-gray-50 bg-emerald-600 p-[10px] rounded-[5px] w-max mx-auto">Confirm</button>
                </form>

                <form action="{{ route('create-new-code') }}" method="post">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('verify_email') }}">
                    <button type="submit" class="bg-gray-300 p-[10px] rounded-[5px]">Resend</button>
                </form>
            </div>

            @if ($errors->has('verification_code'))
                <p>
                    {{ $errors->first('verification_code') }}
                </p>
            @endif

            <p>{{ session('success') }}</p>
        </div>
    </section>
</body>

</html>
