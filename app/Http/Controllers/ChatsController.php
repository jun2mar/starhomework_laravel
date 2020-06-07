<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Events\Messages\MessageEvent;


class ChatsController extends Controller
{
    public function __construct(){
        // $this->middleware('auth');
    }

    public function index(){
        return view('chats');
    }

    public function fetchMessages(){
        return Message::with('user')->get();
    }

    public function sendMessage(Request $request){
        $current_loggedin = \Auth::user()->id;
        return $current_loggedin;
        $message = auth()->user()->messages()->create([
            'message' => $request->message
        ]);
        broadcast(new MessageEvent($message->load('user')));
        return ['status' => 'success'];
    }
}
