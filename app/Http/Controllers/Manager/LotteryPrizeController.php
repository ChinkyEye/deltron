<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LotteryPrizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $posts = Detail::orderBy('id','DESC')
                        ->where('created_by', Auth::user()->id)
                        ->where('lottery_prize','!=','Null');
        $total = 0;
        if(empty($request->search))
        {            
            $posts = $posts;
        }
        else{
            $search = $request->search;
            $posts = $posts->whereHas('getClientInfo', function(Builder $query) use ($search){
                              $query->where('name', 'LIKE',"%{$search}%")
                                    ->orwhere('serial_no','LIKE',"%{$search}%");
                            });
        }
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
        $posts = $posts->with('getClientInfo')->paginate(30);
        $response = [
            'pagination' => [
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem()
            ],
            'lotteryprizereports' => $posts,
            'total' => $total,
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
