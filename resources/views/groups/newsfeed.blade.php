<div class="h-max grid items-center w-full ml-[465px] gap-[20px]">
    @foreach ($posts as $post)
        @if ($post->group_id != null)
            <div class="grid items-center bg-gray-100 rounded-[10px] p-[20px] gap-[20px] relative">
                <div class="flex items-center justify-between">
                    <div class="relative">
                        <div class="flex gap-[20px] items-start">
                            <img src="{{ $post->group->avatar }}" alt="" class="w-[50px] h-[50px] rounded-full">

                            <form action="{{ route('groupDetails') }}" method="GET">
                                <input type="hidden" name="idGroup" value="{{ $post->group->id }}">
                                <button type="submit"
                                    class="font-semibold text-[18px] text-blue-500">{{ $post->group->name }}</button>
                            </form>
                        </div>

                        <div class="flex gap-[10px] items-center absolute w-max top-[40%] left-[30px]">
                            <img src="{{ $post->user->avatar ? $post->user->avatar : $avatar_temp }}" alt=""
                                class="w-[30px] h-[30px] rounded-full avatar-user">

                            <div class="flex items-center gap-[10px]">
                                <form action="{{ route('show-profileDetails') }}" method="GET">
                                    <input type="hidden" name="userId" value="{{ $post->user->id }}">
                                    <button type="submit"
                                        class="font-semibold flex items-center gap-[5px]">{{ $post->user->name }}<i
                                            class='bx bxs-check-circle text-blue-500'></i></button>
                                </form>
                                <p class="text-gray-500 text-[14px]">{{ $post->time_upload }}</p>
                            </div>
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
                                            <span class="text-gray-500 font-semibold">Edit
                                                Post</span>
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
                                            src="{{ $user->avatar ? $user->avatar : $avatar_temp }}" alt=""
                                            class="w-[40px] h-[40px] rounded-full avatar-user">
                                        <textarea name="edit-post" id="edit-post" cols="100" rows="10"
                                            class="w-full h-full outline-none bg-blue-200 pr-[10px]" placeholder="What's on your mind?" class="edit-post">{{ $post->content }}</textarea>
                                    </div>

                                    <div class="flex items-center gap-[10px] cursor-pointer justify-end">
                                        <input type="hidden" name="postEdit-id" value="{{ $post->id }}">
                                        <button id=""
                                            class="EditPost font-semibold w-max px-[20px] rounded-[5px] h-[40px] text-mainColors bg-blue-300 flex items-center gap-[10px] justify-center"
                                            type="submit" name="submit-edit-post"><i
                                                class='bx bx-edit text-[24px]'></i>Edit
                                            Post</button>
                                    </div>
                                </form>
                            @else
                                <form id="editPost-form" action="{{ route('edit-post') }}"
                                    class="editPost-show editPost-form absolute w-[430px] mr-[10px] right-[100%] top-[0] hidden justify-start items-center z-[999] bg-blue-200 rounded-[10px] p-[20px] gap-[20px]"
                                    method="POST" enctype="multipart/form-data" data-post-id="{{ $post->id }}">
                                    @csrf
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-[10px] cursor-pointer">
                                            <button
                                                class="w-[40px] h-[40px] bg-gray-200 rounded-full text-blue-500 text-[24px] bx bx-edit-alt"
                                                type="button"></button>
                                            <span class="text-gray-500 font-semibold">Edit
                                                Post</span>
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
                                            src="{{ $user->avatar ? $user->avatar : $avatar_temp }}" alt=""
                                            class="w-[40px] h-[40px] rounded-full avatar-user">
                                        <textarea name="edit-post" id="edit-post" cols="100" rows="10"
                                            class="w-full h-full outline-none bg-blue-200 pr-[10px]" placeholder="What's on your mind?" class="edit-post">{{ $post->content }}</textarea>
                                    </div>

                                    <div class="relative">
                                        <input type="hidden" name="current-image"
                                            id="current-image-{{ $post->id }}" value="{{ $post->image_url }}">
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
                                            <input type="hidden" name="postEdit-id" value="{{ $post->id }}">
                                            <button id=""
                                                class="EditPost font-semibold w-max px-[20px] rounded-[5px] h-[40px] text-mainColors bg-blue-300 flex items-center gap-[10px] justify-center"
                                                type="submit" name="submit-edit-post"><i
                                                    class='bx bx-edit text-[24px]'></i>Edit
                                                Post</button>
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
                                <span class="font-semibold text-red-400">This content is not
                                    currently
                                    visible</span>

                                <p class="text-[14px]">This error is often caused by the owner only
                                    sharing the
                                    content with a small group, changing who can see it, or deleting
                                    the
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
                            {{ $post->likes->first()->user->name }} and
                            {{ $post->likes->count() - 1 }} others
                        @else
                        @endif
                    </p>
                    <p class="text-gray-500 font-semibold cursor-pointer">
                        {{ $post->comments->count() }} Comments
                    </p>
                </div>

                <div class="flex items-center justify-between border-b-[2px] pb-[10px]">
                    <form class="likePost-form flex items-center gap-[20px]" action="{{ route('create-like') }}"
                        data-post-id="{{ $post->id }}" method="POST">
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
                                    <input type="hidden" name="post_Id" value="{{ $post->originalPost->id }}">
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
                        <textarea name="comments" id="comments" class="w-full h-[50px] outline-none resize-none bg-gray-100"
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
                                    data-edit-id="{{ $post->id }}" data-id-comments="{{ $comment->id }}"
                                    class="hidden items-center editComment-form rounded-[10px] my-[10px] w-full"
                                    method="POST">
                                    @csrf
                                    <div class="w-full grid gap-[10px] text-left items-start">
                                        <div
                                            class="border-[2px] border-blue-500 rounded-[10px] p-[10px] flex items-center w-full gap-[20px]">
                                            <textarea name="Editcomments" id="Editcomments" class="w-full h-[50px] outline-none resize-none bg-gray-200"
                                                placeholder="Write a public comment...">{{ $comment->content }}</textarea>
                                            <input type="hidden" name="commentsEditId" value="{{ $comment->id }}">
                                            <button type="submit" class="" name="submitEdit-comments"><i
                                                    class='bx bx-send text-[30px] text-blue-500'></i></button>
                                        </div>

                                        <button class="text-blue-500 text-[14px] cancel-editComment w-max"
                                            id="cancel-editComment" type="button">Cancel</button>
                                    </div>
                                </form>

                                <div class="flex items-center justify-between relative">
                                    <form action="{{ route('show-profileDetails') }}" method="GET">
                                        <input type="hidden" name="userId" value="{{ $comment->user->id }}">
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
                                            type="button"><i class='bx bx-edit-alt text-[22px] text-mainColors'></i>
                                            Edit
                                            Comments</button>
                                        <form action="{{ route('delete-comment') }}" method="POST"
                                            class="deleteComment-form" data-id-comments="{{ $comment->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="commentsId" value="{{ $comment->id }}">
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
</div>
