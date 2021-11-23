<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
       $fields = $request->validate([
           'name'     => 'required|string',
        /*   'nationality'=> 'required|string',
           'gender' => 'required|string|max:1',
           'birthday' =>'required|date',*/
           
           'email'    => 'required|string|unique:users,email',
           'type' => 'required|string',
           'password' => 'required|string'
                                    ]);

       $user = User::create([
           'name' => $fields['name'],
           'email' => $fields['email'],
           'password' => bcrypt($fields['password']),
           'type' => $fields['type'],
         /*  'nationality' => $fields['nationality'],
            'gender' => $fields['gender'],
            'birthday' => $fields['birthday'],*/
        /*    'isStudent' => $fields['isStudent'],
            'isEmployee' => $fields['isEmployee'],
            'additional_1' => $fields['additional_1'],
            'additional_2' => $fields['additional_2']  */
                            ]);
                         


       $token = $user->createToken('myapptoken')->plainTextToken;

       $response = [
           'user' => $user,
           'token' => $token
                   ];

       return response($response,201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'logged out'
        ];
    }

    public function login(Request $request)
    {
       $fields = $request->validate([
           
           'email'    => 'required|string',
           'password' => 'required|string'
                                    ]);
                                 

      // Check email
       $user = User::where('email', $fields['email'])->first();

       // Check password
       if(!$user || !Hash::check($fields['password'],$user->password))
         {
             return response([
                 'message' => 'bad creds'
             ],401);
         }


       $token = $user->createToken('myapptoken')->plainTextToken;

       $response = [
           'user' => $user,
           'token' => $token
                   ];

       return response($response,201);
    }


}
