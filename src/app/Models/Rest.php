<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Rest extends Model
{
    use HasFactory;
    protected $fillable=[
        'id',
        'work_id',
        'rest_in',
        'rest_out'
    ];

    public function work()
    {
        return $this->belongsTo(Work::class);
    }

    public function correction()
    {
        return $this->hasOne(Correction::class);
    }

    public function getTodayRest($workId){
        return self::where('work_id', $workId)->where(function ($q) {
            $q->whereDate('rest_in', Carbon::today())
              ->orWhereDate('rest_out', Carbon::today());
        })
        ->orderByDesc('id')
        ->first();
    }

    public function getTodayRestOut($workId){
        return self::where('work_id', $workId)->whereDate('rest_in', Carbon::today())->orderBy('rest_out', 'desc')->first();
    }

    protected $casts = [
        'rest_in' => 'datetime',
        'rest_out' => 'datetime',
    ];

    public function totalRestMinutes($workId){
        $rests = self::where('work_id', $workId)->get();
        $total_rests_time = 0;
        foreach($rests as $rest){
            $rest_time = Carbon::parse($rest['rest_out'])->diffInMinutes(Carbon::parse($rest['rest_in']));
            $total_rests_time += $rest_time;
        }
        return $total_rests_time;
    }
        
    
}
