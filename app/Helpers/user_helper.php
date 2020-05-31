<?php
namespace App\Helpers;

use DB;
use App\User;
use App\WebSetup;


class UserHelper
{
    public static function webSetup()
    {
        $query = WebSetup::all();
        $array = array();
        foreach ($query as $key => $item) {
            $array[0][$item->ws_title] = $item->ws_info;
        }
        return $array[0];
    }
}
