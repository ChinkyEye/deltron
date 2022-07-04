<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\LuckyDraw;
use Auth;
use Response;

class LuckyDrawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = LuckyDraw::orderBy('id','DESC')
                            ->where('created_by',$request->managerid);
        if(empty($request->search))
        {            
            $posts = $posts;
        }
        else{
            $search = $request->search;
            $posts = $posts->where('name', 'LIKE',"%{$search}%");
        }
        $posts = $posts->with('getUserName')->paginate(15);
        $response = [
            'pagination' => [
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem()
            ],
            'luckydraws' => $posts
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
        ]);
        LuckyDraw::create([
            'name' => $request['name'],
            'date_np' => $this->helper->date_np_con(),
            'date' => date("Y-m-d"),
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
        $luckydraws = LuckyDraw::findOrFail($id);
        return response()->json([
            'luckydraws'=>$luckydraws
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
        ]);
        $datas = LuckyDraw::findOrFail($id);
        $datas->update([
            'name' => $request['name'],
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
        $luckydraws = LuckyDraw::findOrFail($id);
        $luckydraws->delete();
        return ['message'=>'ok'];
    }

    public function getAllLuckyDraw(Request $request){
        $manager_id = $request->managerid;
        $luckydraws = LuckyDraw::orderBy('id','ASC')
                                ->where('created_by',$manager_id)
                                ->where('is_active','1')
                                ->get();
        return response()->json([
          'selectluckdraws'=>$luckydraws
        ],200);

    }
    public function getAllMLuckyDraw(Request $request){
        $manager_id = $request->managerid;
        $luckydraws = LuckyDraw::orderBy('id','ASC')
                                ->where('created_by',$manager_id)
                                ->where('is_active','1')
                                ->get();
        return response()->json([
          'selectmluckdraws'=>$luckydraws
        ],200);
    }

    public function status($id, $avi){
      $user = LuckyDraw::findOrFail($id);
      $user->is_active = !$avi;
      $user->save();
    }
}
