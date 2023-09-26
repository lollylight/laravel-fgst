<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Thread;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = [
      'catlink',
      'catname'
    ];

    public function threads(){
      return $this->hasMany(Threads::class,'cat_id','id');
    }
}
