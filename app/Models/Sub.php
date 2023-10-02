<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Skpd;

class Sub extends Model
{
    use HasFactory;
    protected $table ='sub_skpd';
    public $timestamps = true;
    protected $fillable = ['kd_skpd','skpd','kd_sub_skpd','nm_sub_skpd'];
    protected $hidden = ['created_at','deleted_at','updated_at'];


    public function skpd()
    {
      return $this->belongsTo(Skpd::class);
    }

    public function subskpd()
    {
      return $this->belongsTo('App\Models\Proposal','sub_skpd','id');
    }
}
