<?php
namespace App\Exports;

use App\Helpers\FormatDateHelper;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithDrawings;

class ZeroToleranceInspectionExport implements FromView, WithStyles, WithDrawings
{
    private $data;
    private $general;

    public function __construct($data, $general)
    {
        $this->data = $data;
        $this->general = $general;
    }


    public function view(): View
    {
        return view('excel.inspeccioncerotolerancia', [
            "data" => $this->data,
            "general" => $this->general
        ]);
    }
    
    public function drawings()
    {

        $drawings = [];

        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/assets/logo.png'));
        $drawing->setHeight(110);
        $drawing->setOffsetY(5);
        $drawing->setOffsetX(5);
        $drawing->setCoordinates('A1');

        $drawings[] = $drawing;

        $supervised = $this->general['supervised_by'];
        $verified = $this->general['verified_by'];
        $lastRow = 8 + count($this->data);

        if($supervised?->signature) {
            $signature_supervised = new Drawing();
            $signature_supervised->setName('Signature');
            $signature_supervised->setPath(storage_path('app/public/signatures/'.$supervised->signature));
            $signature_supervised->setHeight(52);
            $signature_supervised->setCoordinates('B'.$lastRow);
            $drawings[] = $signature_supervised;
        }

        if($verified?->signature) {
            $signature_verified = new Drawing();
            $signature_verified->setName('Signature');
            $signature_verified->setPath(storage_path('app/public/signatures/'.$verified->signature));
            $signature_verified->setHeight(52);
            $signature_verified->setCoordinates('E'.$lastRow);
            $drawings[] = $signature_verified;
        }

        return $drawings;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:S4')->getFont()->setName('Arial');
        $sheet->getStyle('E1:P1')->getFont()->setSize(12);
        $sheet->getStyle('A4:S5')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A4:S5')->getFont()->setSize(10);
        $sheet->getStyle('L4:Q5')->getFont()->setSize(10);

        // ROW
        $sheet->getRowDimension(1)->setRowHeight(90);
        //COL
        $sheet->getColumnDimension('A')->setWidth(11);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(14);
        $sheet->getColumnDimension('D')->setWidth(13);
        $sheet->getColumnDimension('E')->setWidth(14);
        $sheet->getColumnDimension('F')->setWidth(13);
        $sheet->getColumnDimension('G')->setWidth(11); 
        $sheet->getColumnDimension('H')->setWidth(5); 
        $sheet->getColumnDimension('I')->setWidth(13); 
        $sheet->getColumnDimension('J')->setWidth(13); 
        $sheet->getColumnDimension('K')->setWidth(8); 
        $sheet->getColumnDimension('L')->setWidth(8); 
        $sheet->getColumnDimension('M')->setWidth(8); 
        $sheet->getColumnDimension('N')->setWidth(8); 
        $sheet->getColumnDimension('O')->setWidth(18); 
        $sheet->getColumnDimension('P')->setWidth(18); 
        $sheet->getColumnDimension('Q')->setWidth(18); 
        $sheet->getColumnDimension('R')->setWidth(18); 

        // Aquí podrías agregar más estilos si los necesitas
        $sheet->getStyle('A1:R4')->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // BORDERS
        $FirstlastRow = 5 + count($this->data['zeroToleranceInspection']);
        $SecondlastRow = 5 + count($this->data['channelConditioning']);
        
        $lastRow = max($FirstlastRow, $SecondlastRow);

        $range = 'A1:R'.$lastRow;
        $alignmentCenter = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        $alignmentLeft = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        $borders = [ 
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
         
        $sheet->getStyle($range)->getAlignment()->setWrapText(true);
        $sheet->getStyle("A1:R2")->applyFromArray($borders);
        $sheet->getStyle("A4:G$FirstlastRow")->applyFromArray($borders);
        $sheet->getStyle("I4:R$SecondlastRow")->applyFromArray($borders);
        $sheet->getStyle($range)->applyFromArray($alignmentCenter);
        $sheet->getStyle("A3:R3")->applyFromArray($alignmentLeft);
    }
}
