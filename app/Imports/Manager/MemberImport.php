<?php

namespace App\Imports\Manager;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


// class MemberImport implements ToCollection
class MemberImport implements WithMultipleSheets
{

    public function sheets(): array
    {
        return [
            0 => new MemberFirstSheetImport(),
        ];
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        
    }
}
