<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveStaf extends Model
{
    protected $table = 'leave_staf';

    public function Users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function Periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }
}
