<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;
use App\Agent;
use App\Booking;
use Auth;
use App\Exports\Manager\MemberListExport;
use Maatwebsite\Excel\Facades\Excel;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function clientlist(Request $request,$id)
    {
        $agent_id = $id;
        $posts = Client::orderBy('id','DESC')->where('created_by', Auth::user()->id)->where('agent_id',$id);
        if(empty($request->search))
        {            
            $posts = $posts;
        }
        else{
            $search = $request->search;
            $posts = $posts->where('name', 'LIKE',"%{$search}%");
        }
        $posts = $posts->with('getAgent')->paginate(30);
        $response = [
            'pagination' => [
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem()
            ],
            'clients' => $posts,
            'agent_id' => $agent_id,
        ];
        return response()->json($response);
    }
    
    public function index(){

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
    public function store1(Request $request)
    {
        $data  = Booking::where('agent_id',$request->agent_id)->count();
        $user = Booking::where('agent_id',$request->agent_id)->pluck('id');
        // dd($user);
        if($data != 0){
            $request['slug'] = $this->helper->slug_converter($request['serial_no']).'-'.Auth::user()->id;
            foreach ($user as $key => $value) {
                $this->validate($request, [
                    'name' => 'required',
                    'address' => 'required',
                    'phone' => 'required',
                    'serial_no' => 'required|size:4|between:0001,6999',
                    'slug' => 'required|unique:clients||unique:bookings,slug,'.$value,
                    // 'slug' => 'required|unique:clients||unique:bookings,slug,'.$user,
                    // 'slug' => 'required|unique:clients||unique:bookings,slug,'.$value,
                ]);
            }
            $agents = Agent::find($request->agent_id);
            Client::create([
                'agent_id' => $agents->id,
                'name' => $request['name'],
                'address' => $request['address'],
                'phone' => $request['phone'],
                'serial_no' => $request['serial_no'],
                'slug' =>  $this->helper->slug_converter($request['serial_no']).'-'.Auth::user()->id,
                'date_np' => $this->helper->date_np_con_parm($request['date']),
                'date' => $request['date'],
                'time' => date("H:i:s"),
                'created_by' => Auth::user()->id,
            ]);
            return ['message' => 'Data Created'];
        }
        else{
            $request['slug'] = $this->helper->slug_converter($request['serial_no']).'-'.Auth::user()->id;
            $this->validate($request, [
                'name' => 'required',
                'address' => 'required',
                'phone' => 'required',
                // 'slug' => 'required|unique:clients|unique:bookings',
                'serial_no' => 'required|size:4|between:0001,6999',
                'slug' => 'required|unique:clients|unique:bookings',
                // 'serial_no' => 'required|integer|between:1,6999',
            ]);
            $agents = Agent::find($request->agent_id);
            Client::create([
                'agent_id' => $agents->id,
                'name' => $request['name'],
                'address' => $request['address'],
                'phone' => $request['phone'],
                'serial_no' => $request['serial_no'],
                'slug' =>  $this->helper->slug_converter($request['serial_no']).'-'.Auth::user()->id,
                'date_np' => $this->helper->date_np_con_parm($request['date']),
                'date' => $request['date'],
                'time' => date("H:i:s"),
                'created_by' => Auth::user()->id,
            ]);
            return ['message' => 'Data Created'];

        }
    }
    public function store(Request $request)
    {
        $name = $request->serial_no;
        $booking_data = Booking::where('booked_serialno', 'LIKE',"%{$name}%")
                            ->where('is_active','1')
                            ->where('agent_id',$request->agent_id)
                            ->count();
        $booking_id =  Booking::where('booked_serialno', 'LIKE',"%{$name}%")
                            ->where('is_active','1')
                            ->where('agent_id',$request->agent_id)
                            ->value('id');

        $request['slug'] = $this->helper->slug_converter($request['serial_no']).'-'.Auth::user()->id;
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'slug' => 'required|unique:clients',
            'serial_no' => 'required|size:4|between:0001,6999',
            // 'serial_no' => 'required|integer|between:1,6999',
        ]);
        $agents = Agent::find($request->agent_id);
        Client::create([
            'agent_id' => $agents->id,
            'name' => $request['name'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'serial_no' => $request['serial_no'],
            'slug' =>  $this->helper->slug_converter($request['serial_no']).'-'.Auth::user()->id,
            'date_np' => $this->helper->date_np_con_parm($request['date']),
            'date' => $request['date'],
            'time' => date("H:i:s"),
            'created_by' => Auth::user()->id,
        ]);
        if($booking_data == 1){
             $bookings = Booking::find($booking_id);
             $bookings->is_active = '0';
             $bookings->update();

        }
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
        $clients = Client::findOrFail($id);
        return response()->json([
            'clients'=>$clients
        ],200);
    }

    public function agent_name($id)
    {
        $agent_name = Agent::findOrFail($id);
        return response()->json([
            'agent_name'=>$agent_name
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
        // $this->validate($request, [
        //     'name' => 'required',
        // ]);
        // dd($request,$id);
        $ids = $request->id;
        $request['slug'] = $this->helper->slug_converter($request['serial_no']).'-'.Auth::user()->id;
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            // 'slug' => 'required|unique:clients',
            'slug' => 'required|unique:clients,slug,'.$ids,
            'serial_no' => 'required|size:4|between:0001,6999',
        ]);
        $datas = Client::findOrFail($id);
        $datas->update([
            'name' => $request['name'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            // 'serial_no' => $request['serial_no'],
            'serial_no' => $request['serial_no'],
            'slug' =>  $this->helper->slug_converter($request['serial_no']).'-'.Auth::user()->id,
            // 'lottery_no' => $request['lottery_no'],
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
        $clients = Client::findOrFail($id);
        $clients->delete();
        return ['message'=>'ok'];
    }
    public function status($id, $avi){
      $user = Client::findOrFail($id);
      $user->is_active = !$avi;
      $user->save();
    }
    public function leave($id, $leaveId){
        $user = Client::findOrFail($id);
        $user->is_leave = !$leaveId;
        $user->update();
    }
    public function fileExport(Request $request)
    {
        $current_date = date("Y-m-d");
        $filename = 'memberlistreports'.$current_date.'.xlsx';
        return Excel::download(new MemberListExport($request->agentid), $filename);
    }
}
