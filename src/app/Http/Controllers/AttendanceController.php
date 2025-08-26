<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Work;
use App\Models\Rest;
use Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AttendanceController extends Controller
{
    public function stamp(){
        $user = Auth::user();
        $status="";
        $works=new Work();
        $rests=new Rest();
        $today_punch_in=$works->getTodayPunchIn($user->id);
        if($today_punch_in==null){
            $status="勤務外";
        }else{
            $status="出勤中";
        }
        $today_punch_out=$works->getTodayPunchOut($user->id);
        if($today_punch_out!=null){
            $status="退勤済";
        }
        $today_rest_in=$rests->getTodayRestIn($rests->id);
        $today_rest_out=$rests->getTodayRestOut($rests->id);
        if($today_rest_in!=null && $today_rest_out==null){
            $status="休憩中";
        }
        return view('stamp')->with('status', $status);
    
    }

    public function punchIn()
    {
        $user = Auth::user();
        $oldTimestamp = Work::where('user_id', $user->id)->latest()->first();

        if ($oldTimestamp) {
            $oldTimestampPunchIn = new Carbon($oldTimestamp->punch_in);
            $oldTimestamp = $oldTimestampPunchIn->startOfDay();
        }
        
        $newTimestampDay = Carbon::today();

        if (($oldTimestamp == $newTimestampDay) && (empty($oldTimestamp->punch_out))){
            return redirect()->back()->with('message', 'すでに出勤打刻がされています');
        } 

        $timestamp = Work::create([
            'user_id' => $user->id,
            'punch_in' => Carbon::now()
        ]);
        return redirect()->back();
    }

    public function punchOut(){
        $user = Auth::user();
        $timestamp = Work::where('user_id', $user->id)->latest()->first();

        $timestamp->update([
            'punch_out' => Carbon::now()
        ]);

        return redirect()->back()->with('message', 'お疲れ様でした。');
    }


    public function restIn(){
        $work= new Work();
        $user = Auth::user();
        $work_data = $work->getWorkingData($user->id);

        $rest = Rest::create([
            'work_id' => $work_data->id,
            'rest_in' => Carbon::now()
        ]);
        return redirect()->back();
    }

    public function restOut(){
        $work= new Work();
        $user = Auth::user();
        $work_data = $work->getWorkingData($user->id);
        $rest = Rest::where('work_id', $work_data->id)->latest()->first();

        $rest->update([
            'rest_out' => Carbon::now()
        ]);

        return redirect()->back();
    }


    public function list(){
        $date = CarbonPeriod::create('2025-01-01', '2025-12-31')->toArray();

        $user = Auth::user();
        $works = Work::where('user_id', $user->id)->get();
        return view('list', compact('works'));
    }

    public function applicationWait(){
        return view('application_wait');
    }

    public function applicationFinish(){
        return view('application_finish');
    }
}
