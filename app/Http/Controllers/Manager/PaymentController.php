<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Detail;
use App\Client;
use App\Kista;
use Auth;
use Response;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function payment(Request $request)
    {
        // dd($request);
        $luckydrawid = $request->luckydrawid;
        $agentid = $request->agentid;
        $kistaid = $request->kistaid;

        // $admin = new Client();
        // $admin->getPayments($kistaid);

        $checkDetail = Detail::where('agent_id',$agentid)->where('kista_id',$kistaid)->count();
        $posts = Client::orderBy('id','DESC')
                            ->select('id','name','agent_id','is_leave','serial_no')
                            ->where('agent_id',$agentid)
                            ->where('is_leave','1')
                            // ->with('getPayment')
                            ->with(array('getPayment'=>function($query) use ($kistaid){
                               $query->select()->where('kista_id',$kistaid);
                           }))
                         //    ->whereHas('getPayment', function(Builder $query) use ($kistaid){
                         //     $query->where('kista_id',$kistaid); 
                         // })
                            ->get();
        $kista = Kista::where('id',$kistaid)->value('amount');
        $status = False;
        $kistaids = Kista::where('luckydraw_id',$luckydrawid)->count();
        $response = [
            'kistadetails' => $posts,
            'kistaAmount' => $kista,
            'status' => $status,
            'kista_id' => $kistaid,
            'kistacount' => $kistaids,
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
        // dd($request);
        $luckydraw_id = $request->luckydraw_id;
        $kista_id = $request->kista_id;
        $agent_id = $request->agent_id;
        $amount = $request->amount;
        $lottery_data = $request->lottery_status;
        $loop_check = $request->data;
        $counts = Detail::where('luckydraw_id',$luckydraw_id)
                            ->where('kista_id',$kista_id)
                            ->where('client_id',$loop_check['id'])
                            ->count();
        if($counts == '1'){
            return ['message' => 'Data already inserted'];
        }else{
            $datas = new Detail;
            $datas->client_id = $loop_check['id'];
            $datas->luckydraw_id = $luckydraw_id;
            $datas->kista_id = $kista_id;
            $datas->agent_id = $agent_id;
            $datas->lottery_status = $lottery_data;
            $findkista = Kista::find($kista_id);
            if($lottery_data== '1'){
                $datas->amount = '0';
                $datas->remaining = $findkista->amount;
            }
            elseif($lottery_data =='2' && $amount != null){
                $datas->amount = $amount;
                $datas->remaining = $findkista->amount - $amount;
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
