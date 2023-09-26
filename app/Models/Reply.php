<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ReplyMedia;
use App\Models\Thread;

class Reply extends Model
{
    use HasFactory;
    protected $table = 'replies';
    protected $foreignKey = 'thread_id';
    protected $primaryKey = 'id';
    protected $fillable = [
      'content',
      'user_id',
      'thread_id',
      'reply_to'
    ];

    public function image(){
      return $this->hasMany(ReplyMedia::class,'reply_id','id');
    }
    public function thread(){
      return $this->belongsTo(Thread::class,'thread_id');
    }
}
