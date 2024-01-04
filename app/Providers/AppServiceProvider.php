<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer(['users.home', 'users.profile', 'users.profile_friend', 'users.profile_friend_requests', 'users.profile_image', 'users.header', 'users.changeInfo', 'users.message', 'groups.group', 'groups.create_Group', 'groups.groupDetails'], function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $view->with('user', $user);
                $avatar_temp = "/image/user.png";
                $view->with("avatar_temp", $avatar_temp);
            }
        });
    }

}
