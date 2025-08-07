<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Work;
use App\Models\Rest;
use Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function stamp(){
        $user = Auth::user();
        $status="";
        $works=new Work();
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
            return redirect()->back()->with('error', 'すでに出勤打刻がされています');
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

        if( !empty($timestamp->punch_out)) {
            return redirect()->back()->with('error', '既に退勤の打刻がされているか、出勤打刻されていません');
        }
        $timestamp->update([
            'punch_out' => Carbon::now()
        ]);

        return redirect()->back();
    }


    public function restIn(){
        $work= Work::where('id',1)->latest()->get();
        $timestamp = Rest::where('work_id', $work->id)->latest()->first();

        $timestamp = Rest::create([
            'work_id' => $work->id,
            'rest_in' => Carbon::now()
        ]);
        return redirect()->back();
    }

    public function restOut(){
        $work= Work::where('id')->get();
        $timestamp = Rest::where('work_id', $work->id)->latest()->first();

        $timestamp->update([
            'rest_out' => Carbon::now()
        ]);

        return redirect()->back();
    }


    public function list(){
        return view('list');
    }

    public function application(){
        return view('application');
    }
}
