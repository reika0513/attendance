<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Timestamp;
use Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function stamp(){
        return view('stamp');
    }

    public function punchIn()
    {
        $user = Auth::user();
        $oldTimestamp = Timestamp::where('user_id', $user->id)->latest()->first();

        if ($oldTimestamp) {
            $oldTimestampPunchIn = new Carbon($oldTimestamp->punch_in);
            $oldTimestamp = $oldTimestampPunchIn->startOfDay();
        }
        
        $newTimestampDay = Carbon::today();

        if (($oldTimestamp == $newTimestampDay) && (empty($oldTimestamp->punch_out))){
            return redirect()->back()->with('error', 'すでに出勤打刻がされています');
        } 

        $timestamp = Timestamp::create([
            'user_id' => $user->id,
            'punch_in' => Carbon::now()
        ]);
        return redirect()->back();
    }

    public function punchOut(){
        $user = Auth::user();
        $timestamp = Timestamp::where('user_id', $user->id)->latest()->first();

        if( !empty($timestamp->punch_out)) {
            return redirect()->back()->with('error', '既に退勤の打刻がされているか、出勤打刻されていません');
        }
        $timestamp->update([
            'punch_out' => Carbon::now()
        ]);

        return redirect()->back();
    }


    public function restIn(){
        $user = Auth::user();
        $timestamp = Timestamp::where('user_id', $user->id)->latest()->first();

        $timestamp->update([
            'rest_in' => Carbon::now()
        ]);
        return redirect()->back();
    }

    public function restOut(){
        $user = Auth::user();
        $timestamp = Timestamp::where('user_id', $user->id)->latest()->first();

        $timestamp->update([
            'rest_out' => Carbon::now()
        ]);

        return redirect()->back();
    }
}
