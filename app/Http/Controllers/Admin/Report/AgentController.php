<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Detail;
use App\LuckyDraw;
use App\Kista;
use App\Agent;
use App\AgentHasCommision;
use Response;
use Auth;


class AgentController extends Controller
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
        $agent_name = Agent::where('id',$request->agentid)->value('name');

        $posts = Detail::orderBy('id','DESC')
                        ->where('created_by', $request->managerid);
        $total = 0;
        $commisionamount = 0;
        $totalwithcommision = 0;
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
        if($request->has('agentid') && $request->get('agentid')!="")
        {            
            $posts = $posts->where('agent_id',$request->agentid);
        }
        if($request->has('type') && $request->get('type')!="")
        {            
            $posts = $posts->where('lottery_status',$request->type);
            $amount = $posts->sum('amount');

            $count = $posts->count();

            $findkistacommision = AgentHasCommision::where('agent_id',$request->agentid)->where('kista_id',$request->kistaid)->value('commission');

            $findcommisiontype = AgentHasCommision::where('agent_id',$request->agentid)->where('kista_id',$request->kistaid)->value('commission_type');

            if($findcommisiontype == '1'){
                $commisionamount = ($findkistacommision / 100) * $amount ; 
            }elseif ($findcommisiontype == '2' ) {
                $commisionamount = $findkistacommision * $count ;
            }
            $total = $amount ; 
            $totalwithcommision = $amount + $commisionamount; 
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
            'agentreports' => $posts,
            'commisionamount' => $commisionamount,
            'total' => $total,
            'luckydraw_name'=>$luckydraw_name,
            'kista_name'=>$kista_name,
            'agent_name'=>$agent_name,
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
