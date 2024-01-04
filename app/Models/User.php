<?php

namespace App\Models;

use App\Models\Message;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword;

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function friendships()
    {
        return $this->hasMany(Friendship::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function messagesWith(User $user)
    {
        return $this->hasMany(Message::class, 'sender_id')
            ->where('receiver_id', $user->id)
            ->orWhere(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->where('receiver_id', $this->id);
            })
            ->latest('created_at');
    }

    public function groups()
    {
        return $this->belongsToMany(ChatGroup::class, 'group_members', 'user_id', 'group_id');
    }

    public function messages()
    {
        return $this->hasMany(GroupMessage::class, 'user_id');
    }

    public function groupMembers()
    {
        return $this->hasMany(GroupMember::class, 'user_id');
    }

    public function groupUsers()
    {
        return $this->hasMany(GroupUser::class, 'user_id');
    }

    public function acceptedFriends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
            ->where(function ($query) {
                $query->where('friendships.status', 'accepted')
                    ->where('friendships.user_id', $this->id);
            })
            ->orWhere(function ($query) {
                $query->where('friendships.status', 'accepted')
                    ->where('friendships.friend_id', $this->id);
            });
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function Friends()
    {
        return $this->hasMany(Friendship::class, 'user_id')->where('status', 'accepted');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'remember_token',
        'birth',
        'gender',
        'avatar',
        'address',
        'telephone',
        'biography',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
