<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Agent;
use App\Kista;
use App\LuckyDraw;
use Auth;

class AgentController extends Controller
{
    public function agentlist(Request $request,$id)
    {
        $posts = Agent::orderBy('id','DESC');
        // $posts = Agent::orderBy('id','DESC')->where('kista_id',$id)->where('is_head',null);
        if(empty($request->search))
        {            
            $posts = $posts;
        }
        else{
            $search = $request->search;
            $posts = $posts->where('name', 'LIKE',"%{$search}%");
        }
        $posts = $posts->with('getKista')->paginate(15);
        $response = [
            'pagination' => [
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem()
            ],
            'agents' => $posts
        ];
        return response()->json($response);
    }

    public function index(Request $request)
    {
        $posts = Agent::orderBy('id','DESC')->where('created_by',$request->managerid);
        if(empty($request->search))
        {            
            $posts = $posts;
        }
        else{
            $search = $request->search;
            $posts = $posts->where('name', 'LIKE',"%{$search}%");
        }
        $posts = $posts->with('getKista','getUserName')->paginate(15);
        $response = [
            'pagination' => [
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem()
            ],
            'agents' => $posts
        ];
        return response()->json($response);
  
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);
        Agent::create([
            'name' => $request['name'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'date' => date("Y-m-d"),
            'date_np' => date("Y-m-d"),
            'time' => date("H:i:s"),
            'created_by' => Auth::user()->id,
        ]);
        return ['message' => 'Data Created'];
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $agents = Agent::findOrFail($id);
        return response()->json([
            'agents'=>$agents
        ],200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $datas = Agent::findOrFail($id);
        $datas->update([
            'name' => $request['name'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            // 'commission' => $request['commission'],
            'date_np' => $this->helper->date_np_con(),
            'date' => date("Y-m-d"),
            'updated_by' => Auth::user()->id,
        ]);
        return ['message' => 'Data Updated'];
    }

    public function destroy($id)
    {
        $kistas = Agent::findOrFail($id);
        $kistas->delete();
        return ['message'=>'ok'];
    }

    public function status($id, $avi){
      $user = Agent::findOrFail($id);
      $user->is_active = !$avi;
      $user->save();
    }

    public function getAllAgent(Request $request)
    {
        $data_id = $request->manager_id;
        $posts = Agent::orderBy('id','ASC')
                        ->where('created_by',$data_id)
                        ->get();
        $response = [
            'selectagents' => $posts
        ];
        return response()->json($response);
    }
}
