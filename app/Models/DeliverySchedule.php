<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliverySchedule extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'delivery_date',
        'number_of_portion',
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }

}
