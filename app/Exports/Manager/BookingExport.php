<?php

namespace App\Exports\Manager;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use App\Client;
use App\Booking;
use App\User;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BookingExport implements FromView,WithEvents,WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $agent_id = NULL;
    private $search = NULL;
    public function __construct($agent_id,$search)
    {
      if($agent_id!="") $this->agent_id = $agent_id;
      if($search!="") $this->search = $search;
    }

     public function view(): View
    {
        $search = $this->search;
        $agent_id = $this->agent_id;

        $booking = Booking::where('created_by',Auth::user()->id)->where('is_active','1')
                            ->pluck('booked_serialno');
        $booking_array = [];
        foreach ($booking as $key => $child) {
                $booking_array[] = $child;

        }
        $posts = Client::orderBy('id','DESC')
                        ->where('created_by', Auth::user()->id);
        $total = Client::orderBy('id','DESC')
                        ->where('created_by', Auth::user()->id);
        $left = [];
        for ($i=0001; $i < 7000 ; $i++) { 
            $left[]= str_pad($i, 4, '0', STR_PAD_LEFT);
        } 
        $allocated = Client::orderBy('id','DESC')
                            ->where('created_by',Auth::user()->id)
                            ->pluck('serial_no');
        $array = array_diff($left,$allocated->toArray(),$booking_array);

        //new added
        $common_value = array_intersect($allocated->toArray(),$booking_array);
        $booking_arrays = array_diff($booking_array,$common_value);
        //end of new added

        $title = User::where('id', Auth::user()->id)->first();
                        // ->value('name');

        if(empty($this->search))
        {            
            $posts = $posts;
        }
        else{
            $search = $this->search;
            $posts = $posts->where('serial_no',$search);
            $total = $total->where('serial_no',$search);
        }
        if($this->agent_id != NULL)
        {            
             $posts = $posts->where('agent_id',$agent_id);
             $total = $total->where('agent_id',$agent_id);
        }
        $posts = $posts->get();
        $total = $total->count();
        return view('manager.report.previewreport.bookingexport',[
            'previewreports' => $posts,
            'total' => $total,
            'array' => $array,
            'booking_array' => $booking_arrays,
            'title' => $title
        ]);

    }

     public function registerEvents(): array
    {
        return [
            BeforeExport::class  => function(BeforeExport $event) {
                $event->writer->setCreator('Inventory System');
            },
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet
                      ->getPageSetup()
                      ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                // header
                $event->sheet->mergeCells('A1:C1');
                $event->sheet
                      ->getStyle('A1:C1')
                      ->getFont()
                      ->setBold(true)
                      ->setSize(16)
                      ->setColor( new \PhpOffice\PhpSpreadsheet\Style\Color( \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKGREEN ) );
                $event->sheet
                      ->getStyle('A1:C1')
                      ->getAlignment()
                      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->mergeCells('A2:C2');
                $event->sheet
                      ->getStyle('A2:C2')
                      ->getFont()
                      ->setBold(true)
                      ->setSize(14)
                      ->setColor( new \PhpOffice\PhpSpreadsheet\Style\Color( \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKGREEN ) );
                $event->sheet
                      ->getStyle('A2:C2')
                      ->getAlignment()
                      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->mergeCells('A3:C3');
                $event->sheet
                      ->getStyle('A3:C3')
                      ->getFont()
                      ->setBold(true)
                      ->setSize(10)
                      ->setColor( new \PhpOffice\PhpSpreadsheet\Style\Color( \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKGREEN ) );
                $event->sheet
                      ->getStyle('A3:C3')
                      ->getAlignment()
                      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // content
                $event->sheet->getStyle('A4:C4')->applyFromArray([
                    'font' => [
                        'bold' => True,
                        'size' => 10,
                    ]
                ]);


            },
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 50,
        ];
    }

}
