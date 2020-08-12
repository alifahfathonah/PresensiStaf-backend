<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedule';

    public function Days()
    {
        return $this->belongsTo(Days::class, 'days_id');
    }

    public function Users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
