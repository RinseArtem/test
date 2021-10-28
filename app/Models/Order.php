<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'phone',
        'title'	,
        'delivery_start',
        'delivery_end',
        'delivery_type',
        'comment'
    ];

    protected $dates = [
        'delivery_start',
        'delivery_end',
    ];

    public function schedules() {
        return $this->hasMany(DeliverySchedule::class);
    }
}
