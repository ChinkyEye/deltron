<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;
use App\Agent;
use Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function clientlist(Request $request,$id)
    {
        $posts = Client::orderBy('id','DESC')->where('created_by', Auth::user()->id)->where('agent_id',$id);
        if(empty($request->search))
        {            
            $posts = $posts;
        }
        else{
            $search = $request->search;
            $posts = $posts->where('name', 'LIKE',"%{$search}%");
        }
        $posts = $posts->with('getAgent')->paginate(15);
        $response = [
            'pagination' => [
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem()
            ],
            'clients' => $posts
        ];
        return response()->json($response);
    }
    
    public function index(){

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'serial_no' => 'required|integer|between:1,6999|unique:clients',
        ]);
        $agents = Agent::find($request->agent_id);
        Client::create([
            'agent_id' => $agents->id,
            'name' => $request['name'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'serial_no' => $request['serial_no'],
            // 'lottery_no' => $request['lottery_no'],
            'date_np' => $this->helper->date_np_con_parm($request['date']),
            'date' => $request['date'],
            'time' => date("H:i:s"),
            'created_by' => Auth::user()->id,
        ]);
        return ['message' => 'Data Created'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clients = Client::findOrFail($id);
        return response()->json([
            'clients'=>$clients
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $datas = Client::findOrFail($id);
        $datas->update([
            'name' => $request['name'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'serial_no' => $request['serial_no'],
            // 'lottery_no' => $request['lottery_no'],
            'date' => $request['date'],
            'date_np' => $this->helper->date_np_con_parm($request['date']),
            'updated_by' => Auth::user()->id,
        ]);
        return ['message' => 'Data Updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kistas = Client::findOrFail($id);
       $kistas->delete();
       return ['message'=>'ok'];
    }
    public function status($id, $avi){
      $user = Client::findOrFail($id);
      $user->is_active = !$avi;
      $user->save();
    }
    public function leave($id, $leaveId){
        $user = Client::findOrFail($id);
        $user->is_leave = !$leaveId;
        $user->update();
    }
}
