<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\IncomeExpenditure;
use App\BankBalance;
use App\Detail;
use App\Kista;
use App\LuckyDraw;
use App\KistaHasOpening;
use Auth;
use Response;

class IncomeExpenditureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $luckydraw_name = LuckyDraw::where('id',$request->luckydrawid)->value('name');
        $kista_name = Kista::where('id',$request->kistaid)->value('name');

        // dd($request->kistaid -1,$preId->id);
        $posts_income = IncomeExpenditure::orderBy('id','DESC')
                                    ->where('type','Income');
        $posts_expenditure = IncomeExpenditure::orderBy('id','DESC')
                                    ->where('type','Expenditure');
        $latest_income = Detail::orderBy('id','DESC');

        //bank details                            
        $bank_balance = BankBalance::orderBy('id','DESC')
                                    ->where('luckydraw_id',$request->luckydrawid)
                                    ->where('kista_id',$request->kistaid)
                                    ->sum('amount');
        $bank_details = BankBalance::orderBy('id','DESC') 
                                    ->where('luckydraw_id',$request->luckydrawid)
                                    ->where('kista_id',$request->kistaid)
                                    ->value('bank_name');
        $initial_opening = 0;
        $opening_amount = KistaHasOpening::where('created_by', Auth::user()->id);
        $preId = Kista::where('created_by', Auth::user()->id);


        if($request->has('luckydrawid') && $request->get('luckydrawid')!="")
        {            
            $posts_income = $posts_income->where('luckydraw_id',$request->luckydrawid);
            $posts_expenditure = $posts_expenditure->where('luckydraw_id', 'LIKE',"%{$request->luckydrawid}%");
            $latest_income = $latest_income->where('luckydraw_id', $request->luckydrawid);
            // $latest_income = $latest_income->where('luckydraw_id', 'LIKE',"%{$request->luckydrawid}%");
            $opening_amount = $opening_amount->where('luckydraw_id', 'LIKE',"%{$request->luckydrawid}%");
            $preId = $preId->where('luckydraw_id',$request->luckydrawid);
        }

        if($request->has('kistaid') && $request->get('kistaid')!="")
        {   
            $posts_income = $posts_income->where('kista_id',$request->kistaid);
            $posts_expenditure = $posts_expenditure->where('kista_id', 'LIKE',"%{$request->kistaid}%");
            $latest_income = $latest_income->where('kista_id', $request->kistaid);
            // $latest_income = $latest_income->where('kista_id', 'LIKE',"%{$request->kistaid}%");
            $preId = $preId->where('id','<',$request->kistaid)->orderBy('id','DESC')->first();
            if($preId == NULL){
                $preid = '0';
            }else{
                $preid = $preId->id;
            }
            $opening_amount = $opening_amount->where('kista_id',$preid);
        }

        if(($request->has('date1')) || ($request->has('date2')))
        {
            $posts_income = $posts_income->whereBetween('date', [$request->date1, $request->date2]);
            $posts_expenditure = $posts_expenditure->whereBetween('date', [$request->date1, $request->date2]);
            $latest_income = $latest_income->whereBetween('date', [$request->date1, $request->date2]);
        }

        $posts_income =  $posts_income->paginate(50);
        $posts_expenditure =  $posts_expenditure->paginate(50);
        $income_total =  $posts_income->sum('amount');
        $expenditure_total =  $posts_expenditure->sum('amount');
        $latest_income = $latest_income->sum('amount');
        $opening_amount = $opening_amount->sum('amount');
        // dd($opening_amount);
        $response = [
          'incomeexpenditurereports_income' => $posts_income,
          'incomeexpenditurereports_expenditure' => $posts_expenditure,
          'income_total' => $income_total,
          'expenditure_total' => $expenditure_total,
          'bank_balance' => $bank_balance,
          'bank_details' => $bank_details,
          'latest_income' => $latest_income,
          'opening_amount' => $opening_amount,
          'luckydraw_name'=>$luckydraw_name,
          'kista_name'=>$kista_name,
          'to_date' => $request->date1,
          'from_date' =>$request->date2,
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
