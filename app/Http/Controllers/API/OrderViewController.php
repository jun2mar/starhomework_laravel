<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Orders;
use DB;
use App\OrderMessages;
use App\Events\OrderMessageEvent;

class OrderViewController extends Controller
{
    public function get_order_main(Request $request){
        $query = DB::table('orders AS o')
        ->select(
            'o.id',
            'o.project_fk_id',
            'o.total_delivery_days',
            'o.sub_total',
            'o.service_fee',
            'o.order_type',
            'o.payment_status',
            'o.created_at',
            'oa.id AS order_assign_id',
            'u.firstname',
            'u.lastname'
        )
        ->join('order_assigns AS oa', 'oa.fk_orders_id', 'o.id')
        ->join('users AS u', 'u.id', 'oa.fk_users_id')
        ->where('o.id', $request->orderId);
        $query = $query->get();

        foreach ($query as $item) {
            $item->fullname = $item->firstname . ' ' . $item->lastname;
        }
        return $query;
    }
    

    public function get_order_messages(Request $request){
        $query = DB::table('order_messages AS om')
        ->select(
            'om.id',
            'om.fk_order_assigns_id',
            'om.fk_users_id',
            'om.message',
            'om.created_at',
            'u.firstname',
            'u.lastname'
        )
        ->join('users AS u', 'u.id', 'om.fk_users_id')
        ->where('om.fk_order_assigns_id', $request->order_assign_id);
        $query = $query->get();

        foreach ($query as $item) {
            $item->fullname = $item->firstname . ' ' . $item->lastname;
        }

        return $query;
    }

    public function send_order_message(Request $request){
        $current_loggedin = \Auth::user()->id;
        $message = new OrderMessages;
        $message->fk_users_id = $current_loggedin;
        $message->fk_order_assigns_id = $request->order_assign_id;
        $message->message = $request->message;
        $message->save();

        broadcast(new OrderMessageEvent($message));
    }


}
