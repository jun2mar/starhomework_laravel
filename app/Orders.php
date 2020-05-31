<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = [
        'project_fk_id',
        'total_delivery_days',
        'sub_total',
        'service_fee',
        'order_type	',
        'payment_status',
    ];
}
