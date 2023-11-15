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
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class VisceraDispatchExport implements FromView, WithColumnFormatting, WithStyles, WithDrawings
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
        return view('excel.verificacionsalidaproductos', [
            "data" => $this->data,
            "general" => $this->general
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
        $drawing->setHeight(110);
        $drawing->setOffsetY(5);
        $drawing->setOffsetX(5);
        $drawing->setCoordinates('A1');

        return $drawing;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:S4')->getFont()->setName('Arial');
        $sheet->getStyle('E1:P1')->getFont()->setSize(15);
        $sheet->getStyle('A4:S5')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A4:S5')->getFont()->setSize(10);
        $sheet->getStyle('L4:Q5')->getFont()->setSize(10);
        $sheet->getStyle('L4:L5')->getFont()->setSize(9);

        // ROW
        $sheet->getRowDimension(1)->setRowHeight(90);
        //COL
        $sheet->getColumnDimension('A')->setWidth(4);
        $sheet->getColumnDimension('B')->setWidth(7);
        $sheet->getColumnDimension('C')->setWidth(7);
        $sheet->getColumnDimension('D')->setWidth(7);
        $sheet->getColumnDimension('E')->setWidth(7);
        $sheet->getColumnDimension('F')->setWidth(7);
        $sheet->getColumnDimension('G')->setWidth(7); 
        $sheet->getColumnDimension('H')->setWidth(7); 
        $sheet->getColumnDimension('I')->setWidth(7); 
        $sheet->getColumnDimension('J')->setWidth(7); 
        $sheet->getColumnDimension('K')->setWidth(7); 
        $sheet->getColumnDimension('L')->setWidth(7); 
        $sheet->getColumnDimension('M')->setWidth(7); 
        $sheet->getColumnDimension('N')->setWidth(7); 
        $sheet->getColumnDimension('O')->setWidth(7); 
        $sheet->getColumnDimension('P')->setWidth(17); 

        // Aquí podrías agregar más estilos si los necesitas
        $sheet->getStyle('A1:P4')->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // BORDERS
        $lastRow = 4 + count($this->data);
        $range = 'A1:P'.$lastRow;
        $styleArray = [
            'font' => [ 'size' => 8 ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
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
        $sheet->getStyle('B'.($lastRow+1).':P'.$lastRow+3)->applyFromArray($styleArray);
        $sheet->getStyle('B'.($lastRow+1).':P'.$lastRow+3)->getFont()->setSize(8);
    }
}
