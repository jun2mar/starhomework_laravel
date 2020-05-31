<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebSetup extends Model
{
    protected $fillable = [
        'ws_title',
        'ws_info',
    ];
}
