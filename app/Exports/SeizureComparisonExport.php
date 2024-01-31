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

class SeizureComparisonExport implements FromView, WithStyles, WithDrawings
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
        return view('excel.comparaciondecomisos', [
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

        $supervisor = $this->general['supervised_by'];
        $responsable = $this->general['responsable'];
        $lastRow = 6 + count($this->data);

        if($supervisor?->signature) {
            $signature_supervisor = new Drawing();
            $signature_supervisor->setName('Signature');
            $signature_supervisor->setPath(storage_path('app/public/signatures/'.$supervisor->signature));
            $signature_supervisor->setHeight(52);
            $signature_supervisor->setCoordinates('B'.$lastRow);
            $drawings[] = $signature_supervisor;
        }

        if($responsable?->signature) {
            $signature_responsable = new Drawing();
            $signature_responsable->setName('Signature');
            $signature_responsable->setPath(storage_path('app/public/signatures/'.$responsable->signature));
            $signature_responsable->setHeight(52);
            $signature_responsable->setCoordinates('F'.$lastRow);
            $drawings[] = $signature_responsable;
        }

        return $drawings;
    }

    public function styles(Worksheet $sheet)
    {
        $lastCol = $sheet->getHighestColumn();

        $sheet->getStyle('A1:S4')->getFont()->setName('Arial');
        $sheet->getStyle('E1:P1')->getFont()->setSize(15);
        $sheet->getStyle('A4:S5')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A4:S5')->getFont()->setSize(10);

        // ROW
        $sheet->getRowDimension(1)->setRowHeight(90);
        //COL
        $sheet->getColumnDimension('A')->setWidth(14);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(14);
        $sheet->getColumnDimension('D')->setWidth(13);
        $sheet->getColumnDimension('E')->setWidth(14);
        $sheet->getColumnDimension('F')->setWidth(11);
        $sheet->getColumnDimension('G')->setWidth(11); 
        $sheet->getColumnDimension('H')->setWidth(13); 
        $sheet->getColumnDimension('I')->setWidth(13); 
        $sheet->getColumnDimension('J')->setWidth(13); 
        $sheet->getColumnDimension('K')->setWidth(13); 
        $sheet->getColumnDimension('L')->setWidth(13); 
        $sheet->getColumnDimension('M')->setWidth(13); 
        $sheet->getColumnDimension('N')->setWidth(13); 
        $sheet->getColumnDimension('O')->setWidth(13); 
        $sheet->getColumnDimension('P')->setWidth(13); 
        $sheet->getColumnDimension('Q')->setWidth(13); 
        $sheet->getColumnDimension('R')->setWidth(13); 
        $sheet->getColumnDimension('S')->setWidth(13); 

        // Aquí podrías agregar más estilos si los necesitas
        $sheet->getStyle('A1:'.$lastCol.'4')->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // BORDERS
        $lastRow = 4 + count($this->data);
        $range = 'A1:'.$lastCol.$lastRow;
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
        $sheet->getStyle($range)->getAlignment()->setWrapText(true);
        $sheet->getStyle($range)->applyFromArray($styleArray);
    }
}
