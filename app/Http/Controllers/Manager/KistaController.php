<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Kista;
use Auth;

class KistaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Kista::orderBy('id','DESC')->where('created_by', Auth::user()->id);
        if(empty($request->search))
        {            
            $posts = $posts;
        }
        else{
            $search = $request->search;
            $posts = $posts->where('name', 'LIKE',"%{$search}%");
        }
        $posts = $posts->with('getLuckyDraw')->paginate(25);
        $response = [
            'pagination' => [
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem()
            ],
            'kistas' => $posts
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
        $this->validate($request, [
            'name' => 'required',
            'luckydraw_id' => 'required',
            'amount' => 'required',
        ]);
        // $date = date("Y-m-d");
        Kista::create([
            'luckydraw_id' => $request['luckydraw_id'],
            'name' => $request['name'],
            'amount' => $request['amount'],
            'date_np' => $this->helper->date_np_con_parm($request['date']),
            'date' => $request['date'],
            'time' => date("H:i:s"),
            'created_by' => Auth::user()->id,
        ]);
        return ['message' => 'Data Created'];
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
        $kistas = Kista::findOrFail($id);
        return response()->json([
            'kistas'=>$kistas
        ],200);
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
        $this->validate($request, [
            'name' => 'required',
            'luckydraw_id' => 'required',
            'amount' => 'required',
        ]);
        $datas = Kista::findOrFail($id);
        $datas->update([
            'luckydraw_id' => $request['luckydraw_id'],
            'name' => $request['name'],
            'amount' => $request['amount'],
            'date_np' => $this->helper->date_np_con_parm($request['date']),
            'date' => $request['date'],
            'updated_by' => Auth::user()->id,
        ]);
        return ['message' => 'Data Updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kistas = Kista::findOrFail($id);
        $kistas->delete();
        return ['message'=>'ok'];
    }
    
    public function status($id, $avi){
      $user = Kista::findOrFail($id);
      $user->is_active = !$avi;
      $user->save();
    }

    public function check(Request $request,$id,$word){
        $name = $word;
        $data = Kista::where('name','=', $name)
                        ->where('luckydraw_id','=',$id)
                        ->count();
        if($data > 0)
        {
            return ['message' => 'not_unique'];
        }
        else
        {
            return ['message'=>'unique'];
        }              
                        // dd($data);
    }
    public function getAllKista(Request $request)
    {
        $data_id = $request->luckydraw_id;
        $posts = Kista::orderBy('id','ASC')
                        ->where('luckydraw_id',$data_id)
                        ->with('getCommision')
                        ->get();
                        // dd($posts);
        $response = [
            'selectkistas' => $posts
        ];
        return response()->json($response);
    }
    public function getAllKistaCommision(Request $request)
    {
        $luckydraw_id = $request->luckydrawid;
        $agent_id = $request->agentid;
        $posts = Kista::orderBy('id','ASC')
                        ->where('luckydraw_id',$luckydraw_id)
                        ->with('getCommision')
                        // ->whereHas('getCommision', function(Builder $query) use ($agent_id){
                        //       $query->where('agent_id', $agent_id);
                        //     })
                        ->get();
                        // dd($posts);

        $response = [
            'selectkistacommisions' => $posts,
            'agent_id' => $agent_id,
        ];
        return response()->json($response);
    }

}
