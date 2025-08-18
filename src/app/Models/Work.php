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
    
}
