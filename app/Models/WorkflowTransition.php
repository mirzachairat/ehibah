<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkflowTransition extends Model
{
    use HasFactory;
    protected $table ='workflow_transition';
    protected $fillable = ['name','label','from','to','message','status','workflow_id'];
}
