<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paycheck extends Model
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
        'net_amount',
        'payed_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'payed_at' => 'timestamp',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
