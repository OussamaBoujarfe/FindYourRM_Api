<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

use function PHPSTORM_META\type;

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

            $user->birthday = Carbon::createFromFormat('Y-m-d', $request->birthday)->format("Y-m-d");
            $user->passions = $request->passions;
            $user->country = $request->country;
            $user->city = $request->city;
            $user->max_rent = $request->max_rent;
            $preferences = [];
            array_push($preferences, $request->preferenced_gender);
            array_push($preferences, $request->preferenced_agerange);
            $user->preferences = $preferences;
            $user->is_setup = true;

            $user->save();
        }
        elseif ($user->type == "owner")
        {
            $user->gender = $request->gender;
            $user->birthday = Carbon::createFromFormat('Y-m-d', $request->birthday)->format("Y-m-d");
            $preferences = [];
            array_push($preferences, $request->preferenced_gender);
            array_push($preferences, $request->preferenced_agerange);
            $user->preferences = $preferences;
            $user->is_setup = true;

            $user->save();
        }
        else
        {
            return response()->json(['bad_request' => 'bad_request'], 400);
        }
        return response()->json(['user' => $user], 200);
    }

    public function getAllUsers()
    {
        return User::all();
    }


    public function owner($id)
    {
        $user = User::findOrFail($id);
        if ($user->type != "owner")
        {
            return response()->json(['bad_request' => 'bad_request'], 400);
        }
        $user->rooms = $user->rooms;
        return $user;
    }

    public function user($id)
    {
        $user = User::findOrFail($id);
        if ($user->type != "user")
        {
            return response()->json(['bad_request' => 'bad_request'], 400);
        }
        return $user;
    }

    private function match_gender($other_user, $user)
    {
        return ($other_user->preferences[0] == $user->gender && $user->preferences[0] == $other_user->gender);
    }

    private function match_age($other_user, $user)
    {
        $user_age = Carbon::parse($user->birthday)->age;
        $user_min_age = $user->preferences[1][0];
        $user_max_age = $user->preferences[1][1];

        $other_user_age = Carbon::parse($other_user->birthday)->age;
        $other_user_min_age = $other_user->preferences[1][0];
        $other_user_max_age = $other_user->preferences[1][1];

        return ($other_user_min_age <= $user_age && $user_age <= $other_user_max_age) && ($user_min_age <= $other_user_age && $other_user_age <= $user_max_age);
    }

    private function common_passions($other_user, $user)
    {
        return array_intersect($other_user->passions, $user->passions);
    }

    private function number_of_common_passions($other_user, $user)
    {
        return count($this->common_passions($other_user, $user));
    }

    private function similarity_percentage($other_user, $user)
    {
        return round(($this->number_of_common_passions($other_user, $user)*2)/(count($user->passions)+count($other_user->passions)) * 100);
    }
    
    public function match($id)
    {
        $user = User::findOrFail($id);
        if ($user->is_setup == false)
        {
            return response()->json(['bad_request' => 'no setup'], 400);
        }
        $all_other_setup_user = User::where("id", "!=", $id)->
                            where("is_setup", true)->
                            where("type", "user")->
                            get();
        $matches = [];
        foreach ($all_other_setup_user as $other_user)
        {
            if ($this->match_gender($other_user, $user) &&
                $this->match_age($other_user, $user) &&
                $this->number_of_common_passions($other_user, $user) >= 1)
                {
                $other_user->common_passions = array_values($this->common_passions($other_user, $user));
                $other_user->similarity = $this->similarity_percentage($other_user, $user);
                array_push($matches, $other_user);
            }
        }
        if (count($matches) > 0)
        {

            return $matches;

        }
    }
}
