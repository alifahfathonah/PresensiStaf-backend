<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permit extends Model
{
    protected $table = "permit";
    
    public function Users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    
    public function RequestTo()
    {
        return $this->belongsTo(User::class, 'request_to');
    }
}
