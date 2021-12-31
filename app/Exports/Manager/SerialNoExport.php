<?php

namespace App\Exports\Manager;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Client;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Manager\SerialNoExport;
use App\Exports\Manager\PreviewExport;
use App\Exports\Manager\BookingExport;

class SerialNoExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    protected $agent_id = NULL;
    protected $search = NULL;

    public function __construct($agent_id,$search)
    {
      if($agent_id!="") $this->agent_id = $agent_id;
      if($search!="") $this->search = $search;
    }

    public function sheets(): array
    {
        $sheets = [];
        $agent_id = $this->agent_id;
        $search = $this->search;
        $sheets[] = new PreviewExport($agent_id,$search);
        $sheets[] = new BookingExport($agent_id,$search);
        return $sheets;
    }
}
