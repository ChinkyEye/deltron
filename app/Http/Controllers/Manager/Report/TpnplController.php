<?php

namespace App\Http\Controllers\Manager\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Detail;
use App\LuckyDraw;
use App\Kista;
use Auth;
use Response;

class TpnplController extends Controller
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

        $posts = Detail::orderBy('id','DESC')->where('created_by', Auth::user()->id);
        $total = 0;
        if($request->has('luckydrawid') && $request->get('luckydrawid')!="")
        {            
            $luckydraw_id = $request->luckydrawid;
            $posts = $posts->whereHas('getClientInfo', function(Builder $query) use ($luckydraw_id){
                              $query->where('luckydraw_id', $luckydraw_id);
                            });
        }
        if($request->has('kistaid') && $request->get('kistaid')!="")
        {            
            $kista_id = $request->kistaid;
            $posts = $posts->whereHas('getClientInfo', function(Builder $query) use ($kista_id){
                              $query->where('kista_id', $kista_id);
                            });
        }
        if($request->has('type') && $request->get('type')!="")
        {    
            if($request->type == '1'){
                $posts = $posts->where('lottery_status',$request->type);
                $total = $posts->sum('remaining');
            }  
            else{
                $posts = $posts->where('lottery_status',$request->type);
                $total = $posts->sum('amount');
            }   
        }
  
          $posts = $posts->with('getClientInfo')->paginate(100);
          $response = [
             'pagination' => [
                 'total' => $posts->total(),
                 'per_page' => $posts->perPage(),
                 'current_page' => $posts->currentPage(),
                 'last_page' => $posts->lastPage(),
                 'from' => $posts->firstItem(),
                 'to' => $posts->lastItem()
             ],
             'tpnplreports' => $posts,
             'total' => $total,
             'luckydraw_name'=>$luckydraw_name,
             'kista_name'=>$kista_name,
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
