<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')
    <title>Forgotten password</title>
</head>

<body>
    <section class="grid items-center justify-center my-auto py-[200px] gap-[20px]">
        @if ($errors->any())
            <p class="text-red-500">{{ $errors->first() }}</p>
        @endif

        <form action="{{ route('showVerifyPasswordForm') }}" method="GET">
            <div class="border-[2px] p-[20px] rounded-[10px]">
                <h1 class="font-medium text-[18px]">Find your account</h1>

                <div class="grid gap-[20px]">
                    <span>Please enter your email to search for your account.</span>

                    <div class="border-[2px] border-blue-500 p-[10px] rounded-[10px]">
                        <input type="text" placeholder="Enter your email" name="email_request"
                            class="outline-none w-full">
                    </div>

                    <div class="text-right">
                        <a href="login" class="bg-gray-200 p-[10px] rounded-[10px] px-[20px] font-medium">Cancel</a>
                        <button type="submit"
                            class="bg-blue-500 text-white p-[10px] rounded-[10px] px-[20px] font-medium">Search</button>
                    </div>
                </div>
            </div>
        </form>
    </section>
</body>

</html>
