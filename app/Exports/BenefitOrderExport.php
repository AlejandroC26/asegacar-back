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

class BenefitOrderExport implements FromView, WithStyles, WithDrawings
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
        return view('excel.benefitorder', [
            "data" => $this->data,
            "general" => $this->general
        ]);
    }
    
    public function drawings()
    {
        $sData = $this->general['signature'];
        $lastRow = 5 + count($this->data);

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

        if($sData) {
            $signature = new Drawing();
            $signature->setName('Signature');
            $signature->setPath(storage_path('app/public/signatures/'.$sData));
            $signature->setHeight(58);
            $signature->setOffsetX(5);
            $signature->setCoordinates('A'.$lastRow);
            $drawings[] = $signature;
        }

        return $drawings;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:S4')->getFont()->setName('Arial');
        $sheet->getStyle('E1:P1')->getFont()->setSize(15);
        $sheet->getStyle('A4:S5')->getAlignment()->setWrapText(true);
        $sheet->getStyle('L4:Q5')->getFont()->setSize(10);
        $sheet->getStyle('L4:L5')->getFont()->setSize(9);

        // ROW
        $sheet->getRowDimension(1)->setRowHeight(90);
        //COL
        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(28);
        $sheet->getColumnDimension('F')->setWidth(18);


        $sheet->getStyle('A1:F4')->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        
        $sheet->getStyle('A4:F6')->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        // BORDERS
        $lastRow = 4 + count($this->data);
        $range = 'A4:F'.$lastRow;
        $styleArray = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        
        $sheet->getRowDimension($lastRow+1)->setRowHeight(45);

        $sheet->getStyle('A'.($lastRow+1).':F'.($lastRow+4))->applyFromArray(['alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_BOTTOM,
        ]]);
        $sheet->getStyle('A'.($lastRow+3).':F'.($lastRow+4))->getFont()->setSize(8);

        $sheet->getStyle($range)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:F2')->applyFromArray($styleArray);
        $sheet->getStyle($range)->applyFromArray($styleArray);
    }
}
