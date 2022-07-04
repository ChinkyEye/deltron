<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\IncomeExpenditure;
use App\LuckyDraw;
use App\Kista;
use Auth;
use Response;
use App\Exports\Manager\ExpenditureExport;
use Maatwebsite\Excel\Facades\Excel;

class ExpenditureReportController extends Controller
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
        $expendituretype = '';
        if($request->expendituretype == '1')
        {
            $expendituretype = 'Direct';

        }
        elseif($request->expendituretype == '2')
        {
            $expendituretype = 'Indirect';
        }

        $posts = IncomeExpenditure::orderBy('id','DESC')
                                    ->where('created_by', $request->managerid);
        $total = 0;
        // if($request->managerid)
        // {
        //     $posts = $posts->where('created_by',$request->managerid);
        // }
        if($request->has('luckydrawid') && $request->get('luckydrawid')!="")
        {   
           $posts = $posts->where('luckydraw_id', 'LIKE',"%{$request->luckydrawid}%");         
                           
        }
        if($request->has('kistaid') && $request->get('kistaid')!="")
        {  
            $posts = $posts->where('kista_id', 'LIKE',"%{$request->kistaid}%");          
        }
        if($request->has('expendituretype') && $request->get('expendituretype')!="")
        {            
            $posts = $posts->where('expenditure_type',$request->expendituretype);
            $total = $posts->sum('amount');
        }
        $posts = $posts->paginate(30);
        $response = [
           'pagination' => [
               'total' => $posts->total(),
               'per_page' => $posts->perPage(),
               'current_page' => $posts->currentPage(),
               'last_page' => $posts->lastPage(),
               'from' => $posts->firstItem(),
               'to' => $posts->lastItem()
           ],
           'expenditurereports' => $posts,
           'total' => $total,
           'luckydraw_name'=>$luckydraw_name,
           'kista_name'=>$kista_name,
           'expendituretype'=> $expendituretype,
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
