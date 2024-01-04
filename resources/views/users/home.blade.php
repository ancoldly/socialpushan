<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')
    <title>Profile Pushan</title>
</head>

<body class="overflow-x-hidden">
    @include('users/header');
    @include('users/notification');
    <main class="flex justify-between w-full h-max bg-gray-100 py-[10px] gap-[10px] pt-[90px]">
        <div class="w-[300px] grid justify-center gap-[10px] fixed left-0 ml-[50px]">
            <div class="grid gap-[10px] bg-white p-[20px] rounded-[10px] w-[300px]">
                <span class="text-gray-500 font-semibold">New Feeds</span>

                <a href="profile" class="flex items-center gap-[10px]">
                    <div class="w-[50px] h-[50px] bg-gray-200 rounded-full text-gray-500 text-[26px]"><img
                            src="{{ $user->avatar ? $user->avatar : $avatar_temp }}" alt=""
                            class="rounded-full w-[50px] h-[50px]"></div>
                    <p class="font-semibold text-gray-500">{{ $user->name }}</p>
                </a>

                <a href="home">
                    <div class="flex items-center gap-[10px]">
                        <button
                            class="w-[50px] h-[50px] bg-gray-200 rounded-full text-gray-500 text-[26px] bx bxs-news"></button>
                        <p class="font-semibold text-gray-500">News Feeds</p>
                    </div>
                </a>

                <a href="group">
                    <div class="flex items-center gap-[10px]">
                        <button
                            class="w-[50px] h-[50px] bg-gray-200 rounded-full text-gray-500 text-[26px] bx bx-group"></button>
                        <p class="font-semibold text-gray-500">Groups</p>
                    </div>
                </a>

                <a href="managerGroupChat">
                    <div class="flex items-center gap-[10px]">
                        <button
                            class="w-[50px] h-[50px] bg-gray-200 rounded-full text-gray-500 text-[26px] bx bx-windows"></button>
                        <p class="font-semibold text-gray-500">Manager Group Chat</p>
                    </div>
                </a>

                <div class="flex items-center gap-[10px]">
                    <button
                        class="w-[50px] h-[50px] bg-gray-200 rounded-full text-gray-500 text-[26px] bx bxs-videos"></button>
                    <p class="font-semibold text-gray-500">Video</p>
                </div>
            </div>

            <div class="grid gap-[10px] bg-white p-[20px] rounded-[10px] w-[300px]">
                <span class="text-gray-500 font-semibold">Account</span>

                <a href="changeInfo">
                    <div class="flex items-center gap-[10px]">
                        <button
                            class="w-[50px] h-[50px] bg-gray-200 rounded-full text-gray-500 text-[26px] bx bx-cog"></button>
                        <p class="font-semibold text-gray-500">Setting</p>
                    </div>
                </a>

                <div class="flex items-center gap-[10px]">
                    <button
                        class="w-[50px] h-[50px] bg-gray-200 rounded-full text-gray-500 text-[26px] bx bx-chat"></button>
                    <p class="font-semibold text-gray-500">Message</p>
                </div>

                <div class="flex items-center gap-[10px]">
                    <button
                        class="w-[50px] h-[50px] bg-gray-200 rounded-full text-gray-500 text-[26px] bx bx-book-bookmark"></button>
                    <p class="font-semibold text-gray-500">More</p>
                </div>
            </div>
        </div>

        <div id="modal-story" class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
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

        <div class="h-max grid items-center ml-[370px] mr-[470px] gap-[20px]">
            <div class="bg-white rounded-[10px] p-[20px] gap-[20px]">
                <div class="w-[650px]">
                    <div class="swiper story-swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide h-[220px] relative">
                                <div class="h-[220px] rounded-lg bg-black grid justify-center items-center">
                                    <img class="w-[100]"
                                        src="https://elead.com.vn/wp-content/uploads/2020/04/hinh-nen-dien-thoai-1-1-1.jpg">
                                </div>
                                <form action="{{ route('create-story') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="absolute bottom-4 left-12">
                                        <input type="file" id="story" name="story" accept="image/*"
                                            class="hidden" onchange="previewStory(event)">
                                        <label for="story"
                                            class="w-[40px] h-[40px] bg-mainColors rounded-[20px] cursor-pointer text-white bx bx-plus text-[24px] text-center leading-[40px]"></label>
                                        <button type="submit" id="submitStory" class="hidden">Submit</button>
                                    </div>
                                </form>
                            </div>
                            @foreach ($stories as $story)
                                <div class="swiper-slide h-[220px] relative">
                                    <img src="{{ $story->user->avatar }}" alt=""
                                        class="w-[35px] h-[35px] rounded-full avatar-user absolute top-2 left-2">
                                    <div class="h-[220px] rounded-lg bg-black grid justify-center items-center">
                                        <a href="{{ route('show-story') }}"><img class="w-[100]"
                                                src="{{ $story->image_url }}"></a>
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

            <form id="createPost-form" action="{{ route('create-post') }}"
                class="grid justify-start items-center bg-white rounded-[10px] p-[20px] gap-[20px]" method="POST"
                enctype="multipart/form-data">
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

            @foreach ($posts as $post)
                @if ($post->group_id == null)
                    <div class="grid items-center bg-white rounded-[10px] p-[20px] gap-[20px] relative">
                        <div class="flex items-center justify-between">
                            <div class="flex gap-[20px] items-center">
                                <img src="{{ $post->user->avatar ? $post->user->avatar : $avatar_temp }}"
                                    alt="" class="w-[40px] h-[40px] rounded-full avatar-user">

                                <div class="gird items-center">
                                    <form action="{{ route('show-profileDetails') }}" method="GET">
                                        <input type="hidden" name="userId" value="{{ $post->user->id }}">
                                        <button type="submit"
                                            class="font-semibold flex items-center gap-[5px]">{{ $post->user->name }}<i
                                                class='bx bxs-check-circle text-blue-500'></i></button>
                                    </form>
                                    <p class="text-gray-500 text-[14px]">{{ $post->time_upload }}</p>
                                </div>
                            </div>

                            <div class="relative">
                                @if (Auth::check() && Auth::id() == $post->user_id)
                                    <button data-post-id="{{ $post->id }}"
                                        class="w-[40px] h-[40px] text-[30px] rounded-full hover:bg-gray-200 transition-all show-cogPost"><i
                                            class='bx bx-dots-horizontal-rounded'></i></button>
                                @endif
                                <div class="w-max h-max bg-gray-200 p-[20px] absolute top-[100%] right-[40px] rounded-[10px] rounded-tr-[0px] hidden gap-[20px] text-left justify-start cogPost"
                                    data-post-id="{{ $post->id }}">
                                    <form method="POST" action="{{ route('delete-post') }}"
                                        data-post-id="{{ $post->id }}" class="deletePost-form">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="postId" value="{{ $post->id }}">
                                        <button type="submit"
                                            class="font-semibold flex items-center gap-[5px] text-blue-500 delete-post"><i
                                                class='bx bx-trash text-[24px]'></i> Delete Post</button>
                                    </form>
                                    <button class="font-semibold flex items-center gap-[5px] text-blue-500 editPost"><i
                                            class='bx bx-edit text-[24px]'></i> Edit Post</button>

                                    @if ($post->parent_post_id !== null)
                                        <form id="editPostShare-form" action="{{ route('edit-post-share') }}"
                                            class="editPost-show editPostShare-form absolute w-[430px] mr-[10px] right-[100%] top-[0] hidden justify-start items-center z-[999] bg-blue-200 rounded-[10px] p-[20px] gap-[20px]"
                                            method="POST" data-post-id="{{ $post->id }}">
                                            @csrf
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-[10px] cursor-pointer">
                                                    <button
                                                        class="w-[40px] h-[40px] bg-gray-200 rounded-full text-blue-500 text-[24px] bx bx-edit-alt"
                                                        type="button"></button>
                                                    <span class="text-gray-500 font-semibold">Edit Post</span>
                                                </div>

                                                <div class="flex items-center">
                                                    <button
                                                        class="cancel-editPost w-[40px] h-[40px] bg-gray-200 rounded-full text-blue-500 text-[24px] bx bx-x"
                                                        type="button" data-post-id="{{ $post->id }}"></button>
                                                </div>
                                            </div>

                                            <div
                                                class="w-full h-[120px] border-[2px] rounded-[10px] flex items-start justify-between p-[10px] gap-[10px]">
                                                <img id="avatar-preview-{{ $post->id }}"
                                                    src="{{ $user->avatar ? $user->avatar : $avatar_temp }}"
                                                    alt="" class="w-[40px] h-[40px] rounded-full avatar-user">
                                                <textarea name="edit-post" id="edit-post" cols="100" rows="10"
                                                    class="w-full h-full outline-none bg-blue-200 pr-[10px]" placeholder="What's on your mind?" class="edit-post">{{ $post->content }}</textarea>
                                            </div>

                                            <div class="flex items-center gap-[10px] cursor-pointer justify-end">
                                                <input type="hidden" name="postEdit-id"
                                                    value="{{ $post->id }}">
                                                <button id=""
                                                    class="EditPost font-semibold w-max px-[20px] rounded-[5px] h-[40px] text-mainColors bg-blue-300 flex items-center gap-[10px] justify-center"
                                                    type="submit" name="submit-edit-post"><i
                                                        class='bx bx-edit text-[24px]'></i>Edit Post</button>
                                            </div>
                                        </form>
                                    @else
                                        <form id="editPost-form" action="{{ route('edit-post') }}"
                                            class="editPost-show editPost-form absolute w-[430px] mr-[10px] right-[100%] top-[0] hidden justify-start items-center z-[999] bg-blue-200 rounded-[10px] p-[20px] gap-[20px]"
                                            method="POST" enctype="multipart/form-data"
                                            data-post-id="{{ $post->id }}">
                                            @csrf
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-[10px] cursor-pointer">
                                                    <button
                                                        class="w-[40px] h-[40px] bg-gray-200 rounded-full text-blue-500 text-[24px] bx bx-edit-alt"
                                                        type="button"></button>
                                                    <span class="text-gray-500 font-semibold">Edit Post</span>
                                                </div>

                                                <div class="flex items-center">
                                                    <button
                                                        class="cancel-editPost w-[40px] h-[40px] bg-gray-200 rounded-full text-blue-500 text-[24px] bx bx-x"
                                                        type="button" data-post-id="{{ $post->id }}"></button>
                                                </div>
                                            </div>

                                            <div
                                                class="w-full h-[120px] border-[2px] rounded-[10px] flex items-start justify-between p-[10px] gap-[10px]">
                                                <img id="avatar-preview-{{ $post->id }}"
                                                    src="{{ $user->avatar ? $user->avatar : $avatar_temp }}"
                                                    alt="" class="w-[40px] h-[40px] rounded-full avatar-user">
                                                <textarea name="edit-post" id="edit-post" cols="100" rows="10"
                                                    class="w-full h-full outline-none bg-blue-200 pr-[10px]" placeholder="What's on your mind?" class="edit-post">{{ $post->content }}</textarea>
                                            </div>

                                            <div class="relative">
                                                <input type="hidden" name="current-image"
                                                    id="current-image-{{ $post->id }}"
                                                    value="{{ $post->image_url }}">
                                                <img id="imageEditPost-preview-{{ $post->id }}"
                                                    src="{{ $post->image_url }}" alt=""
                                                    class="rounded-[10px] imageEditPost-preview"
                                                    data-post-id="{{ $post->id }}">
                                                <button id="delete-imageEditPost-preview-{{ $post->id }}"
                                                    class="delete-imageEditPost-preview w-[40px] h-[40px] bg-gray-200 rounded-full text-blue-500 text-[24px] bx bx-x absolute top-[10px] right-[10px]"
                                                    type="button" data-post-id="{{ $post->id }}"></button>
                                            </div>

                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-[10px] cursor-pointer">
                                                    <input type="file" id="imageEdit-post-{{ $post->id }}"
                                                        name="imageEdit-post" value="{{ $post->image_url }}"
                                                        accept="image/*" class="hidden"
                                                        onchange="previewImageEditPost(event, '{{ $post->id }}')">
                                                    <label for="imageEdit-post-{{ $post->id }}"
                                                        class="font-semibold w-max px-[20px] rounded-[5px] h-[40px] text-blue-500 bg-gray-200 flex items-center gap-[10px] justify-center"><i
                                                            class='bx bx-image-add text-[24px]'></i>Photo/Video</label>
                                                </div>

                                                <div class="flex items-center gap-[10px] cursor-pointer">
                                                    <input type="hidden" name="postEdit-id"
                                                        value="{{ $post->id }}">
                                                    <button id=""
                                                        class="EditPost font-semibold w-max px-[20px] rounded-[5px] h-[40px] text-mainColors bg-blue-300 flex items-center gap-[10px] justify-center"
                                                        type="submit" name="submit-edit-post"><i
                                                            class='bx bx-edit text-[24px]'></i>Edit Post</button>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if ($post->parent_post_id !== null)
                            @if ($post->content !== null || $post->image_url !== null)
                                <div>
                                    <p>
                                        {{ $post->content }}
                                    </p>
                                </div>
                            @endif

                            @if ($post->originalPost)
                                <div class="grid gap-[20px] border-[2px] p-[10px] rounded-[10px]">

                                    <div>
                                        <img src="{{ $post->originalPost->image_url }}" alt=""
                                            class="w-auto h-auto rounded-[10px]">
                                    </div>

                                    <div class="flex gap-[20px] items-center">
                                        <img src="{{ $post->originalPost->user->avatar ? $post->originalPost->user->avatar : $avatar_temp }}"
                                            alt="" class="w-[40px] h-[40px] rounded-full avatar-user">

                                        <div class="gird items-center">
                                            <form action="{{ route('show-profileDetails') }}" method="GET">
                                                @csrf
                                                <input type="hidden" name="userId"
                                                    value="{{ $post->originalPost->user->id }}">
                                                <button type="submit"
                                                    class="font-semibold flex items-center gap-[5px]">{{ $post->originalPost->user->name }}<i
                                                        class='bx bxs-check-circle text-blue-500'></i></button>
                                            </form>
                                            <p class="text-gray-500 text-[14px]">
                                                {{ $post->originalPost->time_upload }}
                                            </p>
                                        </div>
                                    </div>

                                    <div>
                                        <p>
                                            {{ $post->originalPost->content }}
                                        </p>
                                    </div>
                                </div>
                            @else
                                <div class="flex gap-[20px] border-[2px] p-[10px] rounded-[10px] items-center">
                                    <i class='bx bxs-lock-alt text-[28px]'></i>

                                    <div class="grid">
                                        <span class="font-semibold text-red-400">This content is not currently
                                            visible</span>

                                        <p class="text-[14px]">This error is often caused by the owner only sharing the
                                            content with a small group, changing who can see it, or deleting the
                                            content.
                                        </p>
                                    </div>
                                </div>
                            @endif
                        @else
                            @if ($post->content !== null || $post->image_url !== null)
                                <div class="grid gap-[20px] border-[2px] p-[10px] rounded-[10px]">
                                    <div>
                                        <p>
                                            {{ $post->content }}
                                        </p>
                                    </div>

                                    <div>
                                        <img src="{{ $post->image_url }}" alt=""
                                            class="w-auto h-auto rounded-[10px]">
                                    </div>
                                </div>
                            @endif
                        @endif

                        <div class="flex items-center justify-between border-b-[2px] pb-[10px]">
                            <p class="text-gray-500 font-semibold cursor-pointer">
                                @if ($post->likes->count() == 1)
                                    <span class="text-blue-500">{{ $post->likes->first()->user->name }}</span>
                                @elseif($post->likes->count() > 1)
                                    {{ $post->likes->first()->user->name }} and {{ $post->likes->count() - 1 }} others
                                @else
                                @endif
                            </p>
                            <p class="text-gray-500 font-semibold cursor-pointer">
                                {{ $post->comments->count() }} Comments
                            </p>
                        </div>

                        <div class="flex items-center justify-between border-b-[2px] pb-[10px]">
                            <form class="likePost-form flex items-center gap-[20px]"
                                action="{{ route('create-like') }}" data-post-id="{{ $post->id }}"
                                method="POST">
                                @csrf
                                <input type="hidden" name="post_Id" value="{{ $post->id }}">
                                @if ($user->likes->contains('post_id', $post->id))
                                    @php $islike = 'bg-red-500'; @endphp
                                @else
                                    @php $islike = 'bg-blue-500'; @endphp
                                @endif

                                <button onclick="likePost()"
                                    class="w-[40px] h-[40px] rounded-full {{ $islike }} text-white text-[24px] bx bx-heart bx-tada"
                                    type="submit" name="likePost"></button>
                            </form>

                            @if (Auth::check() && Auth::id() !== $post->user_id)
                                @if ($post->parent_post_id !== null)
                                    @if ($post->originalPost)
                                        <form class="sharePost-form flex items-center gap-[20px]"
                                            action="{{ route('create-share') }}"
                                            data-post-id="{{ $post->originalPost->id }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="post_Id"
                                                value="{{ $post->originalPost->id }}">
                                            <button
                                                class="w-[40px] h-[40px] bg-gray-500 rounded-full text-white text-[24px] bx bx-share"
                                                type="submit"></button>
                                        </form>
                                    @endif
                                @else
                                    <form class="sharePost-form flex items-center gap-[20px]"
                                        action="{{ route('create-share') }}" data-post-id="{{ $post->id }}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="post_Id" value="{{ $post->id }}">
                                        <button
                                            class="w-[40px] h-[40px] bg-gray-500 rounded-full text-white text-[24px] bx bx-share"
                                            type="submit"></button>
                                    </form>
                                @endif
                            @endif
                        </div>

                        <form class="createComment-form flex items-center" method="POST"
                            action="{{ route('create-comment') }}" data-post-id="{{ $post->id }}">
                            @csrf
                            <div class="w-[10%]">
                                <img src="{{ $user->avatar ? $user->avatar : $avatar_temp }}" alt=""
                                    class="w-[40px] h-[40px] rounded-full avatar-user">
                            </div>

                            <div class="border-[2px] rounded-[10px] p-[10px] flex items-center w-[90%] gap-[20px]">
                                <textarea name="comments" id="comments" class="w-full h-[50px] outline-none resize-none"
                                    placeholder="Write a public comment..."></textarea>
                                <input type="hidden" name="post_Id" value="{{ $post->id }}">
                                <button type="submit" class="" name="submit-comments"><i
                                        class='bx bx-send text-[30px] text-blue-500'></i></button>
                            </div>
                        </form>

                        <div class="overflow-y-scroll scroll-container max-h-[300px] grid gap-[10px] items-start">
                            @foreach ($post->comments as $comment)
                                <div class="flex items-center">
                                    <div class="w-[10%]">
                                        <img src="{{ $comment->user->avatar ? $comment->user->avatar : $avatar_temp }}"
                                            alt="" class="w-[40px] h-[40px] rounded-full">
                                    </div>

                                    <div class="bg-gray-200 p-[10px] rounded-[10px] w-[90%]">
                                        <form id="editComment-form" action="{{ route('edit-comment') }}"
                                            data-edit-id="{{ $post->id }}"
                                            data-id-comments="{{ $comment->id }}"
                                            class="hidden items-center editComment-form rounded-[10px] my-[10px] w-full"
                                            method="POST">
                                            @csrf
                                            <div class="w-full grid gap-[10px] text-left items-start">
                                                <div
                                                    class="border-[2px] border-blue-500 rounded-[10px] p-[10px] flex items-center w-full gap-[20px]">
                                                    <textarea name="Editcomments" id="Editcomments" class="w-full h-[50px] outline-none resize-none bg-gray-200"
                                                        placeholder="Write a public comment...">{{ $comment->content }}</textarea>
                                                    <input type="hidden" name="commentsEditId"
                                                        value="{{ $comment->id }}">
                                                    <button type="submit" class=""
                                                        name="submitEdit-comments"><i
                                                            class='bx bx-send text-[30px] text-blue-500'></i></button>
                                                </div>

                                                <button class="text-blue-500 text-[14px] cancel-editComment w-max"
                                                    id="cancel-editComment" type="button">Cancel</button>
                                            </div>
                                        </form>

                                        <div class="flex items-center justify-between relative">
                                            <form action="{{ route('show-profileDetails') }}" method="GET">
                                                <input type="hidden" name="userId"
                                                    value="{{ $comment->user->id }}">
                                                <button type="submit"
                                                    class="font-semibold flex items-center gap-[5px]">{{ $comment->user->name }}<i
                                                        class='bx bxs-check-circle text-blue-500'></i></button>
                                            </form>
                                            @if (Auth::check() && Auth::id() == $comment->user_id)
                                                <button
                                                    class="show-cogComments bx bx-dots-horizontal-rounded transition-all text-[22px] font-semibold rounded-full"
                                                    data-id-comments="{{ $comment->id }}"></button>
                                            @endif
                                            <div class="cogComments hidden bg-blue-50 gap-[10px] p-[10px] text-left rounded-[10px] absolute top-[0] right-[30px]"
                                                data-id-comments="{{ $comment->id }}">
                                                <button data-edit-id="{{ $post->id }}"
                                                    data-id-comments="{{ $comment->id }}"
                                                    class="show-form-EditComments flex items-center gap-[10px] font-semibold"
                                                    type="button"><i
                                                        class='bx bx-edit-alt text-[22px] text-mainColors'></i>
                                                    Edit
                                                    Comments</button>
                                                <form action="{{ route('delete-comment') }}" method="POST"
                                                    class="deleteComment-form"
                                                    data-id-comments="{{ $comment->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="commentsId"
                                                        value="{{ $comment->id }}">
                                                    <button type="submit"
                                                        class="flex items-center gap-[10px] font-semibold"><i
                                                            class='bx bx-trash text-[22px] text-mainColors'></i> Delete
                                                        Comments</button>
                                                </form>
                                            </div>
                                        </div>
                                        <p class="contentComment w-full overflow-hidden">
                                            {{ $comment->content }}
                                        </p>
                                        <span class="text-gray-500 text-[14px]">{{ $comment->created_at }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <div
            class="w-[400px] grid justify-center gap-[10px] overflow-y-scroll fixed right-0 h-[710px] scroll-container mr-[50px] rounded-[10px]">
            <div class="grid gap-[10px] bg-white rounded-[10px] w-[380px] p-[20px]">
                <div class="flex items-center justify-between w-full gap-[100px] border-b-[2px] pb-[20px]">
                    <p class="font-semibold">Friend Request</p>
                    <a href="profile.friends.requests">
                        <button class="text-blue-500 font-semibold cu">See All</button>
                    </a>
                </div>

                @if ($FriendRequests->isNotEmpty())
                    @foreach ($FriendRequests as $FriendRequest)
                        <div class="grid gap-[20px] pt-[10px]">
                            <div class="flex items-center gap-[20px]">
                                <img src="{{ $FriendRequest->user->avatar ? $FriendRequest->user->avatar : $avatar_temp }}"
                                    alt="" class="w-[40px] h-[40px] rounded-full">
                                <div class="grid">
                                    <form action="{{ route('show-profileDetails') }}" method="GET">
                                        <input type="hidden" name="userId" value="{{ $FriendRequest->user->id }}">
                                        <button type="submit"
                                            class="font-semibold flex items-center cursor-pointer gap-[5px]">
                                            {{ $FriendRequest->user->name }}
                                        </button>
                                    </form>

                                    <p class="text-gray-500 text-[14px]">{{ $FriendRequest->created_at }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-[20px]">
                                <form id="acceptedFriend-form" action="{{ route('acceptedFriend') }}"
                                    method="POST">
                                    @csrf
                                    <input type="hidden" name="friend_id" value="{{ $FriendRequest->user->id }}">
                                    <button
                                        class="w-[100px] h-[35px] bg-mainColors rounded-[20px] text-white font-semibold"
                                        type="submit">Confirm</button>
                                </form>

                                <form class="addFriend-form" action="{{ route('deleteFriend') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="friend_id" value="{{ $FriendRequest->user->id }}">
                                    <button class="w-[100px] h-[35px] bg-gray-200 rounded-[20px] font-semibold"
                                        type="submit">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>There are no friend requests.</p>
                @endif
            </div>

            <div class="grid gap-[10px] bg-white p-[20px] rounded-[10px] w-full">
                <div class="flex items-center justify-between w-full gap-[100px] border-b-[2px] pb-[20px]">
                    <p class="font-semibold">Friend's Birthday</p>
                </div>

                @foreach ($friends as $friend)
                    @if ($friend->status == 'accepted')
                        @if ($friend->user_id == Auth::id())
                            @if ($friend->friend)
                                @php
                                    $birthDate = \Carbon\Carbon::parse($friend->friend->birth);
                                    $currentDate = \Carbon\Carbon::now();
                                @endphp

                                @if ($birthDate->month == $currentDate->month && $birthDate->day == $currentDate->day)
                                    <div class="flex items-center gap-[10px]">
                                        <i class='bx bxs-gift bx-tada text-[35px] text-blue-500'></i>
                                        <p>Today is the birthday of <span
                                                class="font-semibold">{{ $friend->friend->name }}</span>.</p>
                                    </div>
                                @endif
                            @endif
                        @elseif ($friend->friend_id == Auth::id())
                            @if ($friend->user)
                                @php
                                    $birthDate = \Carbon\Carbon::parse($friend->user->birth);
                                    $currentDate = \Carbon\Carbon::now();
                                @endphp

                                @if ($birthDate->month == $currentDate->month && $birthDate->day == $currentDate->day)
                                    <div class="flex items-center gap-[10px]">
                                        <i class='bx bxs-gift bx-tada text-[35px] text-blue-500'></i>
                                        <p>Today is the birthday of <span
                                                class="font-semibold">{{ $friend->user->name }}</span>.</p>
                                    </div>
                                @endif
                            @endif
                        @endif
                    @endif
                @endforeach
            </div>

            <div class="grid gap-[10px] bg-white p-[20px] rounded-[10px]">
                <div class="flex items-center justify-between w-full gap-[100px] border-b-[2px] pb-[20px]">
                    <p class="font-semibold">Contact User</p>
                </div>

                @php $count = 0; @endphp

                @foreach ($friends as $friend)
                    @if ($friend->status == 'accepted')
                        @if ($friend->user_id == Auth::id())
                            @if ($friend->friend)
                                <div class="flex gap-[20px] items-center w-full">
                                    <img src="{{ $friend->friend->avatar ? $friend->friend->avatar : $avatar_temp }}"
                                        alt="" class="w-[40px] h-[40px] rounded-full avatar-user">
                                    <div class="flex justify-between items-center w-full">
                                        <form action="messageDetails" method="GET">
                                            <input type="hidden" name="roomId" value="{{ $friend->room_id }}">
                                            <button type="submit" class="font-semibold flex items-center gap-[5px]">
                                                {{ $friend->friend->name }}
                                                <i class="bx bxs-check-circle text-blue-500"></i>
                                            </button>
                                        </form>

                                        <div id="notification" data-id="{{ $friend->friend->id }}">
                                            @if ($friend->friend->status == 'online')
                                                <i class='bx bxs-circle text-[12px] text-green-500'></i>
                                            @else
                                                <i class='bx bxs-circle text-[12px] text-red-500'></i>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @php $count++; @endphp
                            @endif
                        @elseif ($friend->friend_id == Auth::id())
                            @if ($friend->user)
                                <div class="flex gap-[20px] items-center w-full">
                                    <img src="{{ $friend->user->avatar ? $friend->user->avatar : $avatar_temp }}"
                                        alt="" class="w-[40px] h-[40px] rounded-full avatar-user">
                                    <div class="flex justify-between items-center w-full">
                                        <form action="messageDetails" method="GET">
                                            <input type="hidden" name="roomId" value="{{ $friend->room_id }}">
                                            <button type="submit" class="font-semibold flex items-center gap-[5px]">
                                                {{ $friend->user->name }}
                                                <i class="bx bxs-check-circle text-blue-500"></i>
                                            </button>
                                        </form>

                                        <div class="notification" data-id="{{ $friend->user->id }}">
                                            @if ($friend->user->status == 'online')
                                                <i class='bx bxs-circle text-[12px] text-green-500'></i>
                                            @else
                                                <i class='bx bxs-circle text-[12px] text-red-500'></i>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @php $count++; @endphp
                            @endif
                        @endif
                    @endif

                    @if ($count == 10)
                    @break
                @endif
            @endforeach
        </div>

        <div class="grid gap-[10px] bg-white p-[20px] rounded-[10px]">
            <div class="flex items-center justify-between w-full gap-[100px] border-b-[2px] pb-[20px]">
                <p class="font-semibold">Contact Group</p>
            </div>

            <div class="grid">
                @php $count = 0; @endphp

                @foreach ($groupMembers as $groupMember)
                    @if ($groupMember->user_id == Auth::id())
                        <form action="{{ route('chatGroupDetails') }}" method="GET">
                            <div class="flex gap-[20px] items-center w-full py-[5px]">
                                <input type="hidden" name="room_id"
                                    value="{{ $groupMember->group->room_id }}">
                                <img src="{{ $groupMember->group->avatar }}" alt=""
                                    class="w-[40px] h-[40px] rounded-full avatar-user">
                                <div class="flex justify-between items-center w-full">
                                    <div>
                                        <button type="submit" class="font-semibold flex items-center gap-[5px]">
                                            {{ $groupMember->group->group_name }}
                                            <i class="bx bxs-check-circle text-blue-500"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @php $count++; @endphp

                        @if ($count == 5)
                        @break
                    @endif
                @endif
            @endforeach
        </div>
    </div>
</div>
</main>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="/Script/stories.js"></script>
<script src="/Script/ajax.js"></script>
<script src="/Script/home.js"></script>
</body>

</html>
