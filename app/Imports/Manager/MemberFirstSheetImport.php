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
use App\LuckyDraw;
use App\ClientHasRefer;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class MemberFirstSheetImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    use Importable;

    public function collection(Collection $collection)
    {
        // dd($collection);

        try{
            return DB::transaction(function() use ($collection)
            {
                // Validator::make($collection->toArray(), [
                Validator::make(array_slice($collection->toArray(), 1), [
                    '*.1' => 'required|distinct|unique:clients,name',
                ])->validate();

                // dd(array_slice($collection->toArray(), 1));
                // Validator::make($collection->toArray(), [
                //     '*.Member Name' => 'required',
                // ])->validate();

                $helper = new Helper();
                foreach (array_slice($collection->toArray(), 1) as $row) 
                {
                    $last_part = array_key_last($row) + 1;
                    $agents = Agent::firstOrCreate([
                        'name' => $row[4],
                        'created_by' => Auth::user()->id,
                    ], [
                        'address' => '',
                        'phone' => '98',
                        'is_active'  => '1',
                        'is_head'  => null,
                        'date' => date("Y-m-d"),
                        'date_np' => $helper->date_np_con_parm(date("Y-m-d")),
                        'time' => date("H:i:s"),
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
                    if($row[5] != NULL){
                        $clienthasrefer = ClientHasRefer::create([
                            'client_id' => $clients->id,
                            'referperson_name' => $row[5],
                            'date' => date("Y-m-d"),
                            'date_np' => $helper->date_np_con_parm(date("Y-m-d")),
                            'time' => date("H:i:s"),
                            'is_active'  => '1',
                            'created_by' => Auth::user()->id,
                        ]);
                    }

                    

                    $firstschemeid = LuckyDraw::where('created_by', Auth::user()->id)->first();
                    $kista  = Kista::where('luckydraw_id',$firstschemeid->id)->pluck('id');
                    $kista_amount = Kista::where('luckydraw_id',$firstschemeid->id)->pluck('amount');
                    // dd($kista,$kista_amount);
                    // 15 25
                    // dd($firstschemeid->id);
                    $count = 0;
                    for ($i=7; $i < $last_part ; $i++) {
                         if($row[$i] != NULL){
                            $details = Detail::create([
                                'luckydraw_id' => $firstschemeid->id,
                                // 'luckydraw_id' => '1',
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
                                'luckydraw_id' => $firstschemeid->id,
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
