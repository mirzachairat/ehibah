<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekjenis extends Model
{
    use HasFactory;
    protected $table = 'rek_jenis';
    protected $fillable = ['id','kd_rek_jenis','nm_rek_jenis'];
    protected $hidden = ['created_at','deleted_at','updated_at'];

    public function rekjenis()
    {
      return $this->belongsTo(Proposal::class,'rek_jenis','kd_rek_jenis');
    }
}
