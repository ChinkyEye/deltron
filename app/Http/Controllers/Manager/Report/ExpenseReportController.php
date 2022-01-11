<?php

namespace App\Http\Controllers\Manager\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Kista;
use App\Detail;
use App\Expense;
use Auth;
use App\Exports\Manager\ExpenditureExport;
use Maatwebsite\Excel\Facades\Excel;

class ExpenseReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request);
        $posts = Kista::orderBy('id','DESC')
                        ->where('created_by', Auth::user()->id)
                        ->where('luckydraw_id',$request->luckydrawid)
                        ->with('getExpense','getAmount');
        $posts = $posts->paginate(100);
        $totalamount = Detail::where('luckydraw_id',$request->luckydrawid)->sum('amount');
        $totalexpense = Expense::where('luckydraw_id',$request->luckydrawid)->sum('amount');
        // dd($totalamount);
        $response = [
             'pagination' => [
                 'total' => $posts->total(),
                 'per_page' => $posts->perPage(),
                 'current_page' => $posts->currentPage(),
                 'last_page' => $posts->lastPage(),
                 'from' => $posts->firstItem(),
                 'to' => $posts->lastItem()
             ],
             'expensereports' => $posts,
             'totalamount' => $totalamount,
             'totalexpense' => $totalexpense,
         ];
         return response()->json($response);
    }

    public function fileExport(Request $request){
       $current_date = date("Y-m-d");
       $filename = 'expenditurereports'.$current_date.'.xlsx';
       return Excel::download(new ExpenditureExport($request->name, $request->customer_id, $request->start_date, $request->end_date), $filename);

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
