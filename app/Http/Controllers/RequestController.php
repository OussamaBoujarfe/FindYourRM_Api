<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestModel;
class RequestController extends Controller
{
    public function createRequest(Request $request)
    {

        $fields = $request->all();
        $exists = RequestModel::where([
            ['receiver_id', $request->receiver_id],
            ['requester_id', $request->requester_id]
        ])->orWhere([
            ['receiver_id', $request->requester_id],
            ['requester_id', $request->receiver_id]
        ])->exists();
        
        if($exists) return response()->json("Already sent", 400);

        $request = RequestModel::create($fields);

        return 'Success';
    }

    public function getSentRequests(Request $request, $id){
        // user_id1
        // user_id2

        $requests = RequestModel::where([
            ['requester_id', $id]
        ])->get();


        return response()->json($requests, 200);
    }

    public function getReceivedRequests(Request $request, $id){

        $requests = RequestModel::where([
            ['receiver_id', $id]
        ])->get();


        return response()->json($requests, 200);
    }

    public function getPendingRequests(Request $request, $id){

        $requests = RequestModel::where([
            ['requester_id', $id],
            ['status', "pending"]
        ])->get();


        return response()->json($requests, 200);
    }

    public function getAcceptedRequests(Request $request, $id){

        $requests = RequestModel::where([
            ['requester_id', $id],
            ['status', "accepted"]
        ])->get();


        return response()->json($requests, 200);
    }

    public function getDeclinedRequests(Request $request, $id){

        $requests = RequestModel::where([
            ['requester_id', $id],
            ['status', "declined"]
        ])->get();


        return response()->json($requests, 200);
    }

    public function isRequestSent(Request $request){
        $exists = RequestModel::where([
            ['receiver_id', $request->input('user_id1')],
            ['requester_id', $request->input(('user_id2'))]
        ])->orWhere([
            ['receiver_id', $request->input('user_id2')],
            ['requester_id', $request->input(('user_id1'))]
        ])->exists();
        if($exists) return response()->json(true, 400);
        return false;
    }

    public function declineRequest(Request $request, $id){
            $requestModel = RequestModel::findOrFail($id);
            $requestModel->status = "declined";
            $requestModel->save();
            return response()->json("successfully declined", 400);    
    }

    public function acceptRequest(Request $request, $id){
        $requestModel = RequestModel::findOrFail($id);
        $requestModel->status = "accepted";
        $requestModel->save();
        return response()->json("successfully accepted", 400);  
    }


}
