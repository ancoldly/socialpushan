<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_name',
        'created_by',
        'room_id',
        'avatar'
    ];

    public function members()
    {
        return $this->hasMany(GroupMember::class, 'group_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
