<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Kista;
use App\Detail;
use App\KistaHasOpening;
use App\IncomeExpenditure;
use App\BankBalance;
use Auth;
use Response;

class KistaHasOpeningController extends Controller
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
        $preId = Kista::where('luckydraw_id',$luckydrawid)
                        ->where('id','<',$request->kistaid)
                        ->orderBy('id','DESC')
                        ->first();
        if($preId == NULL){
            $preid = '0';
        }else{
            $preid = $preId->id;
        }

        $posts_income = IncomeExpenditure::orderBy('id','DESC')
                                    ->where('type','Income');
        $posts_expenditure = IncomeExpenditure::orderBy('id','DESC')
                                    ->where('type','Expenditure');

        $posts = Kista::where('luckydraw_id',$luckydrawid)
                        ->where('id',$kistaid)
                        ->get();
        $bank_balance = BankBalance::orderBy('id','DESC')
                                    ->where('luckydraw_id',$request->luckydrawid)
                                    ->where('kista_id',$request->kistaid)
                                    ->sum('amount');                

        $latest_income = Detail::orderBy('id','DESC')
                                ->where('luckydraw_id',$luckydrawid)
                                ->where('kista_id',$kistaid)
                                ->sum('amount');
        $check = KistaHasOpening::orderBy('created_at','DESC')
                                ->where('luckydraw_id',$luckydrawid)
                                ->where('kista_id',$kistaid)
                                ->count();
       
        $counts = KistaHasOpening::orderBy('created_at','DESC')
                                ->where('luckydraw_id',$luckydrawid)
                                ->where('kista_id',$preid)
                                // ->where('kista_id',$kistaid - 1)
                                ->count();
        if($check == 0){
            $check_amount = null;
            $status = true;
        }else{
             $check_amount = KistaHasOpening::orderBy('created_at','DESC')
                                ->where('luckydraw_id',$luckydrawid)
                                ->where('kista_id',$kistaid)
                                ->value('amount');
            $status = false;
        }                        
        if($counts == 0){
            $latest_opening = "0";
        }
        else{
        $latest_opening = KistaHasOpening::orderBy('created_at','DESC')
                                        ->where('luckydraw_id',$luckydrawid)
                                        ->where('kista_id',$preid)
                                        // ->where('kista_id',$request->kistaid - 1)
                                        // ->latest()->first();
                                        ->value('amount');
                                        // dd($latest_opening);
        }
        if($request->has('luckydrawid') && $request->get('luckydrawid')!="")
        {            
            $posts_income = $posts_income->where('luckydraw_id', 'LIKE',"%{$request->luckydrawid}%");
            $posts_expenditure = $posts_expenditure->where('luckydraw_id', 'LIKE',"%{$request->luckydrawid}%");
        }

        if($request->has('kistaid') && $request->get('kistaid')!="")
        {   
            $posts_income = $posts_income->where('kista_id', 'LIKE',"%{$request->kistaid}%");
            $posts_expenditure = $posts_expenditure->where('kista_id', 'LIKE',"%{$request->kistaid}%");
        }    

        $income_total =  $posts_income->sum('amount');
        $expenditure_total =  $posts_expenditure->sum('amount');                            
        $response = [
            'kistas' => $posts,
            'latest_income' => $latest_income,
            'latest_opening' => $latest_opening,
            'income_total' => $income_total,
            'expenditure_total' => $expenditure_total,
            'bank_balance' => $bank_balance,
            'status' => $status,
            'check_amount' => $check_amount,
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
        $check= KistaHasOpening::where('created_by', Auth::user()->id)
                                 ->where('luckydraw_id',$request['luckydraw_id'])
                                 ->where('kista_id',$request['kista_id'])
                                 ->count();
        if($check == 0) {
            $this->validate($request, [
                'amount' => 'required',
            ]);
            KistaHasOpening::create([
                'kista_id' => $request['kista_id'],
                'luckydraw_id' => $request['luckydraw_id'],
                'amount' => $request['amount'],
                'date' => date("Y-m-d"),
                'date_np' => $this->helper->date_np_con_parm(date("Y-m-d")),
                'time' => date("H:i:s"),
                'created_by' => Auth::user()->id,
            ]);
            return ['message' => 'Data Created'];
        }  
        else{
            $data_id = KistaHasOpening::where('luckydraw_id',$request->luckydraw_id)
                                        ->where('kista_id',$request->kista_id)
                                        ->value('id');
           $datas = KistaHasOpening::findOrFail($data_id);
           $datas->update([
            'amount' => $request['amount'],
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
