<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Comment;
use App\Models\Friendship;
use App\Models\Like;
use App\Models\Activity;
use App\Models\Post;
use App\Models\ChatGroup;
use App\Models\Story;
use App\Models\GroupMember;
use DateTime;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;



class UserController extends Controller
{

    private function loadUserProfile($request, $view)
    {
        if (Auth::check()) {
            $user = User::find(Auth::id());

            $firstJoinedGroup = $user->groups()->orderBy('group_members.created_at', 'asc')->first();

            $acceptedFriends = Auth::user()->acceptedFriends;

            $friends = Friendship::all();

            $posts = Post::with(['user', 'likes', 'comments'])->orderBy('created_at', 'desc')->get();

            $userActivities = Activity::where('receiver_id', Auth::id())->get();

            $images = Post::where('user_id', $user->id)
                ->where(function ($query) {
                    $query->whereNull('group_id')->orWhere('group_id', '=', '');
                })
                ->whereNotNull('image_url')
                ->orderBy('created_at', 'desc')
                ->get();

            $FriendRequests = Friendship::where('status', 'pending')
                ->where('friend_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();

            return view($view, compact('posts', 'acceptedFriends', 'friends', 'firstJoinedGroup', 'images', 'FriendRequests', 'userActivities'));
        }
    }

    public function showProfile()
    {
        return $this->loadUserProfile(request(), 'users.profile');
    }

    public function friends()
    {
        return $this->loadUserProfile(request(), 'users.profile_friend');
    }

    public function images()
    {
        return $this->loadUserProfile(request(), 'users.profile_image');
    }

    public function requests()
    {
        return $this->loadUserProfile(request(), 'users.profile_friend_requests');
    }


    public function showHome()
    {
        if (Auth::check()) {
            $user = User::find(Auth::id());

            $firstJoinedGroup = $user->groups()->orderBy('group_members.created_at', 'asc')->first();

            $posts = Post::with(['user', 'likes', 'comments'])->orderBy('created_at', 'desc')->get();

            $friends = Friendship::all();

            $groupChats = ChatGroup::all();
            $groupMembers = GroupMember::all();

            $userActivities = Activity::where('receiver_id', Auth::id())->get();

            $now = Carbon::now();
            $oneHourAgo = $now->copy()->subDay();
            $stories = Story::with(['user'])->whereBetween('created_at', [$oneHourAgo, $now])->orderBy('created_at', 'desc')->get();

            $FriendRequests = Friendship::where('status', 'pending')
                ->where('friend_id', Auth::id())->limit(1)
                ->orderBy('created_at', 'desc')
                ->get();

            return view('users.home', compact('posts', 'friends', 'FriendRequests', 'groupChats', 'groupMembers', 'firstJoinedGroup', 'stories', 'userActivities'));
        }
    }

    public function showStory()
    {
        $user = User::find(Auth::id());

        $firstJoinedGroup = $user->groups()->orderBy('group_members.created_at', 'asc')->first();

        $friends = Friendship::all();

        $userActivities = Activity::where('receiver_id', Auth::id())->get();

        $now = Carbon::now();
        $oneHourAgo = $now->copy()->subDay();
        $stories = Story::with(['user'])->whereBetween('created_at', [$oneHourAgo, $now])->orderBy('created_at', 'desc')->get();
        return view('users.stories', compact('stories', 'firstJoinedGroup', 'friends', 'userActivities'));
    }

    private function loadProfileDetails($userId, $view)
    {
        if (Auth::check()) {
            $user = User::find(Auth::id());

            $firstJoinedGroup = $user->groups()->orderBy('group_members.created_at', 'asc')->first();
            $avatar_temp = "/image/user.png";
            $friends = Friendship::all();

            if ($userId == Auth::id()) {
                return redirect()->route('show-profile');
            }

            $friendship = Friendship::where(function ($query) use ($userId) {
                $query->where('user_id', Auth::id())->where('friend_id', $userId);
            })->orWhere(function ($query) use ($userId) {
                $query->where('user_id', $userId)->where('friend_id', Auth::id());
            })->first();

            $roomId = $friendship ? $friendship->room_id : null;

            $images = Post::where('user_id', $userId)
                ->where(function ($query) {
                    $query->whereNull('group_id')->orWhere('group_id', '=', '');
                })
                ->whereNotNull('image_url')
                ->orderBy('created_at', 'desc')
                ->get();

            $user = User::with(['posts', 'likes', 'comments', 'friendships'])->orderBy('created_at', 'desc')->get()->find($userId);

            $status = Friendship::where('user_id', Auth::id())
                ->where('friend_id', $userId)
                ->orWhere('user_id', $userId)
                ->where('friend_id', Auth::id())
                ->first();

            $acceptedFriends = $user->acceptedFriends;

            $userActivities = Activity::where('receiver_id', Auth::id())->get();

            return view($view, compact('user', 'status', 'avatar_temp', 'acceptedFriends', 'friends', 'roomId', 'firstJoinedGroup', 'images', 'userActivities'));
        }

        return redirect()->route('show-form-login');
    }

    public function showProfileDetails(Request $request)
    {
        return $this->loadProfileDetails($request->input('userId'), 'pages.profileDetails');
    }

    public function Detailsfriends(Request $request)
    {
        return $this->loadProfileDetails($request->input('userId'), 'pages.profileDetails_friend');
    }

    public function Detailsimages(Request $request)
    {
        return $this->loadProfileDetails($request->input('userId'), 'pages.profileDetails_image');
    }


    public function editBiography(Request $request)
    {
        $user = User::find(Auth::id());

        $user->biography = $request->biography;

        $user->save();
        $mess = "Biography edit successfully";
        session()->flash('notification', $mess);

        return response()->json(['success' => true, 'biography' => $user->biography]);
    }

    public function editAvatar(Request $request)
    {
        $user = User::find(Auth::id());

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatar_name = $avatar->getClientOriginalName();
            $avatar_path = '/avatar/' . $avatar_name;

            $avatar->storeAs('avatar', $avatar_name, 'avatar');

            $otherAvatar = User::where('avatar', $user->avatar)->where('id', '!=', $user->id)->count();

            if ($otherAvatar === 0) {
                if ($user->avatar && Storage::disk('avatar')->exists($user->avatar)) {
                    Storage::disk('avatar')->delete($user->avatar);
                }
            }

            $user->avatar = $avatar_path;
            $user->save();
            $mess = "Avatar edit successfully";
            session()->flash('notification', $mess);

            return response()->json(['success' => true, 'avatar' => $user->avatar]);
        }

        return response()->json(['success' => false]);
    }

    public function createPost(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('show-form-login');
        }

        $user = User::find(Auth::id());
        $contentPost = $request->input('content-post');
        $imagePost = $request->file('image-post');

        $post = new Post();
        $post->user_id = $user->id;
        $post->time_upload = now();

        if (!empty($contentPost)) {
            $post->content = $contentPost;
        }

        if (!empty($imagePost)) {
            $imagePost_name = $imagePost->getClientOriginalName();
            $imagePost_path = 'imagePost/' . $imagePost_name;
            $imagePost->storeAs('imagePost', $imagePost_name, 'imagePost');
            $post->image_url = $imagePost_path;
        }

        $post->save();
        $mess = "Post create successfully";
        session()->flash('notification', $mess);
        return response()->json(['success' => true]);
    }

    public function editPost(Request $request)
    {
        $postId = $request->input('postEdit-id');
        $contentEditPost = $request->input('edit-post');
        $imageEditPost = $request->file('imageEdit-post');
        $imageTemp = $request->input('current-image');

        $otherPosts = Post::where('image_url', $imageTemp)->where('id', '!=', $postId)->count();

        $post = Post::find($postId);

        if (!empty($imageEditPost)) {
            $imageEditFileName = $imageEditPost->getClientOriginalName();
            $imageEditPath = 'imagePost/' . $imageEditFileName;
            $imageEditPost->storeAs('imagePost', $imageEditFileName, 'imagePost');

            if ($otherPosts === 0) {
                if (!empty($imageTemp)) {
                    Storage::disk('imagePost')->delete($imageTemp);
                }
            }

            if (!empty($contentEditPost)) {
                $post->content = $contentEditPost;
            } else {
                $post->content = null;
            }

            $post->image_url = $imageEditPath;
        } else {
            if (!empty($imageTemp)) {
                if (!empty($contentEditPost)) {
                    $post->content = $contentEditPost;
                } else {
                    $post->content = null;
                }
                $post->image_url = $imageTemp;
            } else {
                if ($otherPosts === 0) {
                    Storage::disk('imagePost')->delete($imageTemp);
                }
                $post->image_url = null;
                if (!empty($contentEditPost)) {
                    $post->content = $contentEditPost;
                } else {
                    $post->content = null;
                }
            }
        }

        $post->save();

        $mess = "Post edited successfully";
        session()->flash('notification', $mess);
        return response()->json(['success' => true]);
    }

    public function deletePost(Request $request)
    {
        $postId = $request->postId;

        $post = Post::find($postId);

        if ($post) {
            $imagePath = $post->image_url;

            $otherPosts = Post::where('image_url', $imagePath)->where('id', '!=', $postId)->count();

            if ($otherPosts === 0) {
                if (!empty($imagePath)) {
                    Storage::disk('imagePost')->delete($imagePath);
                }
            }

            Comment::where('post_id', $postId)->delete();
            Like::where('post_id', $postId)->delete();
        }

        if ($post->delete()) {
            $mess = "Post deletion successful!";
            session()->flash('notification', $mess);
            return response()->json(['success' => true]);
        }
    }

    public function createComment(Request $request)
    {
        $comment = new Comment();

        $comment->post_id = $request->post_Id;
        $comment->user_id = Auth::id();
        $comment->content = $request->comments;
        $comment->created_at = now();
        $comment->save();

        Activity::create([
            'user_id' => Auth::id(),
            'subject_id' => $comment->id,
            'receiver_id' => $comment->post->user_id,
            'subject_type' => 'App\Models\Comment',
            'type' => 'comment',
        ]);

        $mess = "Comment created successfully";
        session()->flash('notification', $mess);

        return response()->json(['success' => true]);
    }

    public function createLike(Request $request)
    {
        $postId = $request->post_Id;
        $userId = Auth::id();

        $post = Post::find($postId);

        if (!$post) {
            return response()->json(['success' => false, 'message' => 'Post not found']);
        }

        $like = Like::where('user_id', $userId)
            ->where('post_id', $postId)
            ->first();

        if (!$like) {
            $like = new Like();
            $like->user_id = $userId;
            $like->post_id = $postId;
            $like->is_like = true;

            if ($like->save()) {

                Activity::create([
                    'user_id' => $userId,
                    'subject_id' => $postId,
                    'receiver_id' => $post->user_id,
                    'subject_type' => 'App\Models\Post',
                    'type' => 'like',
                ]);

                $mess = "Post liked successfully";
                session()->flash('notification', $mess);
            }
        } else {
            $like->delete();

            Activity::where('user_id', $userId)
                ->where('subject_id', $postId)
                ->where('subject_type', 'App\Models\Post')
                ->where('type', 'like')
                ->delete();

            $mess = "Delete liked successfully";
            session()->flash('notification', $mess);
        }

        return response()->json(['success' => true]);
    }


    public function deleteComment(Request $request)
    {
        $commentId = $request->commentsId;

        $comment = Comment::find($commentId);

        if ($comment) {
            $comment->delete();

            Activity::where('user_id', $comment->user_id)
                ->where('subject_id', $commentId)
                ->where('subject_type', 'App\Models\Comment')
                ->where('type', 'comment')
                ->delete();

            $mess = "Comment deletion successful!";
            session()->flash('notification', $mess);
            return response()->json(['success' => true]);
        }
    }

    public function editComment(Request $request)
    {
        $commentId = $request->input('commentsEditId');
        $contentEditComment = $request->input('Editcomments');

        $comment = Comment::find($commentId);

        $comment->content = $contentEditComment;
        $comment->save();

        $mess = "Comment updated successfully.";
        session()->flash('notification', $mess);
        return response()->json(['success' => true]);
    }

    public function createShare(Request $request)
    {
        $originalPost = Post::find($request->post_Id);

        $sharedPost = new Post();

        $sharedPost->user_id = Auth::id();
        $sharedPost->parent_post_id = $originalPost->id;
        $sharedPost->time_upload = now();
        $sharedPost->save();

        Activity::create([
            'user_id' => Auth::id(),
            'subject_id' => $sharedPost->id,
            'receiver_id' => $originalPost->user_id,
            'subject_type' => 'App\Models\Post',
            'type' => 'share',
        ]);

        $mess = "Share post successfully";
        session()->flash('notification', $mess);

        return response()->json(['success' => true]);
    }

    public function editPostShare(Request $request)
    {
        $post = Post::find($request->input('postEdit-id'));
        $post->content = $request->input('edit-post');

        $post->save();

        $mess = "Post edited successfully";
        session()->flash('notification', $mess);
        return response()->json(['success' => true]);
    }


    public function search(Request $request)
    {
        if ($request->ajax()) {
            $results = User::where('name', 'LIKE', '%' . $request->search . '%')->limit(6)->get();
            $output = [];

            foreach ($results as $result) {
                $avatar = $result->avatar ? $result->avatar : "/image/user.png";

                $output[] = [
                    'avatar' => $avatar,
                    'id' => $result->id,
                    'username' => $result->name,
                ];
            }

            return response()->json(['success' => true, 'results' => $output]);
        }
    }


    public function addFriend(Request $request)
    {
        $friendId = $request->friend_id;
        $userId = Auth::id();

        $friendship = Friendship::where(function ($query) use ($userId, $friendId) {
            $query->where('user_id', $userId)
                ->where('friend_id', $friendId);
        })->orWhere(function ($query) use ($userId, $friendId) {
            $query->where('user_id', $friendId)
                ->where('friend_id', $userId);
        })->first();

        if ($friendship) {
            $friendship->delete();
            $mess = "Friend request canceled successfully.";
        } else {
            $friendship = new Friendship();
            $friendship->user_id = $userId;
            $friendship->friend_id = $friendId;
            $friendship->status = 'pending';
            $friendship->save();

            $mess = "Friend request sent successfully.";
        }

        session()->flash('notification', $mess);
        return response()->json(['success' => true]);
    }

    public function acceptedFriend(Request $request)
    {
        $friendId = $request->friend_id;
        $userId = Auth::id();

        $friendship = Friendship::where('user_id', $friendId)
            ->where('friend_id', $userId)
            ->first();

        if ($friendship && $friendship->status == 'pending') {
            $friendship->status = 'accepted';
            $friendship->room_id = Str::random(10);
            $friendship->save();
            $mess = "Friend request accepted successfully.";
        }

        session()->flash('notification', $mess);
        return response()->json(['success' => true]);
    }

    public function deleteFriend(Request $request)
    {
        $friendId = $request->friend_id;
        $userId = Auth::id();

        $friendship = Friendship::where(function ($query) use ($userId, $friendId) {
            $query->where('user_id', $userId)
                ->where('friend_id', $friendId);
        })->orWhere(function ($query) use ($userId, $friendId) {
            $query->where('user_id', $friendId)
                ->where('friend_id', $userId);
        })->first();

        if ($friendship) {
            if ($friendship->status == 'pending' || $friendship->status == 'accepted') {
                $friendship->delete();

                if ($friendship->status == 'pending') {
                    $mess = "Friend request canceled successfully.";
                } else {
                    $mess = "Unfriend successfully.";
                }

                session()->flash('notification', $mess);
                return response()->json(['success' => true]);
            }
        }
    }

    public function deleteStory($id)
    {
        $story = Story::find($id);

        $otherStory = Story::where('image_url', $story->image_url)->where('id', '!=', $story->id)->count();

        if ($otherStory === 0) {
            Storage::disk('imageStory')->delete($story->image_url);
        }

        $story->delete();
        return redirect()->back();
    }

    public function createStory(Request $request)
    {
        $user = User::find(Auth::id());
        $story = new Story();
        $story->user_id = $user->id;
        $imageStory = $request->file('story');
        $imageStory_name = $imageStory->getClientOriginalName();
        $imageStory_path = 'imageStory/' . $imageStory_name;
        $imageStory->storeAs('imageStory', $imageStory_name, 'imageStory');
        $story->image_url = $imageStory_path;
        $story->save();
        $mess = "Story create successfully";
        session()->flash('notification', $mess);
        return redirect()->route('show-story');
    }

    public function deleteTell(Request $request)
    {
        $receiver_id = Auth::id();

        $tell = Activity::where('receiver_id', $receiver_id);

        $tell->delete();

        $mess = "Notification deleted successfully";
        session()->flash('notification', $mess);

        return response()->json(['success' => true]);
    }
}
