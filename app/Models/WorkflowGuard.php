<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkflowGuard extends Model
{
    use HasFactory;
    protected $table = 'workflow_guard';
    protected $fillable = array('transition_id', 'name', 'label', 'permission_id', 'description');
}
