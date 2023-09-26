<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;
    protected $table = 'friends';
    protected $fillable = [
      'first_user_id',
      'second_user_id',
      'status'
    ];
}
