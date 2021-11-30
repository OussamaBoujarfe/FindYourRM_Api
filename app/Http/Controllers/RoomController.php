<?php

namespace App\Http\Controllers;

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
        $room->owner_id = $id;
        $room->country = $request->country;
        $room->city = $request->city;
        $room->number_of_rooms = $request->number_of_rooms;
        $preferences = [];
        array_push($preferences, $request->preferenced_gender);
        array_push($preferences, $request->preferenced_agerange);
        $room->preferences = $preferences;
        
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
}
