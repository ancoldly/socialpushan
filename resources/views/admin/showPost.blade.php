@extends('admin.layout')
@section('content')
    <main class="grid gap-[20px] p-[20px]">
        <div class="p-[20px] rounded-[10px] border-[2px]">
            <table>
                <tr class="border-b-[2px]">
                    <td class="pb-[20px] font-medium text-gray-500 px-[20px]">Type</td>
                    <td class="pb-[20px] font-medium text-gray-500 px-[20px]">Name</td>
                    <td class="pb-[20px] font-medium text-gray-500 px-[20px]">Content</td>
                    <td class="pb-[20px] font-medium text-gray-500 px-[20px]">Image</td>
                    <td class="pb-[20px] font-medium text-gray-500 px-[20px]">Like</td>
                    <td class="pb-[20px] font-medium text-gray-500 px-[20px]">Comment</td>
                    <td class="pb-[20px] font-medium text-gray-500 px-[20px]">Active</td>
                    <td class="pb-[20px] font-medium text-gray-500 px-[20px]">View</td>
                </tr>
                @foreach ($posts as $post)
                    @if ($post->user->role !== 'admin')
                        <tr class="p-[10px]">
                            <td class="py-[10px] px-[20px] w-[50px]">
                                @if ($post->parent_post_id !== null)
                                    <p class="text-blue-500 font-medium">Share</p>
                                @else
                                    <p class="text-mainColors font-medium">Post</p>
                                @endif
                            </td>
                            <td class="py-[10px] px-[20px] font-medium">{{ $post->user->name }}</td>
                            <td class="py-[10px] px-[20px] w-[300px]">{{ $post->content }}</td>
                            <td class="py-[10px] px-[20px]">
                                @if ($post->image_url != null)
                                    <img src="/{{ $post->image_url }}" class="w-[200px] rounded-[10px]">
                                @endif
                            </td>
                            <td class="py-[10px] px-[20px] font-medium w-[50px] text-center">{{ $post->likes->count() }}
                            </td>
                            <td class="py-[10px] px-[20px] font-medium w-[50px] text-center">{{ $post->comments->count() }}
                            </td>

                            <td class="py-[10px] px-[20px]">
                                <button onclick="adminDeletePost({{ $post->id }})" id="admin-delete-post"
                                    class="text-red-500 font-medium flex items-center justify-center text-[25px]"><i
                                        class='bx bxs-trash'></i></button>
                            </td>

                            <td class="py-[10px] px-[20px]">
                                @if ($post->parent_post_id == null)
                                    <button
                                        class="myBtn text-blue-500 font-medium flex items-center justify-center text-[25px]"
                                        value="{{ $post->id }}"><i class='bx bxs-news'></i></button>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </div>
    </main>

    <div id="myModal" class="fixed top-[150px] left-[500px] mx-auto z-[9999] w-max bg-white rounded-[10px]">
        <div class="modal-content rounded-[10px]">

        </div>
    </div>

    <script src="/Script/admin.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
@endsection
