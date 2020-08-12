<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersDetail extends Model
{
    protected $table = 'users_detail';
    
    public function Users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
