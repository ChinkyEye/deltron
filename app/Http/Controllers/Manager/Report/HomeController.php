<?php

namespace App\Http\Controllers\Manager\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Detail;
use App\Purchase;
use App\IncomeExpenditure;
use App\Record;
use App\Client;
use Auth;
use Response;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loadDashboard()
    {
        $current_date = date("Y-m-d");
        $tpnp_count = Detail::where('date',$current_date)->where('is_active','1')->count();
        $lotteryprize_count = Detail::where('lottery_prize', '!=' , null)->count();
        $purchase_count = Purchase::where('date',$current_date)->where('is_active','1')->count();
        $incomeexpenditure_count = IncomeExpenditure::where('date',$current_date)->where('is_active','1')->count();
        $expenditure_count = IncomeExpenditure::where('expenditure_type','1')->where('is_active','1')->count();
        $record_count = Record::where('is_active','1')->count();
        // $record_count = Record::where('date',$current_date)->where('is_active','1')->count();
        $member_count = Client::where('date',$current_date)->where('is_active','1')->count();
        $response = [
           'tpnp_count' => $tpnp_count,
           'lotteryprize_count' => $lotteryprize_count,
           'purchase_count' => $purchase_count,
           'incomeexpenditure_count' => $incomeexpenditure_count,
           'expenditure_count' => $expenditure_count,
           'record_count' => $record_count,
           'member_count' => $member_count,
           // 'order_count' => $order_count,
           // 'stock_level_count' => $stock_level_count,
           // 'counter_count' => $counter_count,
           // 'bill_count' => $bill_count,
           // 'bill_ageing_count' => $bill_ageing_count,
           // 'purchase_return_count' => $purchase_return,
           // 'top_item_sale' => $top_item_sale,
           // 'top_item_customer' => $top_item_customer,
        ];
        return response()->json($response);
    }
    public function index()
    {
        //
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
