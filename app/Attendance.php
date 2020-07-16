<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = "attendance";

    protected $fillable = [
        'user_id', 'start', 'end', 'note_start', 'note_end', 'hours', 'is_on_area'
    ];

    public function User()
    {
        return $this->belongsTo('App\User');
    }
}
