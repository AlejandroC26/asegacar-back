<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class AntemortemInspectionExport implements FromView, WithColumnFormatting, WithStyles, WithDrawings
{
    private $request;
    private $data;

    public function __construct($request, $data)
    {
        $this->request = $request;
        $this->data = $data;
    }


    public function view(): View
    {
        return view('excel.inspeccionantemortem', [
            "request" => $this->request,
            "data" => $this->data
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'L' => '@', // Aquí estableces el formato de la columna L como texto
        ];
    }
    
    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/assets/logo.png'));
        $drawing->setHeight(80);
        $drawing->setOffsetY(5);
        $drawing->setOffsetX(5);
        $drawing->setCoordinates('B1');

        return $drawing;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A4:H17')->getAlignment()->setWrapText(true);
        // ROW
        $sheet->getRowDimension(1)->setRowHeight(70);
        $sheet->getRowDimension(6)->setRowHeight(30);
        $sheet->getRowDimension(16)->setRowHeight(30);
        $sheet->getRowDimension(17)->setRowHeight(30);
        //COL
        $sheet->getColumnDimension('A')->setWidth(11);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(14);
        $sheet->getColumnDimension('D')->setWidth(14);
        $sheet->getColumnDimension('E')->setWidth(14);
        $sheet->getColumnDimension('F')->setWidth(14);
        $sheet->getColumnDimension('G')->setWidth(11); 
        $sheet->getColumnDimension('H')->setWidth(14); 

        // Aquí podrías agregar más estilos si los necesitas
        $sheet->getStyle('A1:H6')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);
        
        $sheet->getStyle('A6:H6')->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A1:H2')->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $lastRow = 6 + count($this->data);
        $sheet->getStyle("A7:H$lastRow")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
    }
}
