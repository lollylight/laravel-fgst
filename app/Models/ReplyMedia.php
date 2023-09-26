<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reply;

class ReplyMedia extends Model
{
    use HasFactory;
    protected $table = 'replymedia';
    protected $foreignKey = 'reply_id';
    protected $primaryKey = 'id';
    protected $fillable = [
      'image',
      'reply_id'
    ];

    public function reply()
    {
        return $this->belongsTo(Reply::class,'reply_id');
    }
}
