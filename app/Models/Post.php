<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PostImage;
use App\Models\User;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $foreignKey = 'user_id';
    protected $primaryKey = 'id';
    protected $fillable = [
      'subject',
      'content',
      'user_id'
    ];

    public function image(){
      return $this->hasMany(PostImage::class,'post_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function comments(){
        return $this->hasMany(Comment::class,'post_id','id');
    }
}
