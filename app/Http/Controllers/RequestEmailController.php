<?php

namespace App\Http\Controllers;

use App\Mail\RequestMail;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RequestEmailController extends Controller
{
    public function send(Request $request)
    {
            // dd($request->user_name, $request->user_email);
            $user = User::findOrFail($request->user_id);
            $owner = User::findOrFail($request->owner_id);
            $room = Room::findOrFail($request->room_id);
            Mail::to($owner->email)->send(new RequestMail($user, $room));
            return  new RequestMail($user, $room);
    }
}
