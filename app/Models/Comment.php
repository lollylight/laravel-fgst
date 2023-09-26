<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $foreignKey = 'post_id';
    protected $primaryKey = 'id';
    protected $fillable = [
      'content',
      'post_id',
      'user_id',
      'reply_to'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
