<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Comment;
use App\Models\Friendship;
use App\Models\Like;
use App\Models\Post;
use App\Models\ChatGroup;
use App\Models\Share;
use App\Models\GroupMember;
use App\Models\Activity;
use DateTime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GroupController extends Controller
{

    public function getUserData()
    {
        $user = User::find(Auth::id());
        $firstJoinedGroup = $user->groups()->orderBy('group_members.created_at', 'asc')->first();
        $acceptedFriends = Auth::user()->acceptedFriends;
        $friends = Friendship::all();
        $posts = Post::with(['user', 'likes', 'comments'])->orderBy('created_at', 'desc')->get();
        $images = Post::where('user_id', $user->id)->whereNotNull('image_url')->orderBy('created_at', 'desc')->get();
        $groupUsers = GroupUser::all();
        $allGroups = Group::inRandomOrder()->get();
        $userGroups = Group::where('created_by', Auth::user()->id)->get();
        $groups = Group::where('created_by', Auth::user()->id)->get();
        $userActivities = Activity::where('receiver_id', Auth::id())->get();

        return compact('user', 'firstJoinedGroup', 'acceptedFriends', 'friends', 'posts', 'images', 'groupUsers', 'allGroups', 'userGroups', 'groups', 'userActivities');
    }

    public function group()
    {
        if (Auth::check()) {
            $data = $this->getUserData();
            return view('groups.group', $data);
        }
    }

    public function discover()
    {
        if (Auth::check()) {
            $data = $this->getUserData();
            return view('groups.group_discover', $data);
        }
    }

    public function showCreateGroup()
    {
        if (Auth::check()) {
            $data = $this->getUserData();
            return view('groups.create_Group', $data);
        }
    }

    public function groupDetails(Request $request)
    {
        if (Auth::check()) {
            $data = $this->getUserData();
            $data['group'] = Group::find($request->idGroup);
            $data['allUsers'] = GroupUser::where("group_id", $data['group']->id)->get();
            return view('groups.groupDetails', $data);
        }
    }

    public function yourGroup()
    {
        if (Auth::check()) {
            $data = $this->getUserData();
            return view('groups.group_yourGroup', $data);
        }
    }


    public function createGroup(Request $request)
    {
        $group = new Group();

        $group->name = $request->nameGroup;
        $group->created_by = Auth::user()->id;

        if ($request->hasFile('imageGroup')) {
            $imageGroup = $request->file('imageGroup');
            $imageGroup_name = $imageGroup->getClientOriginalName();
            $imageGroup_path = 'avatarGroup/' . $imageGroup_name;
            $imageGroup->storeAs('avatarGroup', $imageGroup_name, 'avatarGroup');

            $group->avatar = $imageGroup_path;
            $group->code_group = Str::random(10);
            $group->save();
        }

        $groupMember = new GroupUser();
        $groupMember->group_id = $group->id;
        $groupMember->user_id = Auth::user()->id;
        $groupMember->save();

        $mess = "Group created successfully";
        session()->flash('notification', $mess);

        return response()->json(['success' => true]);
    }

    public function JoinGroup(Request $request)
    {
        $group = Group::where('code_group', $request->codeGroup)->first();

        $existingMember = GroupUser::where('group_id', $group->id)
            ->where('user_id', Auth::user()->id)
            ->first();

        if (!$existingMember) {
            $groupMember = new GroupUser();
            $groupMember->group_id = $group->id;
            $groupMember->user_id = Auth::user()->id;
            $groupMember->save();

            $mess = "Join group successfully";
            session()->flash('notification', $mess);

            return response()->json(['success' => true]);
        } else {
            $mess = "You are already a member of this group";
            session()->flash('error', $mess);

            return response()->json(['success' => true]);
        }
    }

    public function createPostGroup(Request $request)
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
        $post->group_id = $request->group_id;

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

    public function deleteUserGroup(Request $request)
    {
        $member_id = $request->member_id;

        $member = GroupUser::find($member_id);

        if ($member) {
            $member->delete();
            $mess = "Member deletion successful!";
            session()->flash('notification', $mess);
            return response()->json(['success' => true]);
        }
    }

    public function deleteGroup(Request $request)
    {
        $group_id = $request->group_id;

        $group = Group::find($group_id);

        if ($group) {
            if ($group->avatar && Storage::disk('avatarGroup')->exists($group->avatar)) {
                Storage::disk('avatarGroup')->delete($group->avatar);
            }
            $group->delete();
            $mess = "Group deletion successful!";
            session()->flash('notification', $mess);
            return response()->json(['success' => true]);
        }
    }

    public function getgroup(Request $request)
    {
        $group_id = $request->group_id;

        $group = Group::find($group_id);

        if ($group) {
            return response()->json(['success' => true, 'avatar' => $group->avatar, 'group_name' => $group->name, 'group_id' => $group->id]);
        }
    }

    public function editGroup(Request $request)
    {
        $group_id = $request->group_id;

        $Group = Group::find($group_id);

        if ($request->hasFile('imageGroupEdit')) {
            $imageGroup = $request->file('imageGroupEdit');
            $imageGroup_name = $imageGroup->getClientOriginalName();
            $imageGroup_path = 'avatarGroup/' . $imageGroup_name;

            $imageGroup->storeAs('avatarGroup', $imageGroup_name, 'avatarGroup');

            if (!empty($imageGroup)) {
                Storage::disk('avatarGroup')->delete($Group->avatar);
            }

            $Group->avatar = $imageGroup_path;
        }

        $Group->name = $request->group_name;
        $Group->save();

        $mess = "Group edit successful!";
        session()->flash('notification', $mess);

        return response()->json(['success' => true]);
    }
}
