<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')
    <title>Forgotten password</title>
</head>

<body>
    <section class="grid items-center justify-center my-auto h-screen">
        <form action="{{ route('reset_password') }}" method="POST">
            @csrf
            <div class="border-[2px] p-[20px] rounded-[10px]">
                <h1 class="font-medium text-[18px]">Password recovery</h1>

                <div class="grid gap-[20px]">
                    <span>Please enter your new password here, remember not to share it with anyone.</span>

                    <div class="border-[2px] border-blue-500 p-[10px] rounded-[10px]">
                        <input type="hidden" name="email_request" value="{{ session('verify_email') }}">
                        <input type="password" placeholder="Enter new password" name="password_request"
                            class="outline-none w-full">
                    </div>

                    <div class="text-right">
                        <button type="submit"
                            class="bg-blue-500 text-white p-[10px] rounded-[10px] px-[20px] font-medium">Reset password</button>
                    </div>
                </div>
            </div>
        </form>
    </section>
</body>

</html>
