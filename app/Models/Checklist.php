<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;
    protected $table = 'checklist';
    protected $fillable =['role_id','sequence','name'];
	
	public function Role()
    {
        return $this->hasOne('App\Models\Role','id','role_id');
    }
}
