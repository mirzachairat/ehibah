<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $table ='historys';
    protected $fillable = ['state','content_id','user_id','message','workflow_id','from_state','to_state','opd_id'];
}
