<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class UserController extends Controller
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

    public function setup(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->type == "user")
        {
            $user->gender = $request->gender;
            $user->birthday = Carbon::parse($request->birthday)->format("Y-d-m");
            $user->passions = $request->passions;
            $user->country = $request->country;
            $user->city = $request->city;
            $user->max_rent = $request->max_rent;
            $preferences = [];
            array_push($preferences, $request->preferenced_gender);
            array_push($preferences, $request->preferenced_agerange);
            $user->preferences = $preferences;
            
            $user->save();
        }
        elseif ($user->type == "owner")
        {
            $user->gender = $request->gender;
            $user->birthday = Carbon::parse($request->birthday)->format("Y-d-m");
            $preferences = [];
            array_push($preferences, $request->preferenced_gender);
            array_push($preferences, $request->preferenced_agerange);
            $user->preferences = $preferences;

            $user->save();
        }
        else
        {
            return response()->json(['bad_request' => 'bad_request'], 400);
        }
        return response()->json(['user' => $user], 200);
    }

    public function all()
    {
        return User::all();
    }


}
