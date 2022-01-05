<?php

namespace App\Http\Controllers\Manager\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Detail;
use App\Client;
use App\Kista;
use Auth;
use Response;
use App\Exports\Manager\MemberExport;
use App\Imports\Manager\MemberImport;
use Maatwebsite\Excel\Facades\Excel;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $luckydraw_id = $request->luckydrawid;
        $agent_id = $request->agentid;
        $kista_name = Kista::where('luckydraw_id',$luckydraw_id)
                            ->where('is_active','1')
                            ->pluck('name','id');

        // $posts = Detail::orderBy('id','DESC')
        //                 ->where('created_by', Auth::user()->id)
        //                 ->groupBy('client_id')
        //                 ->get();
        //                 dd($posts);                    
       
        $posts = Client::orderBy('id','DESC')
                         ->where('created_by', Auth::user()->id)
                            ->whereHas('getClientDetail', function(Builder $query) use ($luckydraw_id){
                              $query->where('luckydraw_id', $luckydraw_id);
                            });
        if($request->has('agentid') && $request->get('agentid')!="")
        {            
            $posts = $posts->where('agent_id',$request->agentid);
        }
        $posts = $posts->with('getAgent','getCount')
                        ->with(array('getClientDetail'=>function($query) use ($luckydraw_id){
                               $query->select()->where('luckydraw_id',$luckydraw_id);
                           }))->paginate(1000);
        $response = [
           'pagination' => [
               'total' => $posts->total(),
               'per_page' => $posts->perPage(),
               'current_page' => $posts->currentPage(),
               'last_page' => $posts->lastPage(),
               'from' => $posts->firstItem(),
               'to' => $posts->lastItem()
           ],
           'memberreports' => $posts,
           'kista_name' => $kista_name,
           // 'check' => $check,
        ];
        return response()->json($response);
    }

    public function fileExport(Request $request){
       $current_date = date("Y-m-d");
       $filename = 'memberreports'.$current_date.'.xlsx';
       return Excel::download(new MemberExport($request->luckydraw_id, $request->agent_id), $filename);

    }

    public function fileImport(Request $request){
        $this->validate($request, [
          'file' => 'required|mimes:xlsx,xls',
        ]);
        Excel::import(new MemberImport, $request->file('file')->store('temp'));
        return back()->with('success', 'Excel file imported successfully!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         // $kista_id = Kista::where('luckydraw_id',$luckydraw_id)
        //                     ->where('is_active','1')
        //                     ->pluck('id');
        // $kista_amount = [];                   
        // foreach ($kista_id as $key => $value) {
        //     $kista_amount[] = Kista::where('id',$kista_id[$key])->value('amount');
        // }
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
