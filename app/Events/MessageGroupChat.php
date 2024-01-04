<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class MessageGroupChat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $avatar;

    public $name;
    public $user_id;
    public $message;
    public $room_id;

    public $create_at;
    public $image;
    public function __construct($avatar, $name, $user_id, $message, $room_id, $create_at, $image)
    {
        $this->avatar = $avatar;
        $this->name = $name;
        $this->message = $message;
        $this->room_id = $room_id;
        $this->user_id = $user_id;
        $this->create_at = $create_at;
        $this->image = $image;
    }

    public function broadcastOn()
    {
        return new Channel('chatGroup.' . $this->room_id);
    }
}

