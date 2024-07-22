<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;

    protected $table = 'proposal';
    protected $fillable= ['id','user_id','user','name','judul','latar_belakang','maksud_tujuan',
    'address','file','nphd','foto','tanggal_lpj','tahun','rekomendasi','rekomendasi_inspektorat',
    'rekomendasi_tapd','dokumen_tapd','lampiran','penetapan','sppd','rekjenis','rekobj','objrincian','current_stat','nik_ahu','typeproposal','program','kegiatan','type_id','skpd_id','sub_skpd','rekening','kota','kec','kel','kategori'];

    public function galeri()
    {
        return  $this->hasMany('App\Models\ProposalPhoto','proposal_id','id');
    }

    public function dana()
    {
        return  $this->hasMany('App\Models\ProposalDana','proposal_id','id');
    }

    public function skpd()
    {
        return $this->hasOne('App\Models\Skpd','id','skpd_id');
    }

    public function type()
    {
        return $this->hasOne('App\Models\ProposalType','id','type_id');
    }
    
    public function status()
    {
        return $this->hasOne('App\Models\WorkflowState','id','current_stat');
    }

    public function checklist()
    {
        return  $this->hasMany('App\Models\ProposalChecklist','proposal_id','id');
    }
}
