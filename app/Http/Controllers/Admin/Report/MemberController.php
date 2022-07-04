<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Detail;
use App\Client;
use App\Kista;
use App\LuckyDraw;
use App\Agent;
use Auth;
use Response;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $luckydraw_name = LuckyDraw::where('id',$request->luckydrawid)->value('name');
        $agent_name = Agent::where('id',$request->agentid)->value('name');

        $luckydraw_id = $request->luckydrawid;
        $agent_id = $request->agentid;
        $kista_name = Kista::where('luckydraw_id',$luckydraw_id)
                            ->where('is_active','1')
                            ->pluck('name','id');
                            

        $dues = Detail::orderBy('id','ASC')
                        ->where('created_by', Auth::user()->id);

        $posts = Client::orderBy('id','DESC')
                         ->where('created_by', $request->managerid)
                            ->whereHas('getClientDetail', function(Builder $query) use ($luckydraw_id){
                              $query->where('luckydraw_id', $luckydraw_id);
                            });
        // if($request->managerid)
        // {
        //     $posts = $posts->where('created_by',$request->managerid);
        // }                
        if($request->has('kistaid') && $request->get('kistaid')!="")
        {            
            $dues = $dues->where('kista_id',$request->kistaid);
        }
        $due_amount = [];
        $collected_amount = [];
        if($request->has('agentid') && $request->get('agentid')!="")
        {            
            $posts = $posts->where('agent_id',$request->agentid);
            $due_amount[] = $dues->where('agent_id',$request->agentid)->groupBy('agent_id')->sum('remaining');
            $collected_amount[] = $dues->where('agent_id',$request->agentid)->groupBy('agent_id')->sum('amount'); 
        }
        else
        {
            $dues = $dues->groupBy('agent_id')
                        ->pluck('agent_id');
            foreach ($dues as $key => $child) {
                $due_amount[] = Detail::where('agent_id',$child)->sum('remaining');
                $collected_amount[] = Detail::where('agent_id',$child)->sum('amount');
            }            

        }
        $count = $posts->count();
        $posts = $posts->with('getAgent','getCount','getAgent.getHeadAgent','getReferPerson')
                        ->with(array('getClientDetail'=>function($query) use ($luckydraw_id){
                               $query->select()->where('luckydraw_id',$luckydraw_id);
                           }))->paginate(100);
                        
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
           'count' => $count,
           'luckydraw_name'=>$luckydraw_name,
           'agent_name'=>$agent_name,
           'due_amount' => $due_amount,
           'collected_amount' => $collected_amount,
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
