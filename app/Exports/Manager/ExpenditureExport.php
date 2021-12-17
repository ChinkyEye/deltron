<?php

namespace App\Exports\Manager;

use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use App\IncomeExpenditure;


class ExpenditureExport implements FromCollection, WithHeadings,WithEvents,WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $luckydraw_id = NULL;
    private $kista_id = NULL;
    private $expenditure_type = NULL;
    public function __construct($luckydraw_id,$kista_id,$expenditure_type)
    {
      if($luckydraw_id!="") $this->luckydraw_id = $luckydraw_id;
      if($kista_id!="") $this->kista_id = $kista_id;
      if($expenditure_type!="") $this->expenditure_type = $expenditure_type;
    }
    
    public function collection()
    {

      $posts = IncomeExpenditure::orderBy('id','DESC')
                                ->where('type','Expenditure');
      if($this->luckydraw_id != NULL)
      {            
        $posts = $posts->where('luckydraw_id', 'LIKE',"%{$this->luckydraw_id}%");
      }
      if($this->kista_id != NULL)
      {            
        $posts = $posts->where('kista_id', 'LIKE',"%{$this->kista_id}%");
      }
      if($this->expenditure_type != NULL)
      {            
        $posts = $posts->where('expenditure_type', 'LIKE',"%{$this->expenditure_type}%");
      }
      $posts = $posts->with('getLuckyDraw','getKista')->get();
      $actualdata = $posts->map(function($post){
        return [$post->getLuckyDraw->name.",".$post->getKista->name,$post->topic,$post->amount];
      });
      return $actualdata;

    }

    public function headings(): array
    {
        return
        [
            [
                // Setting::value('name'),
                "Scheme Management System",
            ],
            [
                // Setting::value('address').", Email: ".Setting::value('email').", Pan: ".Setting::value('pan').", Phone: ".Setting::value('phone'),
                "Biratnagar".",Morang",
            ],
            // [
            //     "Name: ".($this->name ? $this->name : 'All').
            //     ", Supplier: ".($this->supplier_id ? User::where('id',$this->supplier_id)->value('name') : 'All').
            //     ", Category: ".($this->category_id ? Category::where('id',$this->category_id)->value('name'): 'All'),
            // ],    
               
            // [
                
            //     " SubCategory: ".($this->subcategory_id ? SubCategory::where('id',$this->subcategory_id)->value('name') : 'All').
            //     ", Start Date: ".($this->start_date ? $this->start_date : 'All').
            //     ", End Date: ".($this->end_date ? $this->end_date : 'All'),
            // ],
            [
             'Info',
             'Expenditure Topic',
             'Amount',
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

                // $event->sheet->mergeCells('A3:I3');
                // $event->sheet
                //       ->getStyle('A3:I3')
                //       ->getFont()
                //       ->setBold(true)
                //       ->setSize(14)
                //       ->setColor( new \PhpOffice\PhpSpreadsheet\Style\Color( \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKGREEN ) );
                // $event->sheet
                //       ->getStyle('A3:I3')
                //       ->getAlignment()
                //       ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);   

                // $event->sheet->mergeCells('A4:I4');
                // $event->sheet
                //       ->getStyle('A4:I4')
                //       ->getFont()
                //       ->setBold(true)
                //       ->setSize(14)
                //       ->setColor( new \PhpOffice\PhpSpreadsheet\Style\Color( \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKGREEN ) );
                // $event->sheet
                //       ->getStyle('A4:I4')
                //       ->getAlignment()
                //       ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);       


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
            'C' => 35,            
        ];
    }
}
