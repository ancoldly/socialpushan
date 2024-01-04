<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Friendship;
use App\Models\Activity;
use DateTime;
use Illuminate\Support\Facades\Hash;

class ChangeInfoController extends Controller
{
    public function showChangeInfo()
    {
        if (Auth::check()) {

            $user = User::find(Auth::id());

            $firstJoinedGroup = $user->groups()->orderBy('group_members.created_at', 'asc')->first();

            $friends = Friendship::all();

            $userActivities = Activity::where('receiver_id', Auth::id())->get();

            return view('users.changeInfo', compact('friends', 'firstJoinedGroup', 'userActivities'));
        }
    }

    public function changeInfo(Request $request)
    {
        $user = User::find(Auth::id());
        $user->name = $request->username;
        $user->telephone = $request->telephone;
        $user->birth = $request->birthdate;
        $user->gender = $request->gender;
        $user->address = $request->address;

        if (empty($err)) {
            $user->save();
            $mess = "Infomation edited successfully";
            session()->flash('notification', $mess);
            return response()->json(['success' => true]);
        }
    }

    public function changePassword(Request $request)
    {
        $user = User::find(Auth::id());

        $currentPassword = $request->currentPassword;

        if (!Hash::check($currentPassword, $user->password)) {
            return response()->json(['success' => false]);
        }

        $newPassword = $request->newPassword;
        $user->update(['password' => Hash::make($newPassword)]);

        $mess = "Password edited successfully";
        session()->flash('notification', $mess);

        return response()->json(['success' => true]);
    }
}
