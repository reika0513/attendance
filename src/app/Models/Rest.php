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

    public function getTodayRestIn($workId){
        return self::where('work_id', $workId)->whereDate('rest_in', Carbon::today())->first();
    }

    public function getTodayRestOut($workId){
        return self::where('work_id', $workId)->whereDate('rest_out', Carbon::today())->first();
    }

    
}
