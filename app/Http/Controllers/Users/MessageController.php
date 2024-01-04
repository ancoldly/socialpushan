<?php

namespace App\Http\Controllers\Users;

use App\Events\MessageGroupChat;
use App\Http\Controllers\Controller;
use App\Events\MessageSend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ChatGroup;
use App\Models\GroupMember;
use App\Models\GroupMessage;
use App\Models\Comment;
use App\Models\Friendship;
use App\Models\Activity;
use App\Models\Like;
use App\Models\Post;
use App\Models\Share;
use App\Models\Message;
use DateTime;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    public function showMessage()
    {
        $user = User::find(Auth::id());

        $firstJoinedGroup = $user->groups()->orderBy('group_members.created_at', 'asc')->first();

        $friends = Friendship::all();

        $userActivities = Activity::where('receiver_id', Auth::id())->get();

        return view("users.message", compact("friends", 'firstJoinedGroup', 'userActivities'));
    }

    public function showGroupChat()
    {

        $user = User::find(Auth::id());

        $friends = Friendship::all();

        $groupChats = ChatGroup::all();

        $groupMembers = GroupMember::all();

        $userActivities = Activity::where('receiver_id', Auth::id())->get();

        $firstJoinedGroup = $user->groups()->orderBy('group_members.created_at', 'asc')->first();

        return view("pages.groupChat", compact("friends", 'groupChats', 'groupMembers', 'firstJoinedGroup', 'userActivities'));
    }

    public function managerGroupChat()
    {
        $friends = Friendship::all();

        $user = User::find(Auth::id());

        $firstJoinedGroup = $user->groups()->orderBy('group_members.created_at', 'asc')->first();

        $groupChats = ChatGroup::where('created_by', Auth::user()->id)->get();

        $userActivities = Activity::where('receiver_id', Auth::id())->get();

        return view("pages.managergroupChat", compact("friends", 'groupChats', 'firstJoinedGroup', 'userActivities'));
    }

    public function createGroupChat(Request $request)
    {
        $chatGroup = new ChatGroup();

        $chatGroup->group_name = $request->nameGroup;
        $chatGroup->created_by = Auth::user()->id;
        $chatGroup->room_id = Str::random(10);;

        if ($request->hasFile('imageGroup')) {
            $imageGroup = $request->file('imageGroup');
            $imageGroup_name = $imageGroup->getClientOriginalName();
            $imageGroup_path = 'avatarGroupChat/' . $imageGroup_name;

            $imageGroup->storeAs('avatarGroupChat', $imageGroup_name, 'avatarGroupChat');

            $chatGroup->avatar = $imageGroup_path;
            $chatGroup->save();
        }

        $groupMember = new GroupMember();
        $groupMember->group_id = $chatGroup->id;
        $groupMember->user_id = Auth::user()->id;
        $groupMember->save();

        $mess = "Chat group created successfully";
        session()->flash('notification', $mess);

        return response()->json(['success' => true]);
    }

    public function JoinGroupChat(Request $request)
    {
        $groupChat = ChatGroup::where('room_id', $request->room_id)->first();

        $existingMember = GroupMember::where('group_id', $groupChat->id)
            ->where('user_id', Auth::user()->id)
            ->first();

        if (!$existingMember) {
            $groupMember = new GroupMember();
            $groupMember->group_id = $groupChat->id;
            $groupMember->user_id = Auth::user()->id;
            $groupMember->save();

            $mess = "Join group chat successfully";
            session()->flash('notification', $mess);

            return response()->json(['success' => true]);
        } else {
            $mess = "You are already a member of this group";
            session()->flash('error', $mess);

            return response()->json(['success' => true]);
        }
    }



    public function messageDetails(Request $request)
    {
        $user = User::find(Auth::id());

        $firstJoinedGroup = $user->groups()->orderBy('group_members.created_at', 'asc')->first();

        $friends = Friendship::all();

        $roomId = $request->input("roomId");

        $friendship = Friendship::where('room_id', $roomId)->first();

        $friend = $friendship->user_id == Auth::id() ? $friendship->friend : $friendship->user;

        $friendId = $friend->id;

        $userActivities = Activity::where('receiver_id', Auth::id())->get();

        $messages = Message::where(function ($query) use ($friendId) {
            $query->where('sender_id', Auth::id())->where('receiver_id', $friendId);
        })->orWhere(function ($query) use ($friendId) {
            $query->where('sender_id', $friendId)->where('receiver_id', Auth::id());
        })->get();

        return view('users.message', compact('messages', 'friends', 'friend', 'roomId', 'firstJoinedGroup', 'friendship', 'userActivities'));
    }

    public function chatGroupDetails(Request $request)
    {
        $user = User::find(Auth::id());

        $firstJoinedGroup = $user->groups()->orderBy('group_members.created_at', 'asc')->first();

        $friends = Friendship::all();

        $groupMembers = GroupMember::all();

        $roomId = $request->input("room_id");

        $chatGroups = ChatGroup::where("room_id", $roomId)->first();

        $allMembers = GroupMember::where("group_id", $chatGroups->id)->get();

        $groupMessages = GroupMessage::where('group_id', $chatGroups->id)
            ->orderBy('created_at', 'asc')
            ->get();

        $userActivities = Activity::where('receiver_id', Auth::id())->get();

        return view('pages.groupChat', compact('friends', 'groupMembers', 'roomId', 'chatGroups', 'groupMessages', 'firstJoinedGroup', 'allMembers', 'userActivities'));
    }

    public function MessageReceived(Request $request)
    {
        $user = User::find(Auth::id());

        $message = new Message();
        $message->content = $request->message;
        $message->sender_id = Auth::user()->id;
        $message->receiver_id = $request->receiver_id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            $image_path = '/imageChat/' . $image_name;
            $image->storeAs('imageChat', $image_name, 'imageChat');
            $message->image = $image_path;
        }

        if ($message->save()) {
            $avatar = $user->avatar;
            event(new MessageSend($avatar, $user->name, $message->content, $request->room_id, $message->created_at->toIso8601String(), $message->image));
        }

        return response()->json(['success' => true]);
    }


    public function MessageReceivedGroup(Request $request)
    {
        $user = User::find(Auth::id());

        $message = new GroupMessage();
        $message->group_id = $request->group_id;
        $message->content = $request->message;
        $message->user_id = Auth::user()->id;

        $avatar = $user->avatar;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            $image_path = '/imageChat/' . $image_name;
            $image->storeAs('imageChat', $image_name, 'imageChat');
            $message->image = $image_path;
        }

        if ($message->save()) {
            event(new MessageGroupChat($avatar, $user->name, $user->id, $message->content, $request->room_id, $message->created_at->toIso8601String(), $message->image));
        }

        return response()->json(['success' => true]);
    }

    public function deleteGroupChat(Request $request)
    {
        $group_id = $request->group_id;

        $group = ChatGroup::find($group_id);

        if ($group) {
            if ($group->avatar && Storage::disk('avatarGroupChat')->exists($group->avatar)) {
                Storage::disk('avatarGroupChat')->delete($group->avatar);
            }
            $group->delete();
            $mess = "Group chat deletion successful!";
            session()->flash('notification', $mess);
            return response()->json(['success' => true]);
        }
    }

    public function deleteMemberGroup(Request $request)
    {
        $member_id = $request->member_id;

        $member = GroupMember::find($member_id);

        if ($member) {
            if ($request->action == 'out') {
                $mess = "Out group successful!";
            } else {
                $mess = "Member deletion successful!";
            }
            $member->delete();
            session()->flash('notification', $mess);
            return response()->json(['success' => true]);
        }
    }

    public function getgroupChat(Request $request)
    {
        $group_id = $request->group_id;

        $group = ChatGroup::find($group_id);

        if ($group) {
            return response()->json(['success' => true, 'avatar' => $group->avatar, 'group_name' => $group->group_name, 'group_id' => $group->id]);
        }
    }

    public function editGroupChat(Request $request)
    {
        $group_id = $request->group_id;

        $chatGroup = ChatGroup::find($group_id);

        if ($request->hasFile('imageGroupEdit')) {
            $imageGroup = $request->file('imageGroupEdit');
            $imageGroup_name = $imageGroup->getClientOriginalName();
            $imageGroup_path = 'avatarGroupChat/' . $imageGroup_name;

            $imageGroup->storeAs('avatarGroupChat', $imageGroup_name, 'avatarGroupChat');

            if (!empty($imageGroup)) {
                Storage::disk('avatarGroupChat')->delete($chatGroup->avatar);
            }

            $chatGroup->avatar = $imageGroup_path;
        }

        $chatGroup->group_name = $request->group_name;
        $chatGroup->save();

        $mess = "Group chat edit successful!";
        session()->flash('notification', $mess);

        return response()->json(['success' => true]);
    }
}
