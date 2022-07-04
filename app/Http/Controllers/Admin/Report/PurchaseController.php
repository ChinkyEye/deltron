<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Purchase;
use Auth;
use Response;
use App\Exports\Manager\PurchaseExport;
use App\Imports\Manager\PurchaseImport;
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
        // dd($request);
        $posts = Purchase::orderBy('id','DESC')
                            ->where('created_by',$request->managerid);
        $totalamount = Purchase::where('is_active', true)
                            ->where('created_by',$request->managerid);
        if(($request->has('date1')) || ($request->has('date2')))
        {
            $posts = $posts->whereBetween('date', [$request->date1, $request->date2]);
            $totalamount = $totalamount->whereBetween('date', [$request->date1, $request->date2]);
        }
        if($request->managerid)
        {
            $posts = $posts->where('created_by',$request->managerid);
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
