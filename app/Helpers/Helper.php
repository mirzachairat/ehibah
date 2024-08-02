<?php 
namespace App\Helpers;

use App\ProposalChecklist;
use App\Models\Checklist;
use App\Models\Lock;
use App\Models\ProposalPhoto;
// use App\User;
// use App\Komentar;
// use Bantenprov\LaravelOpd\Models\LaravelOpdModel;
use Auth;

class Helper
{	
	static function locked()
    {
		$locks = Lock::orderby('id', 'asc')->first();
		$lockCount = $locks->count();
		if ($lockCount > 0){
			$p = $locks->status;
		} else{
			$p = 1; 
		}
        return $p;
    }
	
	static function tahunanggaran()
    {

		$locks = Lock::orderby('id', 'asc')->first();
		$lockCount = $locks->count();
		// codingan yg lama
		// if ($lock > 0){
		// 	$p = $lock->ta;
		// } else{
		// 	$p = 1; 
		// }
		if ($lockCount > 0){
			$p = $locks->ta;
		} else{
			$p = 1; 
		}
        return $p;
    }
	
	static function perubahan()
    {
		$lock = Lock::orderby('id', 'asc')->first();
		$lockCount = $lock->count();
		if ($lockCount > 0){
			$p = $lock->perubahan;
		} else{
			$p = 0; 
		}
        return $p;
    }
	
	static function nilai_proposal($pid)
    {
		$nProposal = ProposalChecklist::where('proposal_id', $pid)->where('checklist_id', 28)->first();
			if (count($nProposal) > 0) 
			{
				$p = $nProposal->value;
			}
			else
			{
				$p = '-'; 
			}

        // return $p;
    }
	
	static function image($pid)
    {
		$nProposal = ProposalPhoto::where('proposal_id', $pid)->get();
			if (count($nProposal) > 0) 
			{
				$p = $nProposal;
			}
			else
			{
				$p = 'false'; 
			}

        return $p;
	}
	
	static function kelengkapan($tid,$label)
    {
		$Checklist = Checklist::where('transition_id', $tid)
					->where('label', $label)
					->orderBy('sequence','asc')
					->get();
        return $Checklist;
    }
	
	static public function upload($dir, $files_name, $files_tmp, $fn='')
	{
		$fileext = explode('.', $files_name);
		$file_ext = strtolower(end($fileext));
		
		$new_name = $fn ? $fn : md5(date("YmdHms").'_'.rand(100, 999));
		$new_file_name = $new_name.'.'.$file_ext;
		
		$file_path = $dir.$new_file_name;
		if(!in_array($file_ext, array('php','html'), true)){
			move_uploaded_file($files_tmp, $file_path);
			if(file_exists($file_path)){
				return $new_file_name;
			}
			else return false;
		}
		else return false;
	}
	 
		/*
	static function getOpd($opd)
    {
		if(Auth::user()->opd_id=='admin')
		{
			$opdnya = 'true'; 
		}
		else
		{
			$a = LaravelOpdModel::where('id', $opd)->first();
			$b = LaravelOpdModel::where('id', Auth::user()->opd_id)->first();
			if (count($a) > 0 && count($b) > 0) 
			{
				if($b->levelunker==3)
				{
					$opdnya = self::cekFromSeksi($opd,$b->id);
				}
				elseif($b->levelunker==2)
				{
					$opdnya = self::cekFromBidang($opd,$b->id);
				}
				elseif($b->levelunker==1)
				{
					$opdnya = self::cekFromDinas($opd,$b->id);
				}
			}
			else
			{
				$opdnya = 'false'; 
			}
			// $opdnya = 'false'; 
		}

        return $opdnya;
        // return $b->level;
    }
	

    static function getOpd($opd)
    {
		if(Auth::user()->opd_id=='admin')
		{
			$opdnya = 'true'; 
		}
		else
		{
			$a = LaravelOpdModel::where('id', $opd)->first();
			$b = LaravelOpdModel::where('id', Auth::user()->opd_id)->first();
			if (count($a) > 0 && count($b) > 0) 
			{
				if($b->levelunker==3)
				{
					$opdnya = self::cekFromSeksi($opd,$b->id);
				}
				elseif($b->levelunker==2)
				{
					$opdnya = self::cekFromBidang($opd,$b->id);
				}
				elseif($b->levelunker==1)
				{
					$opdnya = self::cekFromDinas($opd,$b->id);
				}
			}
			else
			{
				$opdnya = 'false'; 
			}
			// $opdnya = 'false'; 
		}

        return $opdnya;
        // return $b->level;
    }
	
	static function cekFromSeksi($opd,$opds)
    {
		$a  = LaravelOpdModel::where('id', $opds)->first();
		if (count($a) > 0) {
			if($opd == $a->id)
			{
				$return = 'true';
			}
			else
			{
				$return = 'false';
			}
		}
		return $return;
	}
	
	static function cekFromBidang($opd,$opds)
    {
		$a  = LaravelOpdModel::where('id', $opd)->first();
		if (count($a) > 0) {
			$b  = LaravelOpdModel::where('id', $a->parent_id)->first();
			if (count($b) > 0) {
				$c  = LaravelOpdModel::where('parent_id', $b->id)->first();
				if($c->parent_id == $opds)
				{
					$return = 'true';
				}
				else{
					$return = 'false';
				}
			}
		}
		return $return;
		
	}
	
	static function cekFromDinas($opd,$opds)
    {
		$a  = LaravelOpdModel::where('id', $opd)->first();
		if (count($a) > 0) {
			$b  = LaravelOpdModel::where('id', $a->parent_id)->first();
			if (count($b) > 0) {
				$c  = LaravelOpdModel::where('id', $b->parent_id)->first();
				if($c->id == $opds)
				{
					$return = 'true';
				}
				else{
					$return = 'false';
				}
			}
		}
		return $return;
		
	}
	
	static function opduser()
    {
		if(Auth::user()->opd_id=='admin')
		{
			$opdnya = 'admin'; 
		}
		else
		{
			// $a = LaravelOpdModel::where('id', $opd)->first();
			$b = LaravelOpdModel::where('id', Auth::user()->opd_id)->first();
			if (count($b) > 0) 
			{
				if($b->levelunker==3)
				{
					$opdnya = self::cekFromSeksiopd($opd,$b->id);
				}
				elseif($b->levelunker==2)
				{
					$opdnya = self::cekFromBidangopd($opd,$b->id);
				}
				elseif($b->levelunker==1)
				{
					$opdnya = self::cekFromDinasopd($opd,$b->id);
				}
			}
			else
			{
				$opdnya = ''; 
			}
		}

        return $opdnya;
        // return $b->level;
    }
	
	static function cekFromSeksiopd($opd,$opds)
    {
		$a  = LaravelOpdModel::where('id', $opds)->first();
		if (count($a) > 0) {
			if($opd == $a->id)
			{
				$return = $a->id;
			}
			else
			{
				$return = '';
			}
		}
		return $return;
	}
	
	static function cekFromBidangopd($opd,$opds)
    {
		$a  = LaravelOpdModel::where('id', $opd)->first();
		if (count($a) > 0) {
			$b  = LaravelOpdModel::where('id', $a->parent_id)->first();
			if (count($b) > 0) {
				$c  = LaravelOpdModel::where('parent_id', $b->id)->first();
				if($c->parent_id == $opds)
				{
					$return = $c->parent_id;
				}
				else{
					$return = '';
				}
			}
		}
		return $return;
		
	}
	
	static function cekFromDinasopd($opd,$opds)
    {
		$a  = LaravelOpdModel::where('id', $opd)->first();
		if (count($a) > 0) {
			$b  = LaravelOpdModel::where('id', $a->parent_id)->first();
			if (count($b) > 0) {
				$c  = LaravelOpdModel::where('id', $b->parent_id)->first();
				if($c->id == $opds)
				{
					$return = $c->id;
				}
				else{
					$return = '';
				}
			}
		}
		return $return;
		
	}

	static function comentAlerts()
    {
        if (@Auth::user()->opd_id ='admin') {
            $Coment = Komentar::whereNull('view_admin')->orderby('date_komentar', 'desc')->limit(10)->get();
        } else {
            $Coment = Komentar::whereNull('view_admin')->orderby('date_komentar', 'desc')->limit(10)->get();
        }
        return $Coment;
    }

	static function name_opd($opd_id)
    {
        if ($opd_id ='admin') {
            $opd = 'Admin';
        } else {
            // $opd = LaravelOpdModel::where('id', $opd_id)->first();
        }
        // return $opd->name;
    // }
*/
	
}