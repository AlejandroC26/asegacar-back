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
use PhpOffice\PhpSpreadsheet\Style\Fill;

class DispatchGuideExport implements FromView, WithStyles, WithDrawings
{
    private $data;
    private $config;

    private $outline;
    private $none;
    private $center;

    public function __construct($data, $config)
    {
        $this->data = $data;
        $this->config = $config;
        $this->outline = [
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $this->none = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_NONE, // Elimina todos los bordes
                ],
            ],
        ];
        $this->center = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ]
        ];
    }


    public function view(): View
    {
        return view('excel.guiadespacho', [
            "data" => $this->data,
            "config" => $this->config
        ]);
    }
    
    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/assets/informationlogo.png'));
        $drawing->setHeight(40);
        $drawing->setOffsetY(5);
        $drawing->setOffsetX(5);
        $drawing->setCoordinates('A1');

        return $drawing;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A4:Q13')->getAlignment()->setWrapText(true);
        // ROW
        $sheet->getRowDimension(1)->setRowHeight(22);
        $sheet->getRowDimension(4)->setRowHeight(22);
        //COL
        $sheet->getColumnDimension('A')->setWidth(3);
        $sheet->getColumnDimension('B')->setWidth(3);
        $sheet->getColumnDimension('C')->setWidth(6);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(2);
        $sheet->getColumnDimension('F')->setWidth(6);
        $sheet->getColumnDimension('G')->setWidth(9); 
        $sheet->getColumnDimension('H')->setWidth(7); 
        $sheet->getColumnDimension('I')->setWidth(2); 
        $sheet->getColumnDimension('J')->setWidth(16); 
        $sheet->getColumnDimension('K')->setWidth(15); 
        $sheet->getColumnDimension('L')->setWidth(13); 
        $sheet->getColumnDimension('M')->setWidth(10); 
        $sheet->getColumnDimension('N')->setWidth(7); 
        $sheet->getColumnDimension('O')->setWidth(6); 
        $sheet->getColumnDimension('P')->setWidth(6); 
        $sheet->getColumnDimension('Q')->setWidth(6); 

        //BORDES
        $sheet->getStyle('A1:Q27')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFFFFF'], 
            ],
        ]);
        $sheet->getStyle('A4:Q27')->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_TOP,
            ],
        ]);
        $sheet->getStyle('H1:Q2')->applyFromArray($this->none);
        $sheet->getStyle('H1:Q2')->applyFromArray($this->outline);
        $sheet->getStyle('A6:Q8')->applyFromArray($this->none);
        $sheet->getStyle('A6:Q8')->applyFromArray($this->outline);
        $sheet->getStyle('A10:Q11')->applyFromArray($this->none);
        $sheet->getStyle('A10:Q11')->applyFromArray($this->outline);
        $sheet->getStyle('A12:Q12')->applyFromArray($this->none);
        $sheet->getStyle('A12:Q12')->applyFromArray($this->outline);
        // Aquí podrías agregar más estilos si los necesitas
        $sheet->getStyle('A1:Q1')->getFont()->setSize(14);
        $sheet->getStyle('A2:Q2')->getFont()->setSize(10.5);
        $sheet->getStyle('A3:H3')->getFont()->setSize(9);
        $sheet->getStyle('L13:L13')->getFont()->setSize(8);
        $sheet->getStyle('A1:Q4')->applyFromArray($this->center);
        $sheet->getStyle('A13:Q13')->applyFromArray($this->center);
        $sheet->getStyle('A26:H26')->getFont()->setSize(9);
        $sheet->getStyle('A26:H27')->applyFromArray($this->center);

        $sheet->getStyle('J4')->getFont()->setSize(14);
        $sheet->getStyle('K3:L4')->getFont()->setSize(16);
        $sheet->getStyle('M3:M4')->getFont()->setSize(16);
        $sheet->getStyle('G14:G21')->getFont()->setSize(8);
        $sheet->getStyle('H14:J21')->getFont()->setSize(12);
        $sheet->getStyle('H14:J21')->applyFromArray(['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]]);
    }
}
