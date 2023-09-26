<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Message;

class MessageMedia extends Model
{
    use HasFactory;
    protected $table = 'messagemedia';
    protected $foreignKey = 'message_id';
    protected $primaryKey = 'id';
    protected $fillable = [
      'image',
      'message_id'
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}
