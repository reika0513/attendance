<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Correction extends Model
{
    
    use HasFactory;
    protected $fillable=[
        'id',
        'user_id',
        'work_id',
        'rest_id',
        'punch_in',
        'punch_out',
        'rests',
        'remark',
        'status',
    ];

    protected $casts = [
        'rests' => 'array',
    ];
    
    const STATUS_PENDING  = 0;
    const STATUS_APPROVED = 1;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function work()
    {
        return $this->belongsTo(Work::class);
    }

    public function rest()
    {
        return $this->belongsTo(Rest::class);
    }
}
