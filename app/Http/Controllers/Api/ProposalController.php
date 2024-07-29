<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    public function getProposal()
    {
        $proposals = Proposal::orderBy('time_entry', 'DESC')->paginate(10);
        return response()->json(['status' => 200, 'data' => $proposals]);
    }
}
