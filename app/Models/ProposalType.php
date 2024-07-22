<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalType extends Model
{
    use HasFactory;

    protected $table ='proposal_type';
    protected $fillabel =['id','name'];
 
 
    public function type()
    {
      return $this->belongsTo('App\Models\Proposal','type_id','id');
    }
}
