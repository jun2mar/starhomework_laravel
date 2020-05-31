<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderInvoice extends Model
{
    protected $fillable = [
        'invoice_number',
        'total_payment',
        'payment_method',
        'total_payed',
        'currency',
        'status',
    ];
}
