<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MessageMedia;

class Message extends Model
{
    use HasFactory;
    protected $table = 'messages';
    protected $primaryKey = 'id';
    protected $fillable = [
      'from',
      'to',
      'content'
    ];

    public function media(){
      return $this->hasMany(MessageMedia::class,'message_id','id');
    }
}
