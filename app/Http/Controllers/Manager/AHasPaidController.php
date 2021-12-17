<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Detail;
use App\Agent;
use App\AgentHasPaid;
use Auth;

class AHasPaidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $agentid = $request->agentid;
        $kistaid = $request->kistaid;
        $luckydrawid = $request->luckydrawid;
        $check = AgentHasPaid::where('agent_id',$agentid)
                                ->where('kista_id',$kistaid)
                                ->where('luckydraw_id',$luckydrawid)
                                ->count();
        if($check){
            $status = True;
            $posts = AgentHasPaid::orderBy('id','DESC')
                                ->where('created_by', Auth::user()->id)
                                ->where('agent_id',$agentid)
                                ->where('kista_id',$kistaid)
                                ->where('luckydraw_id',$luckydrawid)
                                ->get();
        } 
        else{
            $status = False;
            $posts = Agent::orderBy('id','DESC')
                            ->where('created_by', Auth::user()->id)
                            ->where('id',$agentid)
                            ->get();
        } 
        $collected_amount = Detail::orderBy('id','DESC')
                        ->where('created_by', Auth::user()->id)
                        ->where('agent_id',$agentid)
                        ->where('kista_id',$kistaid)
                        ->where('luckydraw_id',$luckydrawid)
                        ->sum('amount');
        $response = [
            'agenthaspaids' => $posts,
            'collected_amount' => $collected_amount,
            'status' => $status,
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
        $this->validate($request, [
            'amount' => 'required',
        ]);
        AgentHasPaid::create([
            'kista_id' => $request['kista_id'],
            'luckydraw_id' => $request['luckydraw_id'],
            'agent_id' => $request['agent_id'],
            'amount' => $request['amount'],
            'date' => date("Y-m-d"),
            'date_np' => $this->helper->date_np_con_parm(date("Y-m-d")),
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
