<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')
    <title>Profile Pushan</title>
</head>

<body>
    @include('users.header');
    <main class="flex items-start py-[10px] pt-[90px] bg-gray-100 px-[50px] gap-[20px]">
        <div id="modal-story" class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all grid justify-center items-center w-[300px] h-[450px] px-3">
                        <img id="previewStory" class="w-[100] rounded-lg" src="">
                        <button id="delete-preview-story"
                            class="absolute top-2 right-2 w-[35px] h-[35px] rounded-full bx bx-x bg-gray-300 text-[30px] text-white"></button>
                        <button id="create-story"
                            class="absolute bottom-2 right-2 w-[100px] h-[35px] bg-mainColors rounded-[20px] text-white font-semibold">Confirm</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-3/12 p-[20px] overflow-y-auto bg-white rounded-[10px] grid gap-[20px]">
            <form action="{{ route('create-story') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex items-center gap-[10px]">
                    <input type="file" id="story" name="story" accept="image/*" class="hidden"
                        onchange="previewStory(event)">
                    <label for="story"
                        class="w-[40px] h-[40px] bg-mainColors rounded-[20px] cursor-pointer text-white bx bx-plus text-[24px] text-center leading-[40px]"></label>
                    <button type="submit" id="submitStory" class="hidden">Submit</button>

                    <div>
                        <span class="font-medium">Create a story</span>

                        <p class="text-gray-500 text-[14px]">Share your impressive images.</p>
                    </div>
                </div>
            </form>

            <div class="grid gap-[10px]">
                <h1 class="font-medium">All story</h1>

                <div>
                    @foreach ($stories as $key => $story)
                        <div class="storier flex cursor-pointer hover:bg-blue-100 p-[10px] rounded-[10px]"
                            data-slide-index="{{ $key }}">
                            <img class="w-[50px] h-[50px] rounded-full"
                                src="{{ $story->user->avatar ? $story->user->avatar : 'image/user.png' }}">
                            <div class="pl-2">
                                <h4 class="font-medium">{{ $story->user->name }}</h4>
                                <p class="text-[14px] text-gray-500">
                                    {{ \Carbon\Carbon::parse($story->created_at)->diffForHumans(null, true) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="w-9/12 h-max p-[20px] bg-slate-800 rounded-[10px] flex justify-center items-center relative">
            <div class="text-end p-1 absolute top-1 right-1">
                <a href="{{ route('show-home') }}"><button
                        class="w-[50px] h-[50px] rounded-full bx bx-x bg-blue-500 text-[30px] text-white"></button></a>
            </div>

            <div>
                <div class="swiper story w-[560px] pl-[80px]">
                    <div class="swiper-wrapper">
                        @foreach ($stories as $story)
                            <div class="swiper-slide h-[660px] w-[400px] relative">
                                <div class="flex absolute top-4 left-4">
                                    <img class="w-[50px] h-[50px] rounded-full" src="{{ $story->user->avatar }}">
                                    <div class="pl-2">
                                        <h4 class="text-white font-medium">{{ $story->user->name }}</h4>
                                        <p class="text-[14px] text-gray-500">
                                            {{ \Carbon\Carbon::parse($story->created_at)->diffForHumans(null, true) }}
                                        </p>
                                    </div>
                                </div>
                                @if (Auth::check() && Auth::id() == $story->user_id)
                                    <div class="absolute top-4 right-24">
                                        <button data-story-id="{{ $story->id }}"
                                            class="w-[40px] h-[40px] text-[30px] rounded-full hover:bg-gray-500 transition-all show-cogStory"><i
                                                class='bx bx-dots-horizontal-rounded text-white'></i></button>
                                    </div>
                                    <div id="delete-container-{{ $story->id }}"
                                        class="absolute top-14 right-24 z-10 mt-2 w-30 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none hidden">
                                        <div class="py-1">
                                            <form action="{{ route('delete-story', $story->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-gray-700 block w-full px-4 py-1 text-left text-sm"
                                                    id="menu-item-3">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                                <div class="h-[660px] w-[400px] rounded-lg grid bg-black justify-center items-center">
                                    <img class="w-[100]" src="{{ $story->image_url }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="/Script/stories.js"></script>
    <script src="/Script/story.js"></script>
    <script src="/Script/ajax.js"></script>
</body>

</html>
