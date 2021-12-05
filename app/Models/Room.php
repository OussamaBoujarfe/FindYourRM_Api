<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    
    protected $casts = [
        'preferences' => 'array',
      ];

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
