<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Profile extends Model
{
    use HasFactory;
    protected $table = 'profiles';
    protected $foreignKey = 'user_id';
    protected $primaryKey = 'id';
    protected $fillable = [
      'name',
      'age',
      'sex',
      'country',
      'userpic_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
