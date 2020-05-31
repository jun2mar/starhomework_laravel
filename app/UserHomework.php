<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserHomework extends Model
{
    protected $fillable = [
        'hw_title',
        'fk_users_id',
        'fk_subject_id',
        'hw_files',
        'hw_details',
        'hw_number_teacher',
        'hw_price',
        'hw_deadline',
        'hw_expirydate',
        'hw_status',
    ];










}
