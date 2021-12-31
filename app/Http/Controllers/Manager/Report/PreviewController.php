<?php

namespace App\Http\Controllers\Manager\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;
use App\Booking;
use Auth;
use Response;
use App\Exports\Manager\PreviewExport;
use App\Exports\Manager\SerialNoExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PreviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $booking = Booking::where('created_by',Auth::user()->id)->where('is_active','1')
                            ->pluck('booked_serialno');
        // dd($booking);
        $booking_array = [];
        foreach ($booking as $key => $child) {
                $booking_array[] = $child;

            // foreach ($child as $key => $value) {
            //     $booking_array[] = $value;
            // }
        }
        // dd($booking_array);

        $posts = Client::orderBy('id','DESC')
                        ->where('created_by', Auth::user()->id);
        $total = Client::orderBy('id','DESC')
                        ->where('created_by', Auth::user()->id);
        $left = [];
        for ($i=0001; $i < 7000 ; $i++) { 
            $left[]= str_pad($i, 4, '0', STR_PAD_LEFT);
            // $left[]= $i;
        } 
        // dd($left);
        $allocated = Client::orderBy('id','DESC')
                            ->where('created_by',Auth::user()->id)
                            ->pluck('serial_no');
        $array = array_diff($left,$allocated->toArray(),$booking_array);

        //new added
        $common_value = array_intersect($allocated->toArray(),$booking_array);
        $booking_arrays = array_diff($booking_array,$common_value);
        //end of new added

        if(empty($request->search))
        {            
            $posts = $posts;
        }
        else{
            $search = $request->search;
            $posts = $posts->where('serial_no',$search);
            $total = $total->where('serial_no',$search);
        }
        if($request->has('agentid') && $request->get('agentid')!="")
        {            
             $posts = $posts->where('agent_id',$request->agentid);
             $total = $total->where('agent_id',$request->agentid);
        }
        $posts = $posts->paginate(200);
        $total = $total->count();
        $response = [
            'pagination' => [
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem()
            ],
            'previewreports' => $posts,
            'total' => $total,
            'array' => $array,
            'booking_array' => $booking_arrays,
            // 'booking_array' => $booking_array,
        ];
        return response()->json($response);
    }

    public function fileExport(Request $request){
        $current_date = date("Y-m-d");
        $filename = 'serialnoreports'.$current_date.'.xlsx';
        return Excel::download(new SerialNoExport($request->agent_id,$request->search), $filename);
        // $filename = 'previewreports'.$current_date.'.xlsx';
        // return Excel::download(new PreviewExport($request->agent_id,$request->search), $filename);

    }

    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
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
