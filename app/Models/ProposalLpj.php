<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalLpj extends Model
{
    use HasFactory;
    protected $table ='proposal_lpj';
    protected $fillable =['proposal_id','path','sequence','type'];
    public $timestamps = false;
}
