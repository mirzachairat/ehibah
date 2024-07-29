<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Traits\LogsActivity;

class Banner extends Model
{
    use HasFactory, SoftDeletes;

    // public $timestamps = true;
	protected $table = 'banner';

    // protected $dates = ['deleted_at'];
    protected $fillable = array('name','gambar', 'status');
}
