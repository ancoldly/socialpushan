<div class="flex items-start justify-between gap-[20px]">
    <div class="w-[45%] grid gap-[10px]">
        <div class="grid p-[20px] bg-white rounded-[10px]">
            <div class="grid gap-[20px]">
                <span class="font-semibold">Introduce</span>

                <div class="grid gap-[10px]">
                    <div class="flex items-center gap-[10px] justify-start">
                        <i class='bx bxs-home-smile text-[24px] text-gray-500'></i>
                        <p>
                            {{ $user->address ? $user->address : 'No information.' }}
                        </p>
                    </div>

                    <div class="flex items-center gap-[10px] justify-start">
                        <i class='bx bxs-phone text-[24px] text-gray-500'></i>
                        <p>
                            {{ $user->telephone ? $user->telephone : 'No information.' }}
                        </p>
                    </div>


                    <div class="flex items-center gap-[10px] justify-start">
                        <i class='bx bxl-gmail text-[24px] text-gray-500'></i>
                        <p>
                            {{ $user->email }}
                        </p>
                    </div>

                    <div class="flex items-center gap-[10px] justify-start">
                        <i class='bx bx-male-female text-[24px] text-gray-500'></i>
                        <p>
                            {{ $user->gender }}
                        </p>
                    </div>

                    <div class="flex items-center gap-[10px] justify-start">
                        <i class='bx bx-cake text-[24px] text-gray-500'></i>
                        <p>
                            {{ date('d-m-Y', strtotime($user->birth)) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid p-[20px] bg-white rounded-[10px] gap-[20px]">
            <div class="flex items-center justify-between">
                <span class="font-semibold">Picture</span>

                <form action="{{ route('profileDetails.images') }}" method="GET">
                    <input type="hidden" name="userId" value="{{ $user->id }}">
                    <button id="main-image" class="font-semibold text-blue-500">See All Picture</button>
                </form>
            </div>

            <div class="grid grid-cols-3 gap-[10px]">
                @if ($images->count() > 0)
                    @foreach ($images as $image)
                        <img src="{{ $image->image_url }}" alt="" class="rounded-[5px] h-[120px]">
                    @endforeach
                @else
                    <p class="text-gray-500">No images yet</p>
                @endif
            </div>
        </div>

        <div class="grid p-[20px] bg-white rounded-[10px] gap-[20px]">
            <div class="flex items-center justify-between">
                <span class="font-semibold">Friends</span>

                <form action="{{ route('profileDetails.friends') }}" method="GET">
                    <input type="hidden" name="userId" value="{{ $user->id }}">
                    <button id="main-friend" class="font-semibold text-blue-500">See All Friends</button>
                </form>
            </div>

            <div class="grid grid-cols-3 gap-[20px]">
                @php
                    $friendCount = 0;
                @endphp

                @foreach ($friends as $friend)
                    @if ($friend->status == 'accepted')
                        @if ($friend->user_id == $user->id)
                            @if ($friend->friend)
                                @php
                                    $friendCount++;
                                @endphp

                                <form action="{{ route('show-profileDetails') }}" method="GET"
                                    class="grid gap-[10px]">
                                    <img src="{{ $friend->friend->avatar ? $friend->friend->avatar : $avatar_temp }}"
                                        alt="" class="rounded-[5px]">
                                    <input type="hidden" name="userId" value="{{ $friend->friend->id }}">
                                    <button type="submit" class="font-semibold flex items-center gap-[5px]">
                                        <span class="text-[14px] font-semibold">{{ $friend->friend->name }}</span>
                                        <i class="bx bxs-check-circle text-blue-500"></i>
                                    </button>
                                </form>

                                @if ($friendCount >= 6)
                                @break
                            @endif
                        @endif
                    @elseif ($friend->friend_id == $user->id)
                        @if ($friend->user)
                            @php
                                $friendCount++;
                            @endphp

                            <form action="{{ route('show-profileDetails') }}" method="GET"
                                class="grid gap-[10px]">
                                <img src="{{ $friend->user->avatar ? $friend->user->avatar : $avatar_temp }}"
                                    alt="" class="rounded-[5px]">
                                <input type="hidden" name="userId" value="{{ $friend->user->id }}">
                                <button type="submit" class="font-semibold flex items-center gap-[5px]">
                                    <span class="text-[14px] font-semibold">{{ $friend->user->name }}</span>
                                    <i class="bx bxs-check-circle text-blue-500"></i>
                                </button>
                            </form>

                            @if ($friendCount >= 6)
                            @break
                        @endif
                    @endif
                @endif
            @endif
        @endforeach
    </div>
</div>
</div>

<div class="w-[55%] grid gap-[10px] relative">
@if ($user->posts->count() > 0)
    @foreach ($user->posts as $post)
        @if ($post->group_id == null)
            <div class="grid items-center bg-white rounded-[10px] p-[20px] gap-[20px] relative">
                <div class="flex items-center justify-between">
                    <div class="flex gap-[20px] items-center">
                        <img src="{{ $post->user->avatar ? $post->user->avatar : $avatar_temp }}"
                            alt="" class="w-[40px] h-[40px] rounded-full avatar-user">

                        <div class="gird items-center">
                            <form action="{{ route('show-profileDetails') }}" method="GET">
                                @csrf
                                <input type="hidden" name="userId" value="{{ $post->user->id }}">
                                <button type="submit"
                                    class="font-semibold flex items-center gap-[5px]">{{ $post->user->name }}<i
                                        class='bx bxs-check-circle text-blue-500'></i></button>
                            </form>
                            <p class="text-gray-500 text-[14px]">{{ $post->time_upload }}</p>
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

                                <p class="text-[14px]">This error is often caused by the owner only
                                    sharing
                                    the
                                    content with a small group, changing who can see it, or deleting the
                                    content.</p>
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
                            {{ $post->likes->first()->user->name }} and
                            {{ $post->likes->count() - 1 }}
                            others
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
                        @if (Auth::check() && Auth::user()->likes->contains('post_id', $post->id))
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
                        @if (Auth::check())
                            <img src="{{ Auth::user()->avatar ? Auth::user()->avatar : $avatar_temp }}"
                                alt="" class="w-[40px] h-[40px] rounded-full">
                        @endif

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
                                        @csrf
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
                                                    class='bx bx-trash text-[22px] text-mainColors'></i>
                                                Delete
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
@endif
</div>
</div>
