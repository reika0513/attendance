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

    public function getTodayRestIn(){
        return self::where('work_id')->whereDate('rest_in', Carbon::today())->first();
    }

    public function getTodayRestOut(){
        return self::where('work_id')->whereDate('rest_out', Carbon::today())->first();
    }

    public function getTotalRestTime($workId){
        $rests = self::where('work_id', $workId)->get();
        $total_rests_time = 0;
        foreach($rests as $rest){
            $rest_time = Carbon::parse($rest['rest_out'])->diffInMinutes(Carbon::parse($rest['rest_in']));
            $total_rests_time += $rest_time;
        }
        $hours = floor($total_rests_time / 60);
        $minutes = $total_rests_time % 60;

        return sprintf('%02d:%02d', $hours, $minutes);
    }
        
}
