<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Work;
use App\Models\Rest;
use Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Http\Requests\CorrectionRequest;

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
        $today_rest_in=$rests->getTodayRestIn($works->id);
        $today_rest_out=$rests->getTodayRestOut($works->id);
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
        $date = Carbon::today();
        $dates = $date->format('Y/m');

        $user = Auth::user();
        $works = Work::where('user_id', $user->id)->get();

        $rests = [];
        foreach ($works as $work) {
            $rest_minutes = Rest::totalRestMinutes($work->id);

            $hours = floor($rest_minutes / 60);
            $minutes = $rest_minutes % 60;
            $rests[$work->id] = sprintf('%02d:%02d', $hours, $minutes);
        }

        $totals = [];
        foreach ($works as $work) {
            $work_minutes = Work::totalWorkMinutes($work->id);
            $rest_minutes = Rest::totalRestMinutes($work->id);

            $net_minutes = $work_minutes - $rest_minutes;

            $hours = floor($net_minutes / 60);
            $minutes = $net_minutes % 60;
            $totals[$work->id] = sprintf('%02d:%02d', $hours, $minutes);
        }

        $pages = Work::simplePaginate(30);

        return view('list', compact('dates','works','rests', 'totals', 'pages'));
    }

    public function detail($work_id){
        $user = Auth::user();
        $work = Work::where('user_id', $user->id)->findOrFail($work_id);
        $rests = $work->rest;
        return view('detail', compact('user', 'work', 'rests'));
    }

    public function postCorrection(CorrectionRequest $request){
        $work = Work::findOrFail($work_id);

        $work->update([
        'punch_in'  => $request->punch_in,
        'punch_out' => $request->punch_out,
        'remark'    => $request->remark,
        ]);

        if ($request->has('rests')) {
        foreach ($request->rests as $restId => $restData) {
            $rest = Rest::find($restId);
            if ($rest) {
                $rest->update([
                    'rest_in'  => $restData['rest_in'],
                    'rest_out' => $restData['rest_out'],
                ]);
            }
        }
        }

        if (!empty($request->new_rest['rest_in']) && !empty($request->new_rest['rest_out'])) {
            Rest::create([
                'work_id'  => $work->id,
                'rest_in'  => $request->new_rest['rest_in'],
                'rest_out' => $request->new_rest['rest_out'],
            ]);
        }
        dd($request->all());
        return redirect('/attendance/list')->with('success', '修正が完了しました');
        
    }

    public function applicationWait(){
        return view('application_wait');
    }

    public function applicationFinish(){
        return view('application_finish');
    }
}
