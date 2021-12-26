<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\IncomeExpenditure;
use Auth;
use Response;

class IncomeExpenditureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = IncomeExpenditure::orderBy('id','DESC')
                            ->where('created_by', Auth::user()->id);
        $posts = $posts->with('getKista','getLuckyDraw')->paginate(25);
        $response = [
            'pagination' => [
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem()
            ],
            'incomeexpenditures' => $posts
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
            'type' => 'required',
            'topic' => 'required',
            'amount' => 'required',
        ]);
        IncomeExpenditure::create([
            'kista_id' => $request['kista_id'],
            'luckydraw_id' => $request['luckydraw_id'],
            'type' => $request['type'],
            'topic' => $request['topic'],
            'description' => $request['description'],
            'amount' => $request['amount'],
            'expenditure_type' => $request['expenditure_type'],
            'date' => $request['date'],
            'date_np' => $this->helper->date_np_con_parm($request['date']),
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
        $incomeexpenditures = IncomeExpenditure::findOrFail($id);
        return response()->json([
            'incomeexpenditures'=>$incomeexpenditures
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
            'amount' => 'required',

        ]);
        $datas = IncomeExpenditure::findOrFail($id);
        $datas->update([
            'type' => $request['type'],
            'topic' => $request['topic'],
            'description' => $request['description'],
            'amount' => $request['amount'],
            'date' => $request['date'],
            'date_np' => $this->helper->date_np_con_parm($request['date']),
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
        $incomeexpenses = IncomeExpenditure::findOrFail($id);
        $incomeexpenses->delete();
        return ['message'=>'ok'];
    }
    public function status($id, $avi){
      $user = IncomeExpenditure::findOrFail($id);
      $user->is_active = !$avi;
      $user->save();
    }
}
