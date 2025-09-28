<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Work;
use App\Models\Rest;
use App\Models\Correction;
use Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Http\Requests\CorrectionRequest;

class AttendanceController extends Controller
{
    public function stamp(){
        $user = Auth::user();
        $status="";
        $works = new Work();
        $rests = new Rest();

        $today_punch_in=$works->getTodayPunchIn($user->id);
        if($today_punch_in==null){
            $status="勤務外";
        }else{
            $status="出勤中";
        
            $today_punch_out=$works->getTodayPunchOut($user->id);
            if($today_punch_out!=null){
                $status="退勤済";
            }
            $today_rest = $rests->getTodayRest($today_punch_in->id);
            if ($today_rest && $today_rest->rest_in && !$today_rest->rest_out) {
            $status = "休憩中";
            }
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

        $correction = Correction::where('work_id', $work->id)
        ->where('user_id', $user->id)
        ->latest()
        ->first();
        $status = $correction ? $correction->status : null;

        return view('detail', compact('user', 'work', 'rests', 'status'));
    }

    public function postCorrection(CorrectionRequest $request, $work_id){
        $user = Auth::user();
        $work = Work::where('user_id', $user->id)->findOrFail($work_id);
        $corrections = [];
        $work_date = $work->punch_in->format('Y-m-d');

        $rests = [];
        if ($request->has('rests')) {
            foreach ($request->rests as $restId => $restData) {
                $rests[] = [
                'rest_id'  => $restId,
                'rest_in'  => $restData['rest_in'] ? Carbon::parse($work_date.' '.$restData['rest_in'] ) : null,
                'rest_out' => $restData['rest_out'] ? Carbon::parse($work_date.' '.$restData['rest_out']) : null,
            ];
            }
        }

        if (!empty($request->new_rest['rest_in']) || !empty($request->new_rest['rest_out'])) {
            $rests[] = [
                'rest_id'  => null,
                'rest_in'  => Carbon::parse($work_date.' '.$request->new_rest['rest_in']),
                'rest_out' => Carbon::parse($work_date.' '.$request->new_rest['rest_out']),
            ];
        }

        Correction::create([
            'user_id'   => $user->id,
            'work_id'   => $work->id,
            'punch_in'  => $request->punch_in ? Carbon::parse($work_date.' '.$request->punch_in) : $work->punch_in,
            'punch_out' => $request->punch_out ? Carbon::parse($work_date.' '.$request->punch_out) : $work->punch_out,
            'remark'    => $request->remark,
            'rests'     => $rests,
            'status'    => 0,
        ]);

        return redirect('/attendance/list');

    }

    public function applicationList(Request $request){
        $user = Auth::user();
        $tab = $request->get('tab', 'wait'); 

        $status = $tab === 'finish' 
            ? Correction::STATUS_APPROVED 
            : Correction::STATUS_PENDING;

        $corrections = Correction::where('user_id', $user->id)
            ->where('status', $status)
            ->with('work') 
            ->get();

        return view('application_list', compact('corrections', 'tab'));
        
    }
}
