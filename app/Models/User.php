<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ResetPasswordNotification;
Use App\Models\Match;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     *     
     * @var string[]
     */
    protected $fillable = [
        'name',
     //   'nationality',
     //   'gender',
      //  'birthday',
        'is_setup',
        'email',
        'password',
        'type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'preferences' => 'array'
    ];



    public function sendPasswordResetNotification($token)
    {
        $url = 'http://localhost:3000/reset-password?token=' . $token ;

        

        $this->notify(new ResetPasswordNotification($url));
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
