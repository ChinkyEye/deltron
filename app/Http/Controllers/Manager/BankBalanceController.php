<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BankBalance;
use Auth;
use Response;

class BankBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = BankBalance::orderBy('id','DESC')
                            ->where('created_by', Auth::user()->id);
        $posts = $posts->with('getKista','getLuckyDraw')->paginate(15);
        $response = [
            'pagination' => [
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem()
            ],
            'bankbalances' => $posts
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
            'bank_name' => 'required',
            'account_no' => 'required',
            'amount' => 'required',
        ]);
        BankBalance::create([
            'kista_id' => $request['kista_id'],
            'luckydraw_id' => $request['luckydraw_id'],
            'bank_name' => $request['bank_name'],
            'account_no' => $request['account_no'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'amount' => $request['amount'],
            'description' => $request['description'],
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
        $bankbalances = BankBalance::findOrFail($id);
        return response()->json([
            'bankbalances'=>$bankbalances
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
            'bank_name' => 'required',

        ]);
        $datas = BankBalance::findOrFail($id);
        $datas->update([
            'bank_name' => $request['bank_name'],
            'account_no' => $request['account_no'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'amount' => $request['amount'],
            'description' => $request['description'],
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
        $bankbalances = BankBalance::findOrFail($id);
        $bankbalances->delete();
        return ['message'=>'ok'];
    }
    public function status($id, $avi){
      $user = BankBalance::findOrFail($id);
      $user->is_active = !$avi;
      $user->save();
    }
}
