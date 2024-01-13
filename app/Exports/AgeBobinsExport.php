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

class AgeBobinsExport implements FromView, WithColumnFormatting, WithStyles, WithDrawings
{
    private $data;
    private $totals;
    private $dates;
    private $config;

    public function __construct($data, $totals, $dates, $config)
    {
        $this->data = $data;
        $this->totals = $totals;
        $this->dates = $dates;
        $this->config = $config;
    }


    public function view(): View
    {
        return view('excel.agebobins', [
            "data" => $this->data,
            "totals" => $this->totals,
            "dates" => $this->dates,
            "config" => $this->config
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
        $drawing->setHeight(70);
        $drawing->setOffsetY(5);
        $drawing->setOffsetX(75);
        $drawing->setCoordinates('A1');

        return $drawing;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:S4')->getFont()->setName('Arial');
        $sheet->getStyle('I1:J2')->getFont()->setSize(11);
        $sheet->getStyle('A4:S5')->getAlignment()->setWrapText(true);

        // ROW
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->getRowDimension(2)->setRowHeight(30);
        //COL
        $sheet->getColumnDimension('A')->setWidth(13);
        $sheet->getColumnDimension('B')->setWidth(13);
        $sheet->getColumnDimension('C')->setWidth(13);
        $sheet->getColumnDimension('D')->setWidth(13);
        $sheet->getColumnDimension('E')->setWidth(13);
        $sheet->getColumnDimension('F')->setWidth(13);
        $sheet->getColumnDimension('G')->setWidth(13); 
        $sheet->getColumnDimension('H')->setWidth(13); 
        $sheet->getColumnDimension('I')->setWidth(13); 
        $sheet->getColumnDimension('J')->setWidth(13); 


        // Aquí podrías agregar más estilos si los necesitas
        $sheet->getStyle('A1:G4')->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        
        $sheet->getStyle('A4:G6')->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        // BORDERS
        $lastRow = 7 + count($this->data);
        $range = 'A1:J'.$lastRow;
        $borderStyle = [
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
        $sheet->getStyle($range)->applyFromArray($borderStyle);
        // PROPOSITO STYLE
        $sheet->getStyle('A'.($lastRow+1).':E'.($lastRow+2+count($this->data)+1))->applyFromArray($borderStyle);
        $sheet->getStyle('A'.($lastRow+1).':E'.($lastRow+2+count($this->data)+1))->getAlignment()->setWrapText(true);
        // GSM STYLE
        $sheet->getStyle('G'.($lastRow+2).':H'.($lastRow+2+count($this->data)+1))->applyFromArray($borderStyle);

    }
}
