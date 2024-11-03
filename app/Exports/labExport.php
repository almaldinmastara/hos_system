<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Events\AfterSheet; // تأكد من استيراد AfterSheet
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class LabExport implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting, WithEvents
{
    protected $results;

    public function __construct($results)
    {
        $this->results = $results;
    }

    public function collection()
    {
        return $this->results->map(function ($item) {
            return [
                'name' => $item->name,
                'department' => $item->department,
                'date' => $item->date,
                'analysis' => $item->analysis,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'الاسم',
            'القسم',
            'التاريخ',
            'التحليل',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle('A2:D2')->applyFromArray([
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['argb' => 'FFFFC107'],
            ],
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 14],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);

        for ($i = 3; $i <= 1000; $i++) {
            $sheet->getStyle("A$i:D$i")->applyFromArray([
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => [
                        'argb' => ($i % 2 == 0) ? 'FFE6F7FF' : 'FFFFFFFF',
                    ],
                ],
            ]);

            $sheet->getStyle("A$i:D$i")->applyFromArray($borderStyle);
        }

        $sheet->getStyle('A1:D1000')->applyFromArray($borderStyle);

        $sheet->getStyle('A3:D1000')->applyFromArray([
            'font' => ['size' => 11],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_DATE_YYYYMMDD,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // إعداد اسم الجهة في الصف الأول
                $sheet->mergeCells('A1:D1');
                $sheet->setCellValue('A1', 'الجهة: المختبرات الطبية');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => 'FFCCCCCC'],
                    ],
                ]);
            },
        ];
    }
}
