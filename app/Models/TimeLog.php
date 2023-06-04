<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'employee_id',
        'started_at',
        'stopped_at',
        'minutes',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'started_at' => 'timestamp',
        'stopped_at' => 'timestamp',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
