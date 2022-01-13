<?php

namespace App\Http\Controllers\Manager\Report;

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

    public function lol(Request $request)
    {
        // for opening balance
        $prev_kistaid = $request->kistaid - 1;
        $posts_incomes = IncomeExpenditure::orderBy('id','DESC')
                                        ->where('type','Income');
        $posts_expenditures = IncomeExpenditure::orderBy('id','DESC')
                                        ->where('type','Expenditure');
        $bank_balances = BankBalance::orderBy('id','DESC')
                                    ->where('kista_id',$request->luckydrawidkistaid)
                                    ->where('kista_id',$prev_kistaid)
                                    ->sum('amount');
        $prev_income = Detail::orderBy('id','DESC');

                                                            
        if($request->has('luckydrawid') && $request->get('luckydrawid')!="")
        {            
            $posts_incomes = $posts_incomes->where('luckydraw_id', 'LIKE',"%{$request->luckydrawid}%");
            $posts_expenditures = $posts_expenditures->where('luckydraw_id', 'LIKE',"%{$request->luckydrawid}%");
            $prev_income =$prev_income->where('luckydraw_id', 'LIKE',"%{$request->luckydrawid}%");
        }

        if($request->has('kistaid') && $request->get('kistaid')!="")
        {   
            $posts_incomes = $posts_incomes->where('kista_id', 'LIKE',"%{$prev_kistaid}%");
            $posts_expenditures = $posts_expenditures->where('kista_id', 'LIKE',"%{$prev_kistaid}%");
            $prev_income = $prev_income->where('kista_id', 'LIKE',"%{$prev_kistaid}%");

        }

        if(($request->has('date1')) || ($request->has('date2')))
        {
            $posts_incomes = $posts_incomes->whereBetween('date', [$request->date1, $request->date2]);
            $posts_expenditures = $posts_expenditures->whereBetween('date', [$request->date1, $request->date2]);
            $prev_income = $prev_income->whereBetween('date', [$request->date1, $request->date2]);
        }
        $posts_incomes =  $posts_incomes->paginate(50);
        $posts_expenditures =  $posts_expenditures->paginate(50);
        $income_totals =  $posts_incomes->sum('amount');
        $expenditure_totals =  $posts_expenditures->sum('amount');
        $prev_income =  $prev_income->sum('amount');
        $opening_amount = $prev_income + $income_totals - $expenditure_totals - $bank_balances;
        // dd($opening_amount,$prev_income,$income_totals,$expenditure_totals,$bank_balances);

        // end opening balance

        $posts_income = IncomeExpenditure::orderBy('id','DESC')
                                    ->where('type','Income');
        $posts_expenditure = IncomeExpenditure::orderBy('id','DESC')
                                    ->where('type','Expenditure');
        $bank_balance = BankBalance::orderBy('id','DESC')
                                    ->where('luckydraw_id',$request->luckydrawid)
                                    ->where('kista_id',$request->kistaid)
                                    ->sum('amount');
        $bank_details = BankBalance::orderBy('id','DESC') 
                                    ->where('luckydraw_id',$request->luckydrawid)
                                    ->where('kista_id',$request->kistaid)
                                    ->value('bank_name');
        $latest_income = Detail::orderBy('id','DESC');


        if($request->has('luckydrawid') && $request->get('luckydrawid')!="")
        {            
            $posts_income = $posts_income->where('luckydraw_id', 'LIKE',"%{$request->luckydrawid}%");
            $posts_expenditure = $posts_expenditure->where('luckydraw_id', 'LIKE',"%{$request->luckydrawid}%");
            $latest_income = $latest_income->where('luckydraw_id', 'LIKE',"%{$request->luckydrawid}%");
        }

        if($request->has('kistaid') && $request->get('kistaid')!="")
        {   
            $posts_income = $posts_income->where('kista_id', 'LIKE',"%{$request->kistaid}%");
            $posts_expenditure = $posts_expenditure->where('kista_id', 'LIKE',"%{$request->kistaid}%");
            $latest_income = $latest_income->where('kista_id', 'LIKE',"%{$request->kistaid}%");
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
        $pre_opening_amount = $latest_income + $opening_amount - $expenditure_total - $bank_balance;
        // dd($pre_opening_amount,$latest_income,$opening_amount,$expenditure_total,$bank_balance);
        $response = [
          //   'pagination' => [
          //     'total' => $posts->total(),
          //     'per_page' => $posts->perPage(),
          //     'current_page' => $posts->currentPage(),
          //     'last_page' => $posts->lastPage(),
          //     'from' => $posts->firstItem(),
          //     'to' => $posts->lastItem()
          // ],
          'incomeexpenditurereports_income' => $posts_income,
          'incomeexpenditurereports_expenditure' => $posts_expenditure,
          'income_total' => $income_total + $latest_income,
          'expenditure_total' => $expenditure_total + $bank_balance,
          'bank_balance' => $bank_balance,
          'bank_details' => $bank_details,
          'cash_balance' => $income_total-$expenditure_total-$bank_balance,
          'opening_amount' => $opening_amount,
          'prev_income' => $prev_income,
          'latest_income' => $latest_income,
          'pre_opening_amount' => $pre_opening_amount,
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
