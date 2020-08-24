<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sick extends Model
{
    protected $table = "sicks";
    
    public function Users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    
    public function RequestTo()
    {
        return $this->belongsTo(User::class, 'request_to');
    }
}
