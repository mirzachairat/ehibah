<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalPhoto extends Model
{
    use HasFactory;
    protected $table = 'proposal_photo';
    protected $fillable =['proposal_id','sequence','path','is_nphd'];
    public $timestamps = false;
    
    public function galeri()
    {
      return $this->belongsTo('App\Models\Proposal','id','proposal_id');
    }
}
