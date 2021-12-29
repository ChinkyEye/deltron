<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Agent;
use App\Booking;
use App\Client;
use Auth;
use Response;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Agent::orderBy('id','DESC')->where('created_by', Auth::user()->id);
        $posts = $posts->with('getBooking','getBookingLatest')->paginate(100); 
        $response = [
            'pagination' => [
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem()
            ],
            'bookings' => $posts,
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
        $true_value = array_filter($request->checkedNames);
        $true_value_key = array_keys($true_value);
        foreach ($true_value_key as $value) {
            Booking::create([
                'agent_id' => $request->agent_id,
                'booked_serialno' => str_pad($value + 1, 4, '0', STR_PAD_LEFT),
                'slug' => $this->helper->slug_converter(str_pad($value + 1, 4, '0', STR_PAD_LEFT)).'-'.Auth::user()->id,
                // 'booked_serialno' => $value + 1,
                // 'slug' =>  $this->helper->slug_converter($request['serial_no']).'-'.Auth::user()->id,
                'date_np' => $this->helper->date_np_con_parm($request['date']),
                'date' => $request['date'],
                'time' => date("H:i:s"),
                'created_by' => Auth::user()->id,
            ]);
        }
        return ['message' => 'Data Created'];

    }
    public function store2(Request $request)
    {
        $true_value = array_filter($request->checkedNames);
        $true_value_key = array_keys($true_value);
        $bookings = [];
        foreach ($true_value_key as $value) {
            $true_value_key = [
                'value'=>$value+1,
            ];
            array_push($bookings, $true_value_key);
        }
        Booking::create([
            'agent_id' => $request->agent_id,
            'booked_serialno' => $bookings,
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
        $bookings = Booking::findOrFail($id);
        return response()->json([
            'bookings'=>$bookings
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
        dd($request->cancel);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $datas = Booking::findOrFail($id);
       // $datas->is_active = '0';
       // $datas->save();
       $datas->delete();
       return ['message'=>'ok'];
    }

    public function cancelBooking($id, $sts)
    {
        // $datas = Booking::findOrFail($id);
        // $datas->delete();
        // return ['message'=>'ok'];
        
       $datas = Booking::findOrFail($id);
       $datas->is_active = !$sts;
       $datas->save();
       return ['message'=>'ok'];
    }

    public function check(Request $request,$id,$word)
    {
        // dd($id,$word);
        $name = $word;
        $slug = $this->helper->slug_converter($name).'-'.Auth::user()->id;
        // dd($name,$slug);
        $serial_no_check = Client::where('is_active','1')
                            ->where('slug','=',$slug)
                            // ->where('serial_no','=',$name)
                            ->count(); 
        // $data = Booking::where('booked_serialno', 'LIKE',"%{$name}%")
        $data = Booking::where('slug', 'LIKE',"%{$slug}%")
                        ->where('is_active','1')
                        // ->where('agent_id',$id)
                        ->count();

        // $agent_id = Booking::where('booked_serialno', 'LIKE',"%{$name}%")
        $agent_id = Booking::where('slug', 'LIKE',"%{$slug}%")
                        ->where('agent_id',$id)
                        ->count();

        // if($serial_no_check){
        //     $tagent = true;
        //     $data = 0;
        // }
        // else{
        //     $tagent = false;
        //     $data = 1;
        // }
        if($agent_id){
            $tagent = true;
        }
        else{
            $tagent = false;
        }

        // $status = $agent_id->contains($id);
        // dd($status);  
        return response()->json([
            'checked'=>$data,
            'typeid' => $tagent
        ],200);              


    }
}
