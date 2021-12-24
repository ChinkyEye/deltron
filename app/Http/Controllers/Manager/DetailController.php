<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
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
        $agentid = $request->agentid;
        $kistaid = $request->kistaid;
        $search = $request->search;
        $posts = Detail::orderBy('id','DESC')
                        ->where('created_by', Auth::user()->id)
                        ->where('agent_id',$agentid)
                        ->where('kista_id',$kistaid)
                        ->whereHas('getClientInfo', function(Builder $query) use ($search){
                           $query->where('serial_no', 'LIKE',"%{$search}%"); 
                        })
                        ->with('getClientInfo')
                        ->get();
        // if(empty($request->search))
        // {            
        //     $posts = $posts;
        // }
        // else{
        //     $search = $request->search;
        //     $posts = $posts->whereHas('getClientInfo', function(Builder $query) use ($search){
        //                       $query->where('serial_no', 'LIKE',"%{$search}%");
        //                     });
        // }                
        // if($request->has('agentid') && $request->get('agentid')!="")
        // {            
        //     $posts = $posts->where('agent_id',$request->agentid);
        // }  
        // if($request->has('kistaid') && $request->get('kistaid')!="")
        // {            
        //     $posts = $posts->where('agent_id',$request->kistaid);
        // }  
        // $posts = $posts->with('getClientInfo')->get();              
        $response = [
            'kistadetails' => $posts
        ];
        return response()->json($response);
    }

    public function detail(Request $request){
        $agentid = $request->agentid;
        $kistaid = $request->kistaid;

        $checkDetail = Detail::where('agent_id',$agentid)->where('kista_id',$kistaid)->count();
        if($checkDetail){
            $posts = Detail::orderBy('id','DESC')
                            ->where('agent_id',$agentid)
                            ->where('kista_id',$kistaid)
                            ->with('getClientInfo')
                            ->get();
            $kista = '1';
            $status = True;
        }
        else{
            $posts = Client::orderBy('id','DESC')
                            ->select('id','name','agent_id','is_leave')
                            ->where('agent_id',$agentid)
                            ->get();
            $kista = Kista::where('id',$kistaid)->value('amount');
            $status = False;
        }

        $response = [
            'kistadetails' => $posts,
            'kistaAmount' => $kista,
            'status' => $status,
        ];
        return response()->json($response);
        // $response = [
        //     'details' => $posts,
        //     'kista_amount' => 200,

        // ];
        // return response()->json($response);
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
                    // $datas->amount = $findkista->amount;
                    // $datas->remaining = '0';
                    $datas->amount = '0';
                    $datas->remaining = $findkista->amount;
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
