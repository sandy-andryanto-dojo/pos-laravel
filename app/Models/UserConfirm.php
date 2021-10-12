<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Relations 
use App\Models\User;

class UserConfirm extends Model{

    protected $guarded = [];
    protected $table = 'users_confirm';
    protected $fillable = [
        'user_id',
        'token'
    ];

    public function User() {
        return $this->belongsTo(User::class, 'user_id');
    }

}

