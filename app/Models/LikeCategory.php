<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeCategory extends Model
{
    use HasFactory;
    protected $table = 'categorylike';
    protected $fillable = [
      'user_id',
      'cat_id'
    ];
}
