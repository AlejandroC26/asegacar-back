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
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AntemortemDailyRecordExport implements FromView, WithColumnFormatting, WithStyles, WithDrawings
{
    private $data;
    private $total;
    private $current_date;
    private $benefit_date;

    public function __construct($data, $total, $benefit_date)
    {
        $this->data = $data;
        $this->total = $total;
        $this->benefit_date = $benefit_date;
        $this->current_date = FormatDateHelper::onGetCurrentDate();
    }


    public function view(): View
    {
        return view('excel.registrodiarioantemoren', [
            "data" => $this->data,
            "current_date" => $this->current_date,
            "benefit_date" => $this->benefit_date
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
        $drawing->setOffsetX(50);
        $drawing->setCoordinates('A1');

        return $drawing;
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
        $sheet->getRowDimension(4)->setRowHeight(30);
        $sheet->getRowDimension(5)->setRowHeight(32);
        //COL
        $sheet->getColumnDimension('A')->setWidth(16);
        $sheet->getColumnDimension('B')->setWidth(16);
        $sheet->getColumnDimension('C')->setWidth(16);
        $sheet->getColumnDimension('D')->setWidth(14);
        $sheet->getColumnDimension('E')->setWidth(7);
        $sheet->getColumnDimension('F')->setWidth(7);
        $sheet->getColumnDimension('G')->setWidth(7); 
        $sheet->getColumnDimension('H')->setWidth(14); 
        $sheet->getColumnDimension('I')->setWidth(7); 
        $sheet->getColumnDimension('J')->setWidth(8); 


        // Aquí podrías agregar más estilos si los necesitas
        $sheet->getStyle('A1:J5')->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        // BORDERS
        $lastRow = 5 + $this->total;
        $range = 'A4:J'.$lastRow;
        $styleArray = [
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
        ];
        $sheet->getStyle($range)->getAlignment()->setWrapText(true);
        $sheet->getStyle($range)->applyFromArray($styleArray);

        $backgroundKey = 6;
        foreach ($this->data as $element) {
            if(!$element['outlet'] == 0) {
                $sheet->getStyle('D'.$backgroundKey.':'.'J'.$backgroundKey)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('90CAF9');
             }
            foreach ($element['records'] as $subelement) {
                $backgroundKey += 1;
                if(!$subelement['outlet'] == 0) {
                   $sheet->getStyle('D'.$backgroundKey.':'.'J'.$backgroundKey)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('90CAF9');
                }
            }
        }

        // Celds background
    }
}
