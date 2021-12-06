<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function send(Request $request)
    {
        $invitation = new Invitation();
        $invitation->user_id = $request->user_id;
        $invitation->invited_id = $request->invited_id;
        $invitation->save();
    }

    public function accept(Request $request)
    {
        Invitation::where("user_id", $request->user_id)->where("invited_id", $request->invited_id)->update(["status" => "accepted"]);    
    }

    public function matches($id)
    {
        $user = User::findOrFail($id);
        return $user->invitations()->where("status", "pending")->get();
    }

    public function incoming($id)
    {
        return Invitation::where("invited_id", $id)->where("status", "pending")->get();
    }

    public function accepted_matches($id)
    {
        $matches = [];
        $a = Invitation::where("user_id", $id)->where("status", "accepted")->get();
        $b = Invitation::where("invited_id", $id)->where("status", "accepted")->get();
        foreach ($a as $elem)
        {
            array_push($matches, $elem);
        }
        foreach ($b as $elem)
        {
            array_push($matches, $elem);
        }
        return $matches;
    }

}
