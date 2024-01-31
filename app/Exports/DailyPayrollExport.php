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
use Maatwebsite\Excel\Events\AfterSheet;

class DailyPayrollExport implements FromView, WithStyles, WithDrawings
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
        return view('excel.forbovinos', [
            "data" => $this->data,
            "males" => $this->males,
            "females" => $this->females,
            "general" => $this->general
        ]);
    }

    public function drawings()
    {
        $drawings = [];

        $sData = $this->general['signature'];
        $lastRow = 7 + count($this->data);

        $logo = new Drawing();
        $logo->setName('Logo');
        $logo->setPath(public_path('/assets/logo.png'));
        $logo->setHeight(110);
        $logo->setOffsetY(5);
        $logo->setOffsetX(5);
        $logo->setCoordinates('A1');
        $drawings[] = $logo;
        
        if($sData) {
            $signature = new Drawing();
            $signature->setName('Signature');
            $signature->setPath(storage_path('app/public/signatures/'.$sData));
            $signature->setHeight(58);
            $signature->setOffsetX(5);
            $signature->setCoordinates('B'.$lastRow);
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
        $sheet->getRowDimension(2)->setRowHeight(32);
        $sheet->getRowDimension(4)->setRowHeight(32);
        $sheet->getRowDimension(5)->setRowHeight(32);
        //COL
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('E')->setWidth(18);
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->getColumnDimension('G')->setWidth(16); 


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
        $lastRow = 5 + count($this->data);
        $range = 'A1:G'.$lastRow;
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
