<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Attendance;
use App\Entity;
use App\Days;
use App\Schedule;
use App\UsersDetail;

use function App\Helpers\meters;
use App\Helpers\Location;

use JWTAuth;

class AttendanceController extends Controller
{
    public function getStateForToday() {
        $now = Carbon::now();
        $now->addHours(7);

        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $attendToday = Attendance::where("user_id", $user->id)->whereDate('start', $now->format('Y-m-d'))->get();

        if(count($attendToday) > 0) {
            $data = $attendToday->map(function($item) {
                $start = Carbon::parse($item->start);
                $end = Carbon::parse($item->end);
                $item->start = $item->start != null ? $start->format('H:i') : null;
                $item->end = $item->end != null ? $end->format('H:i') : null;
                return $item;
              });
            return response()->json($data);
        } else {
            return response()->json(['msg' => 'Has no record!']);
        }
    }

    public function getSchedule() {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        $now = Carbon::now();

        $getDays = Days::where('name_day', $now->format('l'))->first();

        $schedule = Schedule::where('users_id', $user->id)->where('days_id', $getDays->id)->with(['Days','Users'])->first();

        $data = (array) $schedule;
        if($data){
            return response()->json($schedule);
        } else {
            return response()->json(['msg' => 'Has no record schedule!']);
        }
    }

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

        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        
        if($radius < $entity->radius){
            // out of area
            $attendance = Attendance::where("user_id", $user->id)
            // $attendance = Attendance::where("user_id", 1)
            ->whereDate('start', $now->format('Y-m-d'))
            ->first();

            if($attendance){
            
                $start = new Carbon($attendance->start);
                $hours = $now->diff($start);

                $getData = Attendance::updateOrCreate(["id" => $attendance->id], [
                    "end" => $now,
                    "hours" => $hours->format('%H:%I:%S'),
                    "note_start" => 'note start',
                    "note_end" => 'note end'
                ]);

                $end = Carbon::parse($getData->end);

                $data = [
                    "start" => $getData->start,
                    "end" => $end->format('H:i'),
                    "hours" => $hours->format('%H:%I:%S'),
                    "note_start" => 'note start',
                    "note_end" => 'note end'
                ];

            } else {

                $getData = Attendance::create([
                    "user_id" => $user->id,
                    // "user_id" => 1,
                    "start" => $now,
                    "is_on_area" => 1,
                    "note_start" => 'note start',
                    "note_end" => 'note end'
                ]);

                $start = Carbon::parse($getData->start);

                $data = [
                    "user_id" => $user->id,
                    // "user_id" => 1,
                    "start" => $now->format('H:i'),
                    "is_on_area" => 1,
                    "note_start" => 'note start',
                    "note_end" => 'note end'
                ];
            }
        
        } else {
            // out of area
            $data = [
                'msg' => 'Kamu berada diluar area!'
            ];
        }
        
        return response()->json($data);
    }

    public function setAttendanceWithFace() {

        $now = Carbon::now();
        $now->addHours(7);
        $data = null;
        $lat = request()->lat;
        $lng = request()->lng;


        $entity = Entity::where('id', 1)->first();

        $insidePoint = new Location($lat, $lng);
        $office = new Location((float) $entity->lat, (float) $entity->lng);
        $radius = meters($insidePoint, $office);

        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $userDetail = UsersDetail::where('users_id', $user->id)->first();

        if($radius < $entity->radius){
            $data = [
                'status' => 200,
                'in_area' => true
            ];
        } else {
            // out of area
            $data = [
                'msg' => 'Kamu berada diluar area!'
            ];
        }

        if(request()->foto){
            $nama_file = $user->id.'.jpg';
            $tujuan_upload = 'foto/employee_temp/';

            if(file_exists($tujuan_upload . $nama_file)) {
                unlink(public_path($tujuan_upload . $nama_file));
            }

            $image = request("foto");
            $image = base64_decode($image);
            $file = public_path($tujuan_upload . $nama_file);
            file_put_contents($file, $image);
            
           
            return response()->json([
                'img_1' => $tujuan_upload . $nama_file,
                'img_2' => 'foto/employee/' . $userDetail->foto
            ]);
        }
        
        return response()->json($data);
    }
    
}
