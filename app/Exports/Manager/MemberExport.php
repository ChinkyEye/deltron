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


// class MemberExport implements FromCollection, WithHeadings,WithEvents,WithColumnWidths
class MemberExport implements  FromView,WithEvents,WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $luckydraw_id = NULL;
    private $agent_id = NULL;

    public function __construct($luckydraw_id,$agent_id)
    {
      if($luckydraw_id!="") $this->luckydraw_id = $luckydraw_id;
      if($agent_id!="") $this->agent_id = $agent_id;
    }

    public function view(): View
    {

        $luckydraw_id = $this->luckydraw_id;
        $agent_id = $this->agent_id;

        $kista_name = Kista::where('luckydraw_id',$luckydraw_id)
                            ->where('is_active','1')
                            ->pluck('name');
        $title = User::where('id', Auth::user()->id)->first();
                        // ->value('name'); 
        $agent_name = Agent::where('is_active','1')
                            ->where('created_by',Auth::user()->id)
                            ->where('id',$agent_id)
                            ->value('name');
        $scheme_name = LuckyDraw::where('is_active','1')
                                ->where('created_by', Auth::user()->id)
                                ->where('id',$luckydraw_id)
                                ->value('name');
                                // dd($scheme_name);                                                       

        $posts = Client::orderBy('id','DESC')
                         ->where('created_by', Auth::user()->id);
                           
        if($this->luckydraw_id != NULL)
        {            
            $posts = $posts->whereHas('getClientDetail', function(Builder $query) use ($luckydraw_id){
                    $query->where('luckydraw_id', $luckydraw_id);
                });
        }
        if($this->agent_id != NULL)
        {            
            $posts = $posts->where('agent_id',$agent_id);
        }
        // $posts = $posts->with('getClientDetail','getAgent','getCount')->get();
        $posts = $posts->with('getAgent','getCount') 
                        ->with(array('getClientDetail'=>function($query) use ($luckydraw_id){
                               $query->select()->where('luckydraw_id',$luckydraw_id);
                           }))->get();
        return view('manager.report.memberreport.memberexport',[
            'posts' => $posts,
            'kista_name' => $kista_name,
            'title' => $title,
            'agent_name' => $agent_name,
            'scheme_name' => $scheme_name,
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
                $event->sheet->mergeCells('A1:N1');
                $event->sheet
                      ->getStyle('A1:N1')
                      ->getFont()
                      ->setBold(true)
                      ->setSize(16)
                      ->setColor( new \PhpOffice\PhpSpreadsheet\Style\Color( \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKGREEN ) );
                $event->sheet
                      ->getStyle('A1:N1')
                      ->getAlignment()
                      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->mergeCells('A2:N2');
                $event->sheet
                      ->getStyle('A2:N2')
                      ->getFont()
                      ->setBold(true)
                      ->setSize(14)
                      ->setColor( new \PhpOffice\PhpSpreadsheet\Style\Color( \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKGREEN ) );
                $event->sheet
                      ->getStyle('A2:N2')
                      ->getAlignment()
                      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->mergeCells('A3:N3');
                $event->sheet
                      ->getStyle('A3:N3')
                      ->getFont()
                      ->setBold(true)
                      ->setSize(10)
                      ->setColor( new \PhpOffice\PhpSpreadsheet\Style\Color( \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKGREEN ) );
                $event->sheet
                      ->getStyle('A3:N3')
                      ->getAlignment()
                      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);      
                // content
                $event->sheet->getStyle('A4:R4')->applyFromArray([
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
            'F' => 10,            
            'G' => 15,            
            'H' => 15,            
            'I' => 15,            
            'J' => 15,            
            'K' => 15,            
            'L' => 15,            
            'M' => 15,            
            'N' => 15,            
        ];
    }
}
