<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkflowState extends Model
{
    use HasFactory;
    protected $table ='workflow_state';
    protected $fillable = ['name','label','status','workflow_id'];
    protected $hidden = ['created_at','deleted_at','updated_at'];

	public function WorkName()
    {
       return $this->belongsTo(Workflow::class,'workflow_id','id');
    }
}
