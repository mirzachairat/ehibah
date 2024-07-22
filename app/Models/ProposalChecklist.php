<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalChecklist extends Model
{
    use HasFactory;
    protected $table ='proposal_checklist';
    protected $fillable =['proposal_id','checklist_id','value'];
}
