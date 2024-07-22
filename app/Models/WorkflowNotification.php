<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkflowNotification extends Model
{
    use HasFactory;
    protected $table = 'workflow_notification';
    protected $fillable = array('transition_id', 'subject', 'header', 'body','footer');
}
