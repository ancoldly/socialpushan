<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\Groups\GroupController;
use App\Http\Controllers\Users\ChangeInfoController;
use App\Http\Controllers\Users\MessageController;
use App\Http\Controllers\Users\UserController;
use Illuminate\Support\Facades\Route;

Route::get('register', [AuthController::class, 'showFormRegister'])->name('show-form-register')->middleware('guest');
Route::post('register', [AuthController::class, 'register'])->name('register')->middleware('guest');

Route::get('login', [AuthController::class, 'showFormLogin'])->name('show-form-login')->middleware('guest');
Route::post('login', [AuthController::class, 'login'])->name('login')->middleware('guest');

Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('')->middleware('auth')->group(function () {
    Route::get('home', [UserController::class, 'showHome'])->name('show-home');

    Route::get('changeInfo', [ChangeInfoController::class, 'showChangeInfo'])->name('show-change-info');
    Route::post('changeInfo', [ChangeInfoController::class, 'changeInfo'])->name('changeInfo');
    Route::post('changePassword', [ChangeInfoController::class, 'changePassword'])->name('changePassword');

    Route::post('editBiography', [UserController::class, 'editBiography'])->name('edit-biography');

    Route::post('editAvatar', [UserController::class, 'editAvatar'])->name('edit-avatar');
    Route::post('createPost', [UserController::class, 'createPost'])->name('create-post');
    Route::delete('deletePost', [UserController::class, 'deletePost'])->name('delete-post');
    Route::post('editPost', [UserController::class, 'editPost'])->name('edit-post');
    Route::post('createComment', [UserController::class, 'createComment'])->name('create-comment');
    Route::delete('deleteComment', [UserController::class, 'deleteComment'])->name('delete-comment');
    Route::post('EditComment', [UserController::class, 'EditComment'])->name('edit-comment');
    Route::post('createLike', [UserController::class, 'createLike'])->name('create-like');
    Route::post('createShare', [UserController::class, 'createShare'])->name('create-share');
    Route::post('editPostShare', [UserController::class, 'editPostShare'])->name('edit-post-share');

    Route::get('profile', [UserController::class, 'showProfile'])->name('show-profile');
    Route::get('profileDetails', [UserController::class, 'showProfileDetails'])->name('show-profileDetails');

    Route::get('/search', [UserController::class, 'search'])->name('search');
    Route::post('addFriend', [UserController::class, 'addFriend'])->name('addFriend');

    Route::post('acceptedFriend', [UserController::class, 'acceptedFriend'])->name('acceptedFriend');
    Route::post('deleteFriend', [UserController::class, 'deleteFriend'])->name('deleteFriend');


    Route::get('message', [MessageController::class, 'showMessage'])->name('show-message');
    Route::get('groupChat', [MessageController::class, 'showGroupChat'])->name('show-groupChat');
    Route::get('managerGroupChat', [MessageController::class, 'managerGroupChat'])->name('managerGroupChat');
    Route::get('getgroupChat', [MessageController::class, 'getgroupChat'])->name('getgroupChat');


    Route::get('messageDetails', [MessageController::class, 'messageDetails'])->name('messageDetails');
    Route::post('chatMessage', [MessageController::class, 'MessageReceived'])->name('chatMessage');
    Route::post('createGroupChat', [MessageController::class, 'createGroupChat'])->name('createGroupChat');
    Route::post('editGroupChat', [MessageController::class, 'editGroupChat'])->name('editGroupChat');

    Route::post('JoinGroupChat', [MessageController::class, 'JoinGroupChat'])->name('JoinGroupChat');
    Route::get('chatGroupDetails', [MessageController::class, 'chatGroupDetails'])->name('chatGroupDetails');
    Route::post('chatMessageGroup', [MessageController::class, 'MessageReceivedGroup'])->name('chatMessageGroup');

    Route::delete('deleteGroupChat', [MessageController::class, 'deleteGroupChat'])->name('deleteGroupChat');
    Route::delete('deleteMemberGroup', [MessageController::class, 'deleteMemberGroup'])->name('deleteMemberGroup');


    Route::get('profile.friends', [UserController::class, 'friends'])->name('profile.friends');
    Route::get('profile.images', [UserController::class, 'images'])->name('profile.images');
    Route::get('profile.friends.requests', [UserController::class, 'requests'])->name('profile.friends.requests');

    Route::get('profileDetails.friends', [UserController::class, 'Detailsfriends'])->name('profileDetails.friends');
    Route::get('profileDetails.images', [UserController::class, 'Detailsimages'])->name('profileDetails.images');

    Route::get('group', [GroupController::class, 'group'])->name('group');
    Route::get('create_Group', [GroupController::class, 'showCreateGroup'])->name('create_Group');
    Route::post('createGroup', [GroupController::class, 'createGroup'])->name('createGroup');
    Route::post('JoinGroup', [GroupController::class, 'JoinGroup'])->name('JoinGroup');
    Route::get('groupDetails', [GroupController::class, 'groupDetails'])->name('groupDetails');
    Route::post('createPostGroup', [GroupController::class, 'createPostGroup'])->name('createPostGroup');
    Route::delete('deleteUserGroup', [GroupController::class, 'deleteUserGroup'])->name('deleteUserGroup');
    Route::delete('deleteGroup', [GroupController::class, 'deleteGroup'])->name('deleteGroup');
    Route::get('getgroup', [GroupController::class, 'getgroup'])->name('getgroup');
    Route::post('editGroup', [GroupController::class, 'editGroup'])->name('editGroup');

    Route::get('group.discover', [GroupController::class, 'discover'])->name('group.discover');
    Route::get('group.yourGroup', [GroupController::class, 'yourGroup'])->name('group.yourGroup');

    Route::delete('deleteTell', [UserController::class, 'deleteTell'])->name('deleteTell');

    Route::get('stories', [UserController::class, 'showStory'])->name('show-story');
    Route::post('createStory', [UserController::class, 'createStory'])->name('create-story');
    Route::delete('deleteStory/{id}', [UserController::class, 'deleteStory'])->name('delete-story');
});

Route::get('/verify', [VerificationController::class, 'showVerifyForm'])->name('showVerifyForm');
Route::post('/verify', [VerificationController::class, 'verify'])->name('verify');
Route::post('/verify/request-new-code', [VerificationController::class, 'requestNewCode'])->name('create-new-code');


Route::get('/forgotten_password', [VerificationController::class, 'forgotten_password'])->name('forgotten_password');
Route::get('/verify_password', [VerificationController::class, 'showVerifyPasswordForm'])->name('showVerifyPasswordForm');
Route::post('/verify_password', [VerificationController::class, 'verify_password'])->name('verify_password');

Route::get('/reset_password', [VerificationController::class, 'showReset_password'])->name('showReset_password');
Route::post('/reset_password', [VerificationController::class, 'reset_password'])->name('reset_password');


Route::prefix('admin')->middleware(['auth', 'checkadmin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.home');
    Route::get('/showUser', [AdminController::class, 'showUser'])->name('admin.showUser');
    Route::delete('/deleteUser/{user}', [AdminController::class, 'adminDeleteUser']);
    Route::delete('/deletePost/{post}', [AdminController::class, 'adminDeletePost']);
    Route::get('/unverifiedUsers', [AdminController::class, 'unverifiedUsers'])->name('admin.unverifiedUsers');
    Route::get('/showPost', [AdminController::class, 'showPost'])->name('admin.showPost');
    Route::get('/showDetailPost', [AdminController::class, 'showDetailPost'])->name('admin.showDetailPost');
    Route::get('showPostDetail', [AdminController::class, 'showPostDetail'])->name('admin.showPostDetail');
});


Route::get('/lang/{locale}', [LanguageController::class, 'changeLocale'])->name('changeLocale');
