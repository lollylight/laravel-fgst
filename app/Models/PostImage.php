<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class PostImage extends Model
{
    use HasFactory;
    protected $table = 'postimages';
    protected $foreignKey = 'post_id';
    protected $primaryKey = 'id';
    protected $fillable = [
      'image',
      'post_id'
    ];


    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
