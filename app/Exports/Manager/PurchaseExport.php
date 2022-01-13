<?php

namespace App\Exports\Manager;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use App\Purchase;
use App\User;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PurchaseExport implements FromView,WithEvents,WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $start_date = NULL;
    private $end_date = NULL;
    public function __construct($start_date,$end_date)
    {
         if($start_date!="") $this->start_date = $start_date;
         if($end_date!="") $this->end_date = $end_date;
    }
    public function view(): View
    {
        $title = User::where('id', Auth::user()->id)->first();
                        // ->value('name');
        $posts = Purchase::orderBy('id','DESC')
                        ->where('created_by', Auth::user()->id);
        if(($this->start_date != NULL) || ($this->end_date != NULL))
        {
            $posts = $posts->whereBetween('date', [$this->start_date, $this->end_date]);
        }
        $posts = $posts->get();
        return view('manager.report.purchasereport.purchaseexport',[
            'purchasereports' => $posts,
            'title' => $title,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);


    }
    // public function collection()
    // {
    //     $posts = Purchase::orderBy('id','DESC')
    //                     ->where('created_by', Auth::user()->id);
    //     if(($this->start_date != NULL) || ($this->end_date != NULL))
    //     {
    //         $posts = $posts->whereBetween('date', [$this->start_date, $this->end_date]);
    //     }
    //     $posts = $posts->get();
    //     $actualdata = $posts->map(function($post){
    //         return [$post->id,$post->supplier_name,$post->item_name,$post->amount,$post->date_np];
    //     });
    //     return $actualdata;
    // }
    // public function headings(): array
    // {
    //     return
    //     [
    //         [
    //             "Scheme Management System",
    //         ],
    //         [
    //             "Biratnagar".",Morang",
    //         ],
    //         [
    //          'SN',
    //          'Supplier Name',
    //          'Item Name',
    //          'Amount',
    //          'Date',
    //         ]
    //     ];
    // }

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
                $event->sheet->mergeCells('A1:F1');
                $event->sheet
                      ->getStyle('A1:F1')
                      ->getFont()
                      ->setBold(true)
                      ->setSize(16)
                      ->setColor( new \PhpOffice\PhpSpreadsheet\Style\Color( \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKGREEN ) );
                $event->sheet
                      ->getStyle('A1:F1')
                      ->getAlignment()
                      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->mergeCells('A2:F2');
                $event->sheet
                      ->getStyle('A2:F2')
                      ->getFont()
                      ->setBold(true)
                      ->setSize(14)
                      ->setColor( new \PhpOffice\PhpSpreadsheet\Style\Color( \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKGREEN ) );
                $event->sheet
                      ->getStyle('A2:F2')
                      ->getAlignment()
                      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->mergeCells('A3:F3');
                $event->sheet
                      ->getStyle('A3:F3')
                      ->getFont()
                      ->setBold(true)
                      ->setSize(10)
                      ->setColor( new \PhpOffice\PhpSpreadsheet\Style\Color( \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKGREEN ) );
                $event->sheet
                      ->getStyle('A3:F3')
                      ->getAlignment()
                      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);      



                // content
                $event->sheet->getStyle('A4:F4')->applyFromArray([
                    'font' => [
                        'bold' => True,
                        'size' => 12,
                    ]
                ]);


            },
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 25,
            'C' => 35,
            'D' => 35,
            // 'E' => 25,
            'F' => 25,
        ];
    }
}
