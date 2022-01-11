<?php

namespace App\Exports\Manager;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use App\Detail;
use App\Client;
use App\Kista;
use App\Agent;
use App\User;
use App\LuckyDraw;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class MemberListExport implements  FromView,WithEvents,WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $agentid = NULL;

    public function __construct($agentid)
    {
      if($agentid!="") $this->agentid = $agentid;
    }

    public function view(): View
    {

        $agentid = $this->agentid;

        $title = User::where('id', Auth::user()->id)->first();
                        // ->value('name'); 
        $agent_name = Agent::where('is_active','1')
                            ->where('created_by',Auth::user()->id)
                            ->where('id',$agentid)
                            ->value('name');

        $posts = Client::orderBy('id','DESC')
                         ->where('created_by', Auth::user()->id);

        if($this->agentid != NULL)
        {            
            $posts = $posts->where('agent_id',$agentid);
        }
        $posts = $posts->with('getAgent')->get();
        return view('manager.report.memberlistreport.memberlistexport',[
            'posts' => $posts,
            'title' => $title,
            'agent_name' => $agent_name,
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
            'B' => 20,
            'C' => 20,            
            'D' => 20,            
            'E' => 20,            
            'F' => 20,            
        ];
    }
}

