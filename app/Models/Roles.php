<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    protected $table = 'role';
    protected $guard = [];

    public function user()
    {
        return $this->belongTo(User::class);
    }
}
