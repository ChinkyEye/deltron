<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Expense;
use Auth;
use Response;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Expense::orderBy('id','DESC')
                        ->where('created_by', Auth::user()->id)
                        ->where('kista_id',$request->kistaid)
                        ->where('created_by', Auth::user()->id);
        $posts = $posts->paginate(15);
        $response = [
            'pagination' => [
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem()
            ],
            'expenses' => $posts
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
            'title' => 'required',
            'kistaid' => 'required',
            'amount' => 'required',
        ]);
        Expense::create([
            'kista_id' => $request['kistaid'],
            'luckydraw_id' => $request['luckydrawid'],
            'title' => $request['title'],
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
        $expenses = Expense::findOrFail($id);
        return response()->json([
            'expenses'=>$expenses
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
            'title' => 'required',
        ]);
        $datas = Expense::findOrFail($id);
        $datas->update([
            'title' => $request['title'],
            'amount' => $request['amount'],
            'date' => date("Y-m-d"),
            'date_np' => $this->helper->date_np_con(),
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
        $expenses = Expense::findOrFail($id);
        $expenses->delete();
        return ['message'=>'ok'];
    }
    public function status($id, $avi){
        $user = Expense::findOrFail($id);
        $user->is_active = !$avi;
        $user->save();
    }
}
