<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AgentHasCommision;
use Auth;
use Response;

class AgentHasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = AgentHasCommision::orderBy('id','DESC')->where('created_by', Auth::user()->id)->get();
        $response = [
            'agentcommisions' => $data
        ];
        return response()->json($response);
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
        // dd($request->amount,$request->kista_id,$request->agent_id,$request->commission_type);
        $amount = $request->amount;
        $kista_id = $request->kista_id;
        $agent_id = $request->agent_id;
        $commission_type = $request->commission_type;
        $count = AgentHasCommision::where('kista_id',$kista_id)
                                    ->where('agent_id',$agent_id)
                                    ->count();
        if($count == 0){
            AgentHasCommision::create([
                'agent_id' => $agent_id,
                'commission' => $amount,
                'commission_type' => $commission_type,
                'kista_id' => $kista_id,
                'date' => date("Y-m-d"),
                'date_np' => date("Y-m-d"),
                'time' => date("H:i:s"),
                'created_by' => Auth::user()->id,
            ]);
            return ['message' => 'Data Created'];
        }
        else{
            $data_id = AgentHasCommision::where('kista_id',$kista_id)
                                        ->where('agent_id',$agent_id)
                                        ->value('id');
            $datas = AgentHasCommision::findOrFail($data_id);
            $datas->update([
                'commission' => $amount,
                'commission_type' => $commission_type,
                'updated_by' => Auth::user()->id,
            ]);
            return ['message' => 'Data Updated'];

        }                           
        
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
