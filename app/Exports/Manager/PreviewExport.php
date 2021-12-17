<?php

namespace App\Exports\Manager;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use App\Client;

class PreviewExport implements FromCollection, WithHeadings,WithEvents,WithColumnWidths
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

    public function collection()
    {
        $posts = Client::orderBy('id','DESC');
        if($this->agent_id != NULL)
        {            
            $posts = $posts->where('agent_id', 'LIKE',"%{$this->agent_id}%");
        }
        if($this->search != NULL)
        {            
            $posts = $posts->where('serial_no', 'LIKE',"%{$this->search}%");
        }
        $posts = $posts->get();
        $actualdata = $posts->map(function($post){
            return [$post->name,$post->serial_no];
        });
        return $actualdata;
    }
    public function headings(): array
    {
        return
        [
            [
                "Scheme Management System",
            ],
            [
                "Biratnagar".",Morang",
            ],
            [
             'Members Name',
             'Available Serial No',
            ]
        ];
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



                // content
                $event->sheet->getStyle('A3:C3')->applyFromArray([
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
            'A' => 25,
            'B' => 35,
        ];
    }
}
