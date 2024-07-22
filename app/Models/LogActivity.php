<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;



class LogActivity extends Model
{
    use HasFactory;

    protected $table = 'log_activities';

    protected $guarded = ['id'];

    /**
     * Get the user responsible for the given activity.
     *
     * @return User
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * Get the subject of the activity.
     *
     * @return mixed
     */
    public function subject()
    {
        return $this->morphTo(Proposal::class);
    }

    /**
     * Get the latest activities on the site
     * @return mixed
     */
    static public function getLatest()
    {
		if(Auth::user()->id=='1'){
			return self::with('user')
				->with('subject')
				->orderBy('created_at', 'DESC')
			   ->paginate(env('BACKEND_PAGINATION'));
		}else{
			return self::with('user')
				->with('subject')
				->where('user_id', Auth::user()->id)
				->orderBy('created_at', 'DESC')
			   ->paginate(env('BACKEND_PAGINATION'));
		}
    }
}
