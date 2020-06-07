<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderMessages extends Model
{
    protected $fillable = [
        'fk_users_id',
        'fk_order_assigns_id',
        'message',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
