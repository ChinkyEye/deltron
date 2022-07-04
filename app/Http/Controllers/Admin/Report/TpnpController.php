<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Detail;
use Auth;
use Response;
// use App\Exports\Manager\PurchaseExport;
// use Maatwebsite\Excel\Facades\Excel;

class TpnpController extends Controller
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
    public function tpnpreport(Request $request)
    {
        $played_count = Detail::orderBy('id','DESC')
                                // ->where('created_by', Auth::user()->id)
                                ->where('lottery_status',2)
                                ->where('kista_id',$request->kistaid)
                                ->where('luckydraw_id',$request->luckydrawid)
                                // ->where('created_by',$request->managerid)
                                ->count();
        $amount = Detail::orderBy('id','DESC')
                        ->where('lottery_status',2)
                        ->where('kista_id',$request->kistaid)
                        ->where('luckydraw_id',$request->luckydrawid)
                        // ->where('created_by',$request->managerid)
                        ->sum('amount');                        

        $notplayed_count =  Detail::orderBy('id','DESC')
                                ->where('lottery_status',1)
                                ->where('kista_id',$request->kistaid)
                                ->where('luckydraw_id',$request->luckydrawid)
                                // ->where('created_by',$request->managerid)
                                ->count();
        $amount2 = Detail::orderBy('id','DESC')
                        ->where('lottery_status',1)
                        ->where('kista_id',$request->kistaid)
                        ->where('luckydraw_id',$request->luckydrawid)
                        // ->where('created_by',$request->managerid)
                        ->sum('remaining');

        $leave_count = Detail::orderBy('id','DESC')
                                ->where('lottery_status',3)
                                ->where('kista_id',$request->kistaid)
                                ->where('luckydraw_id',$request->luckydrawid)
                                // ->where('created_by',$request->managerid)
                                ->count();
                                // dd($played_count,$amount,$notplayed_count,$amount2,$leave_count);
                                                
        $response = [
            'played' => $played_count,
            'notplayed' => $notplayed_count,
            'leave' => $leave_count,
            'playedamount' =>$amount,
            'notplayamount' =>$amount2,
        ];
        return response()->json($response);
    }

    public function fileExport(Request $request){
        $current_date = date("Y-m-d");
        $filename = 'purchaseReport'.$current_date.'.xlsx';
        return Excel::download(new PurchaseExport($request->start_date, $request->end_date), $filename);

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
        //
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
