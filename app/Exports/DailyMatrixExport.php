<?php
namespace App\Exports;

use App\Helpers\FormatDateHelper;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Carbon\Carbon;

class DailyMatrixExport implements FromView, WithColumnFormatting, WithStyles, WithDrawings
{
    private $data;
    private $format_code;
    private $benefit_date;


    public function __construct($data, $format_code, $benefit_date)
    {
        $this->data = $data;
        $this->format_code = $format_code;
        $this->benefit_date = $benefit_date;
    }


    public function view(): View
    {
        $cur_date = Carbon::parse(now());
        $issue_date = mb_strtoupper(FormatDateHelper::onNumberToMonth(intval($cur_date->format('m')))).' '.$cur_date->format('Y');

        $format_code = $this->format_code;
        $benefit_date = $this->benefit_date;

        return view('excel.dailymatrix', [
            "data" => $this->data,
            "format_code" =>$format_code,
            "issue_date" => $issue_date,
            "benefit_date" => $benefit_date
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
        $drawing->setCoordinates('B1');

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
        $sheet->getColumnDimension('A')->setWidth(18);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('G')->setWidth(16); // EDAD
        $sheet->getColumnDimension('I')->setWidth(21); // PROPÓSITO
        $sheet->getColumnDimension('J')->setWidth(19); // COLOR
        $sheet->getColumnDimension('K')->setWidth(22); // NO EXPENDIOS
        $sheet->getColumnDimension('L')->setWidth(22);
        $sheet->getColumnDimension('L')->setWidth(22);
        $sheet->getColumnDimension('M')->setWidth(22);
        $sheet->getColumnDimension('N')->setWidth(26); // PROPIETARIO
        $sheet->getColumnDimension('O')->setWidth(21); // PROPIETARIO ID
        $sheet->getColumnDimension('P')->setWidth(26); // COMPRADOR
        $sheet->getColumnDimension('Q')->setWidth(24); // PREDIO
        $sheet->getColumnDimension('R')->setWidth(20); // MUNICIPIO
        $sheet->getColumnDimension('S')->setWidth(20); // DEPARTAMENTO


        $sheet->getStyle('A1:S6')->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        // BORDERS
        $lastRow = 5 + count($this->data);
        $range = 'A1:S'.$lastRow;
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
        // FOOTER
        $sheet->getStyle('A'.($lastRow+1).':F'.$lastRow+2)->applyFromArray($styleArray);
        $sheet->getStyle('E'.($lastRow+1).':F'.$lastRow+2)->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);
    }
}
