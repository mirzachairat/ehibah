<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalDana extends Model
{
    use HasFactory;
    protected $table ='proposal_dana';
    protected $fillable =['proposal_id','sequence','description','amount','correction','correction_inspektorat','correction_tapd','correction_banggar','deskor','desins','destapd','desbang','korid','insid','tapdid','bangid'];
    public $timestamps = false;

    public function dana()
    {
      return $this->belongsTo('App\Models\Proposal','id','proposal_id');
    }
}
