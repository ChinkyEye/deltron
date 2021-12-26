<?php

namespace App\Imports\Manager;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use App\Helper\Helper;
use App\Agent;
use App\Client;
use App\Detail;
use App\Kista;
use Auth;
use Illuminate\Support\Facades\DB;


class MemberFirstSheetImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    use Importable;

    public function collection(Collection $collection)
    {
        try{
            return DB::transaction(function() use ($collection)
            {
                $helper = new Helper();
                foreach (array_slice($collection->toArray(), 1) as $row) 
                {
                    $last_part = array_key_last($row) + 1;
                    $agents = Agent::firstOrCreate([
                        'name' => $row[4],
                    ], [
                        'address' => '',
                        'phone' => '98',
                        'is_active'  => '1',
                        'is_head'  => null,
                        'date' => date("Y-m-d"),
                        'date_np' => $helper->date_np_con_parm(date("Y-m-d")),
                        'time' => date("H:i:s"),
                        'created_by' => Auth::user()->id,
                    ]);
                    $format = sprintf('%04d', $row[0]);
                    // dd($row[0],$format,$lo);
                    $clients = Client::create([
                        'name' => $row[1],
                        'address' => $row[2],
                        'phone' => $row[3],
                        'serial_no' => $format,
                        // 'serial_no' => $row[0],
                        'slug' => $helper->slug_converter($format).'-'.Auth::user()->id,
                        // 'slug' => $helper->slug_converter($row[0]).'-'.Auth::user()->id,
                        'agent_id' =>$agents->id,
                        'is_active'  => '1',
                        'is_leave' => '1',
                        'date' => date("Y-m-d"),
                        'date_np' => $helper->date_np_con_parm(date("Y-m-d")),
                        'time' => date("H:i:s"),
                        'created_by' => Auth::user()->id,
                    ]);
                    $kista  = Kista::where('luckydraw_id','1')->pluck('id');
                    $kista_amount = Kista::where('luckydraw_id','1')->pluck('amount');
                    // dd($kista,$kista_amount);
                    // 15 25
                    $count = 0;
                    for ($i=6; $i < $last_part ; $i++) {
                         if($row[$i] != NULL){
                            $details = Detail::create([
                                'luckydraw_id' => '1',
                                'kista_id' => $kista[$count],
                                // 'kista_id' => $i - 5,
                                'agent_id' =>$agents->id,
                                'client_id' => $clients->id,
                                'lottery_status' => '2',
                                'amount' => $row[$i],
                                'remaining' => '0',
                                'date' => date("Y-m-d"),
                                'date_np' => $helper->date_np_con_parm(date("Y-m-d")),
                                'time' => date("H:i:s"),
                                'created_by' => Auth::user()->id,
                            ]);
                        }
                        else{
                            $details = Detail::create([
                                'luckydraw_id' => '1',
                                'kista_id' => $kista[$count],
                                // 'kista_id' => $i - 5,
                                'agent_id' =>$agents->id,
                                'client_id' => $clients->id,
                                'lottery_status' => '1',
                                'amount' => '0',
                                'remaining' => $kista_amount[$count],
                                // 'remaining' => '0',
                                'date' => date("Y-m-d"),
                                'date_np' => $helper->date_np_con_parm(date("Y-m-d")),
                                'time' => date("H:i:s"),
                                'created_by' => Auth::user()->id,
                            ]);
                        }
                        $count++;

                    }
                    // dd($count);
                    
                    // $agents = Agent::firstOrCreate([
                    //     'name' => $row['agent_name'],
                    // ], [
                    //     'address' => '',
                    //     'phone' => '98',
                    //     'is_active'  => '1',
                    //     'is_head'  => null,
                    //     'date' => date("Y-m-d"),
                    //     'date_np' => $helper->date_np_con_parm(date("Y-m-d")),
                    //     'time' => date("H:i:s"),
                    //     'created_by' => Auth::user()->id,
                    // ]);

                    // $clients = Client::create([
                    //     'name' => $row['member_name'],
                    //     'address' => $row['address'],
                    //     'phone' => $row['phone_no'],
                    //     'serial_no' => $row['sn_mem'],
                    //     'agent_id' =>$agents->id,
                    //     'is_active'  => '1',
                    //     'is_leave' => '1',
                    //     'date' => date("Y-m-d"),
                    //     'date_np' => $helper->date_np_con_parm(date("Y-m-d")),
                    //     'time' => date("H:i:s"),
                    //     'created_by' => Auth::user()->id,
                    // ]);
                    // $kista_id = Kista::where('created_by', Auth::user()->id)->pluck('name');
                    // dd($kista_id->toArray());
                    // if($row['1st'] != NULL){
                    //     $details = Detail::create([
                    //         'luckydraw_id' => '1',
                    //         'kista_id' => '1',
                    //         'agent_id' =>$agents->id,
                    //         'client_id' => $clients->id,
                    //         'lottery_status' => '2',
                    //         'amount' => $row['1st'],
                    //         'remaining' => '0',
                    //         'date' => date("Y-m-d"),
                    //         'date_np' => $helper->date_np_con_parm(date("Y-m-d")),
                    //         'time' => date("H:i:s"),
                    //         'created_by' => Auth::user()->id,
                    //     ]);
                    // }
                    // else{
                    //     $details = Detail::create([
                    //         'luckydraw_id' => '1',
                    //         'kista_id' => '1',
                    //         'agent_id' =>$agents->id,
                    //         'client_id' => $clients->id,
                    //         'lottery_status' => '2',
                    //         'amount' => '',
                    //         'remaining' => '0',
                    //         'date' => date("Y-m-d"),
                    //         'date_np' => $helper->date_np_con_parm(date("Y-m-d")),
                    //         'time' => date("H:i:s"),
                    //         'created_by' => Auth::user()->id,
                    //     ]);
                    // }
                    // if($row['2nd'] != NULL){
                    //     $details = Detail::create([
                    //         'luckydraw_id' => '1',
                    //         'kista_id' => '2',
                    //         'agent_id' =>$agents->id,
                    //         'client_id' => $clients->id,
                    //         'lottery_status' => '2',
                    //         'amount' => $row['2nd'],
                    //         'remaining' => '0',
                    //         'date' => date("Y-m-d"),
                    //         'date_np' => $helper->date_np_con_parm(date("Y-m-d")),
                    //         'time' => date("H:i:s"),
                    //         'created_by' => Auth::user()->id,
                    //     ]);
                    // }
                    // else{
                    //     $details = Detail::create([
                    //         'luckydraw_id' => '1',
                    //         'kista_id' => '2',
                    //         'agent_id' =>$agents->id,
                    //         'client_id' => $clients->id,
                    //         'lottery_status' => '2',
                    //         'amount' => '',
                    //         'remaining' => '0',
                    //         'date' => date("Y-m-d"),
                    //         'date_np' => $helper->date_np_con_parm(date("Y-m-d")),
                    //         'time' => date("H:i:s"),
                    //         'created_by' => Auth::user()->id,
                    //     ]);
                    // }

                    // if($row['3rd'] != NULL){
                    //     $details = Detail::create([
                    //         'luckydraw_id' => '1',
                    //         'kista_id' => '3',
                    //         'agent_id' =>$agents->id,
                    //         'client_id' => $clients->id,
                    //         'lottery_status' => '2',
                    //         'amount' => $row['3rd'],
                    //         'remaining' => '0',
                    //         'date' => date("Y-m-d"),
                    //         'date_np' => $helper->date_np_con_parm(date("Y-m-d")),
                    //         'time' => date("H:i:s"),
                    //         'created_by' => Auth::user()->id,
                    //     ]);
                    // }
                    // else{
                    //     $details = Detail::create([
                    //         'luckydraw_id' => '1',
                    //         'kista_id' => '3',
                    //         'agent_id' =>$agents->id,
                    //         'client_id' => $clients->id,
                    //         'lottery_status' => '2',
                    //         'amount' => '',
                    //         'remaining' => '0',
                    //         'date' => date("Y-m-d"),
                    //         'date_np' => $helper->date_np_con_parm(date("Y-m-d")),
                    //         'time' => date("H:i:s"),
                    //         'created_by' => Auth::user()->id,
                    //     ]);
                    // }

                    // if($row['4th'] != NULL){
                    //     $details = Detail::create([
                    //         'luckydraw_id' => '1',
                    //         'kista_id' => '4',
                    //         'agent_id' =>$agents->id,
                    //         'client_id' => $clients->id,
                    //         'lottery_status' => '2',
                    //         'amount' => $row['4th'],
                    //         'remaining' => '0',
                    //         'date' => date("Y-m-d"),
                    //         'date_np' => $helper->date_np_con_parm(date("Y-m-d")),
                    //         'time' => date("H:i:s"),
                    //         'created_by' => Auth::user()->id,
                    //     ]);
                    // }
                    // else{
                    //     $details = Detail::create([
                    //         'luckydraw_id' => '1',
                    //         'kista_id' => '4',
                    //         'agent_id' =>$agents->id,
                    //         'client_id' => $clients->id,
                    //         'lottery_status' => '2',
                    //         'amount' => '',
                    //         'remaining' => '0',
                    //         'date' => date("Y-m-d"),
                    //         'date_np' => $helper->date_np_con_parm(date("Y-m-d")),
                    //         'time' => date("H:i:s"),
                    //         'created_by' => Auth::user()->id,
                    //     ]);
                    // }
                    // if($row['5th'] != NULL){
                    //     $details = Detail::create([
                    //         'luckydraw_id' => '1',
                    //         'kista_id' => '5',
                    //         'agent_id' =>$agents->id,
                    //         'client_id' => $clients->id,
                    //         'lottery_status' => '2',
                    //         'amount' => $row['5th'],
                    //         'remaining' => '0',
                    //         'date' => date("Y-m-d"),
                    //         'date_np' => $helper->date_np_con_parm(date("Y-m-d")),
                    //         'time' => date("H:i:s"),
                    //         'created_by' => Auth::user()->id,
                    //     ]);
                    // }
                    // else{
                    //     $details = Detail::create([
                    //         'luckydraw_id' => '1',
                    //         'kista_id' => '5',
                    //         'agent_id' =>$agents->id,
                    //         'client_id' => $clients->id,
                    //         'lottery_status' => '2',
                    //         'amount' => '',
                    //         'remaining' => '0',
                    //         'date' => date("Y-m-d"),
                    //         'date_np' => $helper->date_np_con_parm(date("Y-m-d")),
                    //         'time' => date("H:i:s"),
                    //         'created_by' => Auth::user()->id,
                    //     ]);
                    // }
                }
                    // dd($lol);
            });
        } catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
        DB::commit();
        
    }
}
