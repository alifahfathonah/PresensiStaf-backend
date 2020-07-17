<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Attendance;
use App\Entity;

use function Geodistance\meters;
use Geodistance\Location;

class AttendanceController extends Controller
{
    public function setAttendance() {

        $now = Carbon::now();
        $now->addHours(7);
        $data = null;
        $lat = request()->lat;
        $lng = request()->lng;


        $entity = Entity::where('id', 1)->first();

        $insidePoint = new Location($lat, $lng);
        $office = new Location((float) $entity->lat, (float) $entity->lng);
        $radius = meters($insidePoint, $office);

        // if($radius < $entity->radius){
        //     // out of area
        //     // $attendance = Attendance::where("user_id", auth("api")->user()->id)
        //     $attendance = Attendance::where("user_id", 1)
        //         ->whereDate('start', $now->format('Y-m-d'))
        //         ->first();
            
        //     if($attendance){
            
        //         $start = new Carbon($attendance->start);
        //         $hours = $now->diff($start);

        //         $data = Attendance::updateOrCreate(["id" => $attendance->id], [
        //             "end" => $now,
        //             "hours" => $hours->format('%H:%I:%S'),
        //             "note_start" => 'note start',
        //             "note_end" => 'note end'
        //         ]);
        //     } else {

        //         $data = Attendance::create([
        //             // "user_id" => auth("api")->user()->id,
        //             "user_id" => 1,
        //             "start" => $now,
        //             "is_on_area" => 1,
        //             "note_start" => 'note start',
        //             "note_end" => 'note end'
        //         ]);
        //     }
        
        // } else {
        //     // out of area
        //     $data = [
        //         'msg' => 'Kamu berada diluar area!'
        //     ];
        // }
        
        return response()->json(['radius' => $radius]);
    }
}
