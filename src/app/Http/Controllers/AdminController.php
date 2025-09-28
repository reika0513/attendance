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


class AdminController extends Controller
{
        public function list(){
        $date = Carbon::today();
        $dates = $date->format('Y/m/d');
        $ja_dates = $date->format('Y年m月d日');

        $works = Work::all();

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

        return view('admin_list', compact('dates','ja_dates', 'works','rests', 'totals', 'pages'));
    }

    public function detail($work_id){
        $work = Work::findOrFail($work_id);
        $rests = $work->rest;
        
        return view('admin_detail', ['user' => $work->user, 'work'=>$work, 'rests'=>$rests]);
    }


    public function postCorrection(CorrectionRequest $request, $work_id){
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

        return redirect('/admin/attendance/list');
        
    }
    

    public function applicationList(Request $request){
        $tab = $request->get('tab', 'wait'); 

        $status = $tab === 'finish' 
            ? Correction::STATUS_APPROVED 
            : Correction::STATUS_PENDING;

        $corrections = Correction::where('status', $status)
        ->with(['work', 'user']) 
        ->get();

        return view('admin_application_list', compact('corrections', 'tab'));
        
    }

    public function getApprovalDetail($correction_id){
        $correction = Correction::with(['user', 'work'])->findOrFail($correction_id);
        
        return view('approval', [
        'correction' => $correction,
        'user'       => $correction->user ?? $correction->work->user,
        'work'       => $correction->work,
        'status'     => $correction->status,
        ]);
    }

    public function approveCorrection($id)
    {
        $correction = Correction::findOrFail($id);
        $work = Work::findOrFail($correction->work_id);

        $work->update([
        'punch_in'  => $correction->punch_in ?? $work->punch_in,
        'punch_out' => $correction->punch_out ?? $work->punch_out,
        'remark'    => $correction->remark ?? $work->remark,
        ]);

        if (!empty($correction->rests)) {
        foreach ($correction->rests as $restData) {
            if (!empty($restData['rest_id'])) {
                $rest = Rest::find($restData['rest_id']);
                if ($rest) {
                    $rest->update([
                        'rest_in'  => $restData['rest_in'] ?? $rest->rest_in,
                        'rest_out' => $restData['rest_out'] ?? $rest->rest_out,
                    ]);
                }
            }else {
                if (!empty($restData['rest_in']) || !empty($restData['rest_out'])) {
                    Rest::create([
                        'work_id'  => $work->id,
                        'rest_in'  => $restData['rest_in'],
                        'rest_out' => $restData['rest_out'],
                    ]);
                    }
                }
            }
        }

        $correction->update(['status' => Correction::STATUS_APPROVED]);

        return redirect('/admin/attendance/list')->with('message', '修正申請を承認しました');
    }

}
