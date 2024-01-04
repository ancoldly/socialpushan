<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatGroup;
use App\Models\Group;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $auth = Auth::user();
        $totalPosts = Post::count();
        $dailyPosts = $this->getDailyPosts();
        $dailyPostCounts = $this->getDailyPostCounts();

        $totalUser = User::count();
        $dailyUser = $this->getAccount();
        $dailyUserCounts = $this->getAccountCounts();

        $totalGroups = Group::count();
        $dailyGroups = $this->getDailyGroups();
        $dailyGroupCounts = $this->getDailyGroupCounts();

        $totalChatGroups = ChatGroup::count();
        $dailyChatGroups = $this->getDailyChatGroups();
        $dailyChatGroupCounts = $this->getDailyChatGroupCounts();

        return view('admin.home', compact('totalPosts', 'dailyPosts', 'dailyPostCounts', 'totalUser', 'dailyUser',
        'dailyUserCounts', 'auth', 'totalGroups', 'dailyGroups', 'dailyGroupCounts', 'totalChatGroups', 'dailyChatGroups', 'dailyChatGroupCounts'));
    }
    private function getDailyPosts()
    {
        return Post::whereDate('created_at', Carbon::today())->count();
    }
    private function getDailyPostCounts()
    {
        return Post::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->get()
            ->pluck('count', 'date');
    }

    private function getDailyGroups()
    {
        return Group::whereDate('created_at', Carbon::today())->count();
    }
    private function getDailyGroupCounts()
    {
        return Group::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->get()
            ->pluck('count', 'date');
    }

    private function getDailyChatGroups()
    {
        return ChatGroup::whereDate('created_at', Carbon::today())->count();
    }
    private function getDailyChatGroupCounts()
    {
        return ChatGroup::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->get()
            ->pluck('count', 'date');
    }
    private function getAccount()
    {
        return User::whereDate('created_at', Carbon::today())->count();
    }
    private function getAccountCounts()
    {
        return User::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->get()
            ->pluck('count', 'date');
    }

    public function showUser()
    {
        $users = User::All();
        $auth = Auth::user();
        return view('admin.showUser', compact('users', 'auth'));
    }
    public function unverifiedUsers()
    {
        $auth = Auth::user();
        $users = User::where('is_verify', null)->get();
        return view('admin.showUser', compact('users', 'auth'));
    }
    public function showPost()
    {
        $auth = Auth::user();
        $posts = Post::with(['user', 'likes', 'comments'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.showPost', compact('posts', 'auth'));
    }
    public function adminDeleteUser(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'Account deleted successfully']);
    }

    public function adminDeletePost(Post $post)
    {
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully']);
    }
    public function showDetailPost()
    {
        $postId = request('key');
        $posts = Post::with(['user', 'likes', 'comments.user'])
            ->where('id', $postId)
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json([$posts]);
    }
    public function showPostDetail()
    {
        return view('admin.postDetail');
    }
}
