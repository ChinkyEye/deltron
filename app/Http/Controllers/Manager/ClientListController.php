<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;
use Auth;
use Response;

class ClientListController extends Controller
{
    public function index(Request $request)
    {
        $posts = Client::orderBy('id','DESC')
                        ->where('created_by', Auth::user()->id);

        if(empty($request->agent_id))
        {            
            $posts = $posts;
        }
        else{
            $agent_id = $request->agent_id;
            $posts = $posts->where('agent_id',$agent_id);
        }

        $posts = $posts->with('getAgent')->paginate(50);
        $response = [
            'pagination' => [
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem()
            ],
            'clientlists' => $posts
        ];
        return response()->json($response);
    }
}
