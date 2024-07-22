<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogLogin extends Model
{
    use HasFactory;


    protected $guarded = ['id'];
    
    public function user()
    {
        return $this->belongsTo(User::class,'username','username');
    }
	
    public function setUpdatedAtAttribute($value)
    {
        // Do nothing.
    }
}
