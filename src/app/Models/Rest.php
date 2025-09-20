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

    protected $casts = [
    'rest_in' => 'datetime',
    'rest_out' => 'datetime'
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
