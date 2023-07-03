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

class ZeroGutsToleranceExport implements FromView, WithColumnFormatting, WithStyles, WithDrawings
{
    private $data;
    private $males;
    private $females;
    private $general;

    public function __construct($data, $males, $females, $general)
    {
        $this->data = $data;
        $this->males = $males;
        $this->females = $females;
        $this->general = $general;
    }


    public function view(): View
    {
        return view('excel.toleranciacerovisceras', [
            "data" => $this->data,
            "males" => $this->males,
            "females" => $this->females,
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
        $sheet->getColumnDimension('A')->setWidth(11);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(14);
        $sheet->getColumnDimension('D')->setWidth(13);
        $sheet->getColumnDimension('E')->setWidth(14);
        $sheet->getColumnDimension('F')->setWidth(11);
        $sheet->getColumnDimension('G')->setWidth(11); 
        $sheet->getColumnDimension('H')->setWidth(11); 
        $sheet->getColumnDimension('I')->setWidth(13); 
        $sheet->getColumnDimension('J')->setWidth(13); 
        $sheet->getColumnDimension('K')->setWidth(13); 
        $sheet->getColumnDimension('L')->setWidth(13); 
        $sheet->getColumnDimension('M')->setWidth(15); 
        $sheet->getColumnDimension('N')->setWidth(18); 

        // Aquí podrías agregar más estilos si los necesitas
        $sheet->getStyle('A1:N4')->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // BORDERS
        $lastRow = 4 + count($this->data);
        $range = 'A1:N'.$lastRow;
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
