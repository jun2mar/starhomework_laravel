<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Subject;
use App\UserHomework;
use App\Helpers\UserHelper;
use App\OrderInvoice;
use App\Orders;

class HomeworkController extends Controller
{
    public function getSubjectList(){
        $result = DB::table('subjects AS s')
        ->select('s.id', 's.subj_title')
        ->get();
        return $result;
    }

    public function getHomeworks(Request $request){
        $result = DB::table('user_homework AS uh')
        ->select(
            'uh.id As hw_id',
            'uh.hw_title',
            'uh.fk_users_id',
            'uh.fk_subject_id',
            'uh.hw_files',
            'uh.hw_details',
            'uh.hw_number_teacher',
            'uh.hw_price',
            'uh.hw_deadline',
            'uh.hw_expirydate',
            'uh.hw_status',
            'uh.created_at',
            'o.id AS order_id',
            'o.payment_status'
        )
        ->join('users AS u', 'u.id', 'uh.fk_users_id')
        ->leftJoin('orders AS o', 'o.project_fk_id', 'uh.id')
        ->paginate(10);

        foreach ($result as $item) {
            $item->payment_status = ($item->payment_status == null) ? 'Unpaid' : $item->payment_status;
        }

        // $request->merge(['activity' => 'Add member']);
        return $result;
    }

    public function save_homework_detail(Request $request){
        $this->validate($request,[
                'hw_title' => 'required',
                'fk_subject_id' => 'required',
                'hw_number_teacher' => 'required',
                'hw_price' => 'required',
                'hw_deadline' => 'required',
                'hw_expirydate' => 'required',
                'hw_details' => 'required',
            ],
            [
                'hw_title.required'    => 'This field is required.',
                'fk_subject_id.required'    => 'This field is required.',
                'hw_number_teacher.required' => 'This field is required.',
                'hw_price.required' => 'This field is required.',
                'hw_deadline.required' => 'This field is required.',
                'hw_expirydate.required' => 'This field is required.',
                'hw_details.required' => 'This field is required.',
            ]
        );

        $current_loggedin = \Auth::user()->id;
        if(!$request->id){
            $homework = new UserHomework;
            $homework->hw_title = $request->hw_title;
            $homework->fk_users_id = $current_loggedin;
            $homework->hw_number_teacher = $request->hw_number_teacher;
            $homework->hw_price = $request->hw_price;
            $homework->hw_deadline = $request->hw_deadline;
            $homework->hw_expirydate = $request->hw_expirydate;
            $homework->fk_subject_id = $request->fk_subject_id;
            $homework->hw_details = $request->hw_details;
            $homework->save();
        }else{
            $homework = UserHomework::find($request->id);
            $homework->hw_title = $request->hw_title;
            $homework->fk_users_id = $current_loggedin;
            $homework->hw_number_teacher = $request->hw_number_teacher;
            $homework->hw_price = $request->hw_price;
            $homework->hw_deadline = $request->hw_deadline;
            $homework->hw_expirydate = $request->hw_expirydate;
            $homework->fk_subject_id = $request->fk_subject_id;
            $homework->hw_details = $request->hw_details;
            $homework->save();
        }

        $homework->hw_expirydate = date("Y-m-d", strtotime($homework->hw_expirydate));

        $webSetting = UserHelper::webSetup();
        $hw_service_fee = $webSetting['ws_service_fee'];

        $hw_subtotal = $request->hw_price * $request->hw_number_teacher;
        $hw_subtotal_w_service_fee = $hw_subtotal * ($hw_service_fee / 100);
        $hw_total = $hw_subtotal + $hw_subtotal_w_service_fee;

        $return = collect($homework)->merge([
            'proceed' => true,
            'hw_subtotal' => number_format($hw_subtotal, 2),
            'hw_subtotal_w_service_fee' => number_format($hw_subtotal_w_service_fee, 2),
            'hw_service_fee' => $hw_service_fee . '%',
            'hw_total' => number_format($hw_total, 2),
        ]);
        return $return;
    }

    public function get_unpaid_homework_info(Request $request){
        // $homeworkInfo = UserHomework::find($request->homework_id);
        $homeworkInfo = UserHomework::find($request->homework_id);

        $isPaid = DB::table('orders')->select('payment_status')
        ->where('project_fk_id', $homeworkInfo->id)
        ->value('payment_status');

        if( (isset($isPaid) ? $isPaid : null ) == "Paid"){
            $return = $isPaid;
        }else{
            $homeworkInfo->hw_expirydate = date("Y-m-d", strtotime($homeworkInfo->hw_expirydate));

            $webSetting = UserHelper::webSetup();
            $hw_service_fee = $webSetting['ws_service_fee'];

            $hw_subtotal = $homeworkInfo->hw_price * $homeworkInfo->hw_number_teacher;
            $hw_subtotal_w_service_fee = $hw_subtotal * ($hw_service_fee / 100);
            $hw_total = $hw_subtotal + $hw_subtotal_w_service_fee;

            $return = collect($homeworkInfo)->merge([
                'proceed' => true,
                'hw_subtotal' => number_format($hw_subtotal, 2),
                'hw_subtotal_w_service_fee' => number_format($hw_subtotal_w_service_fee, 2),
                'hw_service_fee' => $hw_service_fee . '%',
                'hw_total' => number_format($hw_total, 2),
            ]);
        }

        return $return;
    }

    public function save_order_info(Request $request){
        $homework = UserHomework::find($request->fk_user_homework_id);

        $webSetting = UserHelper::webSetup();
        $hw_service_fee = $webSetting['ws_service_fee'];

        $hw_subtotal = $homework->hw_price * $homework->hw_number_teacher;

        $orders = new Orders;
        $orders->project_fk_id = $homework->id;
        $orders->total_delivery_days = $homework->hw_deadline;
        $orders->sub_total = $hw_subtotal;
        $orders->service_fee = $hw_service_fee;
        $orders->order_type = 'Homework';
        $orders->payment_status = 'Paid';
        $orders->save();
        $last_id = $orders->id;

        if($orders->id){
            $orderInvoice = new OrderInvoice;
            $orderInvoice->fk_orders_id = $last_id;
            $orderInvoice->invoice_number = 'ST-' . time();
            $orderInvoice->total_payed = $request->total_payed;
            $orderInvoice->payment_method = $request->payment_method;
            $orderInvoice->currency = $request->currency;
            $orderInvoice->status = $request->status;
            $orderInvoice->save();
        }
    }
}
