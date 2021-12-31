<?php

namespace App\Http\Controllers\Manager\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Purchase;
use Auth;
use Response;
use App\Exports\Manager\PurchaseExport;
use Maatwebsite\Excel\Facades\Excel;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Purchase::orderBy('id','DESC')->where('created_by', Auth::user()->id);
        $totalamount = Purchase::where('created_by', Auth::user()->id);
        if(($request->has('date1')) || ($request->has('date2')))
        {
            $posts = $posts->whereBetween('date', [$request->date1, $request->date2]);
            $totalamount = $totalamount->whereBetween('date', [$request->date1, $request->date2]);
        }
        $totalamount = $totalamount->sum('amount');
        $posts = $posts->paginate(100);
          $response = [
             'pagination' => [
                 'total' => $posts->total(),
                 'per_page' => $posts->perPage(),
                 'current_page' => $posts->currentPage(),
                 'last_page' => $posts->lastPage(),
                 'from' => $posts->firstItem(),
                 'to' => $posts->lastItem()
             ],
             'purchasereports' => $posts,
             'totals' => $totalamount,
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
