<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Record;
use Auth;
use App\Exports\Manager\RecordExport;
use Maatwebsite\Excel\Facades\Excel;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Record::orderBy('id','DESC')
                        ->where('created_by', $request->managerid);
        $totalamount = 0;
        // if($request->managerid)
        // {
        //     $posts = $posts->where('created_by', $request->managerid);
        // }
        if(($request->has('date1')) || ($request->has('date2')))
        {
            $posts = $posts->whereBetween('date', [$request->date1, $request->date2]);
            $totalamount = Record::where('created_by', $request->managerid)
                                    ->whereBetween('date', [$request->date1, $request->date2])
                                    ->sum('amount');
        }
        $posts = $posts->with('getKista','getLuckyDraw')->paginate(100);
        $response = [
             'pagination' => [
                 'total' => $posts->total(),
                 'per_page' => $posts->perPage(),
                 'current_page' => $posts->currentPage(),
                 'last_page' => $posts->lastPage(),
                 'from' => $posts->firstItem(),
                 'to' => $posts->lastItem()
             ],
             'recordreports' => $posts,
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
