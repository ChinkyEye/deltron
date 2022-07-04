<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Detail;
use App\Purchase;
use App\IncomeExpenditure;
use App\Record;
use App\Client;
use App\Agent;
use App\User;
use Auth;
use Response;

class HomeController extends Controller
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
    public function loadDashboard(Request $request)
    {
        $current_date = date("Y-m-d");
        $tpnp_count = Detail::where('is_active','1')
                            ->where('created_by', $request->managerid)
                            ->count();
        $lotteryprize_count = Detail::where('lottery_prize', '!=' , null)
                                    ->where('created_by', $request->managerid)
                                    ->count();
        $purchase_count = Purchase::where('is_active','1')
                                    ->where('created_by', $request->managerid)
                                    ->count();
        $incomeexpenditure_count = IncomeExpenditure::where('is_active','1')
                                                    ->where('created_by', $request->managerid)
                                                    ->count();
        $expenditure_count = IncomeExpenditure::where('type','Expenditure')
                                                ->where('created_by', $request->managerid)
                                                ->where('is_active','1')
                                                ->count();
        $record_count = Record::where('is_active','1')
                                ->where('created_by', $request->managerid)
                                ->count();
        $member_count = Client::where('is_active','1')
                                ->where('created_by', $request->managerid)
                                ->count();
        $agent_count = Agent::where('is_active','1')
                            ->where('created_by', $request->managerid)
                            ->count();                        
        $response = [
           'tpnp_count' => $tpnp_count,
           'lotteryprize_count' => $lotteryprize_count,
           'purchase_count' => $purchase_count,
           'incomeexpenditure_count' => $incomeexpenditure_count,
           'expenditure_count' => $expenditure_count,
           'record_count' => $record_count,
           'member_count' => $member_count,
           'agent_count' => $agent_count,
        ];
        return response()->json($response);
    }

    public function currentmanager($id)
    {
        $response = [
            'currentuser' => User::find($id),
        ];
        return $response;
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
