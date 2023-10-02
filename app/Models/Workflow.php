<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    use HasFactory;
    protected $table = 'workflow';
    protected $fillable = array('content_id', 'name', 'label','content_type');
}
