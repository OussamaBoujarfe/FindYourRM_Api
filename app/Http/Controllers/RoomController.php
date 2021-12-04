<?php

namespace App\Http\Controllers;

use App\Mail\RequestMail;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;


class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function add(Request $request, $id)
    {
        User::findOrFail($id);

        $room = new Room();
        $room->rent = $request->rent;
        $room->user_id = $id;
        $room->country = $request->country;
        $room->city = $request->city;
        $room->number_of_rooms = $request->number_of_rooms;
        
        $room->save();

        return $room;
    }

    public function all()
    {
        return Room::all();
    }

    public function room($id)
    {
        $room = Room::findOrFail($id);
        return $room;
    }

    public function delete($id)
    {
        $room = Room::findOrFail($id);
        Room::find($id)->delete();
        return $room;
    }

    public function search(Request $request)
    {
        $rooms = Room::all()->values();
        if (!is_null($request->country))
        {
            $rooms = $rooms->where("country", $request->country)->values();
        }
        if (!is_null($request->city))
        {
            $rooms = $rooms->where("city", $request->city)->values();
        }
        if (!is_null($request->max_rent))
        {
            $rooms = $rooms->where("rent", "<=", $request->max_rent)->values();
        }
        if (!is_null($request->min_number_of_rooms))
        {
            $rooms = $rooms->where("number_of_rooms", ">=", $request->min_number_of_rooms)->values();
        }
        return $rooms;
    }
}
