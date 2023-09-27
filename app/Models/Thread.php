<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Thread extends Model
{
    use HasFactory;
    protected $foreignKey = 'cat_id';
    protected $primaryKey = 'id';
    protected $fillable = [
      'user_id',
      'subject',
      'content',
      'cat_id',
      'image',
      'replies'
    ];

    public function category(){
      return $this->belongsTo(Category::class,'cat_id');
    }
    public function replies(){
      return $this->hasMany(Reply::class,'thread_id','id');
    }
}
