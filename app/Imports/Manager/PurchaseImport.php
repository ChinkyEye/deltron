<?php

namespace App\Imports\Manager;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use App\Helper\Helper;
use App\Purchase;
use Auth;
use Illuminate\Support\Facades\DB;

class PurchaseImport implements ToCollection
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
                    // dd($row[0]);
                    $purchases = Purchase::create([
                        'supplier_name' => $row[0],
                        'item_name' => $row[1],
                        'description' => $row[2],
                        'quantity' => $row[3],
                        'rate' => $row[4],
                        'amount' => $row[3] * $row[4],
                        'is_active'  => '1',
                        'is_leave' => '1',
                        'date' => date("Y-m-d"),
                        'date_np' => $helper->date_np_con_parm(date("Y-m-d")),
                        'time' => date("H:i:s"),
                        'created_by' => Auth::user()->id,
                    ]);
                }
            });
        } catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
        DB::commit();
    }
}
