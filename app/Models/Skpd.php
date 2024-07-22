<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skpd extends Model
{
    use HasFactory;
    protected $table ='skpd';
    public $timestamps = true;
    protected $fillable = ['id','name','kd_skpd'];
    protected $hidden = ['created_at','deleted_at','updated_at'];

    public function sub_skpd(){
      return $this->hasOne(Sub::class, 'kd_skpd');
    }
    // public function skpd()
    // {
    //   return $this->belongsTo('App\Models\Proposal','skpd_id','id');
    // }

    // public function sub()
    // {
    //   return $this->haveMany('App\Models\Sub','kd_skpd');
    // }
}
