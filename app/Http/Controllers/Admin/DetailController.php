<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;
use App\Kista;
use App\Detail;
use Auth;
use Response;

class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $luckydrawid = $request->luckydrawid;
        $kistaid = $request->kistaid;
        $agentid = $request->agentid;
        $posts = Detail::orderBy('id','DESC')
                        ->where('created_by', Auth::user()->id)
                        ->where('luckydraw_id',$luckydrawid)
                        ->where('kista_id',$kistaid)
                        ->where('agent_id',$agentid)
                        ->with('getClientInfo')
                        ->get();
                        // dd($posts);
        $response = [
            'kistadetails' => $posts
        ];
        return response()->json($response);
    }

    public function detail(Request $request){
            $managerid = $request->managerid;
            $luckydrawid = $request->luckydrawid;
            $kistaid = $request->kistaid;
            $agentid = $request->agentid;

            $posts = Detail::orderBy('id','DESC')
                            ->where('luckydraw_id',$luckydrawid)
                            ->where('kista_id',$kistaid)
                            ->where('agent_id',$agentid)
                            ->with('getClientInfo')
                            ->where('created_by', $managerid)
                            ->get();
            $kista = '1';
            $status = True;
        $response = [
            'kistadetails' => $posts,
            'kistaAmount' => $kista,
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
        // dd($request->lottery_status,$request->amount);
        // dd($request->agent_id,$request->luckydraw_id,$request->agent_id);
        $luckydraw_id = $request->luckydraw_id;
        $kista_id = $request->kista_id;
        $agent_id = $request->agent_id;
        $amount = $request->amount;
        $lottery_data = $request->lottery_status;
        $loop_check = $request->data;
        foreach ($loop_check as $key => $value) {
            $counts = Detail::where('luckydraw_id',$luckydraw_id)->where('kista_id',$kista_id)->where('client_id',$value['id'])->count();
            if($counts == '1'){
                return ['message' => 'Data already inserted'];
            }else{
                $datas = new Detail;
                $datas->client_id = $value['id'];
                $datas->luckydraw_id = $luckydraw_id;
                $datas->kista_id = $kista_id;
                $datas->agent_id = $agent_id;
                $datas->lottery_status = $lottery_data[$key];
                $findkista = Kista::find($kista_id);
                if($lottery_data[$key] == '1'){
                    $datas->amount = $findkista->amount;
                    $datas->remaining = '0';
                }
                elseif($lottery_data[$key] =='2' && $amount[$key] != null){
                    $datas->amount = $amount[$key];
                    $datas->remaining = $findkista->amount - $amount[$key];
                    if($datas->remaining > 0){
                         $datas->is_remained = 1;
                    }
                }
                else{
                    $datas->amount = $findkista->amount;
                    $datas->remaining = '0';
                }
                $datas->date = date("Y-m-d");
                $datas->date_np = $this->helper->date_np_con_parm(date("Y-m-d"));
                $datas->time = date("H:i:s");
                $datas->created_by = Auth::user()->id;
                $datas->save();
            }
        }
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
        $details = Detail::findOrFail($id);
        return response()->json([
            'details'=>$details
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
        
    }
    public function prize(Request $request){
        // dd($request);
        $datas = Detail::findOrFail($request->detailid);
        $datas->update([
            'lottery_prize' => $request['lottery_prize'],
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
        //
    }
    public function revise($id, $lotteryStatus){
        $remaining = Detail::where('id',$id)->value('remaining');
        $amount = Detail::where('id',$id)->value('amount');
        // dd($amount);
        $user = Detail::findOrFail($id);
        if($lotteryStatus == '2'){
            $user->lottery_status = 1;
            $user->amount = $remaining;
            $user->remaining = $amount;
        }
        elseif($lotteryStatus == '1'){
            $user->lottery_status = 2;
            $user->amount = $remaining;
            $user->remaining = $amount;
        }
        $user->update();
    }
}
