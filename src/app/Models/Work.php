<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Work extends Model
{
    use HasFactory;
    protected $fillable=[
        'id',
        'user_id',
        'punch_in',
        'punch_out'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rest()
    {
        return $this->hasMany(Rest::class);
    }

    public function getTodayPunchIn($userId){
        return self::where('user_id', $userId)->whereDate('punch_in', Carbon::today())->first();
    } 

    public function getTodayPunchOut($userId){
        return self::where('user_id', $userId)->whereDate('punch_out', Carbon::today())->first();
    } 

    public function getWorkingData($userId){
        return self::where('user_id', $userId)->whereNull('punch_out')->first();
    }

    protected $casts = [
    'punch_in' => 'datetime',
    'punch_out' => 'datetime'
    ];

    
    
    public function getTotalWorkTime($userId){
        $total_works = self::where('user_id', $userId)->get();
        $total_works_time = 0;
        foreach($total_works as $work){
            $work_time = Carbon::parse($work['punch_out'])->diffInMinutes(Carbon::parse($work['punch_in']));
            $total_works_time += $work_time;
        }
        $hours = floor($total_works_time / 60);
        $minutes = $total_works_time % 60;

        return sprintf('%02d:%02d', $hours, $minutes);
    }
}
