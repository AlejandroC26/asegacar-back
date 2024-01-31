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

class ParturientFemalesExport implements FromView, WithStyles, WithDrawings
{
    private $data;
    private $config;

    public function __construct($data, $config)
    {
        $this->data = $data;
        $this->config = $config;
    }


    public function view(): View
    {
        return view('excel.registrohembrasparidas', [
            "data" => $this->data,
            "config" => $this->config
        ]);
    }
    
    public function drawings()
    {
        $drawings = [];

        $sData = $this->config['signature'];

        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/assets/logo.png'));
        $drawing->setHeight(80);
        $drawing->setOffsetY(5);
        $drawing->setOffsetX(5);
        $drawing->setCoordinates('B1');
        $drawings[] = $drawing;

        if($sData) {
            $signature = new Drawing();
            $signature->setName('Signature');
            $signature->setPath(storage_path('app/public/signatures/'.$sData));
            $signature->setHeight(44);
            $signature->setCoordinates('B9');
            $drawings[] = $signature;
        }

        return $drawings;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A4:H17')->getAlignment()->setWrapText(true);
        // ROW
        $sheet->getRowDimension(1)->setRowHeight(70);
        $sheet->getRowDimension(6)->setRowHeight(30);
        $sheet->getRowDimension(9)->setRowHeight(32);
        $sheet->getRowDimension(21)->setRowHeight(30);
        //COL
        $sheet->getColumnDimension('A')->setWidth(13);
        $sheet->getColumnDimension('B')->setWidth(19);
        $sheet->getColumnDimension('C')->setWidth(14);
        $sheet->getColumnDimension('D')->setWidth(11);
        $sheet->getColumnDimension('E')->setWidth(17);
        $sheet->getColumnDimension('F')->setWidth(11);
        $sheet->getColumnDimension('G')->setWidth(11); 
        $sheet->getColumnDimension('H')->setWidth(11); 
        $sheet->getColumnDimension('I')->setWidth(11); 
        $sheet->getColumnDimension('J')->setWidth(12); 
        $sheet->getColumnDimension('K')->setWidth(12); 

        // Aquí podrías agregar más estilos si los necesitas
        $sheet->getStyle('A1:H21')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);
        $sheet->getStyle('A1:H3')->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        $sheet->getStyle('A4:H21')->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_TOP,
            ],
        ]);
    }
}
