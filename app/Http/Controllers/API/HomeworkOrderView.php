<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeworkOrderView extends Controller
{
    public function get_order_timer(Request $request){
        $EndDate = '2020-06-01 12:00:00';
        $return = collect(
            [
                "StartTime" => date("Y-m-d H:i:s"),
                "EndTime" => date("Y-m-d H:i:s", strtotime($EndDate)),
            ]
        );
        return $return;
    }
}
