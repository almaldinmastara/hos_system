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

class AmlyatExport implements FromCollection, WithStyles, WithEvents
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
                'amlya' => $item->amlya,
                'date' => $item->date,
            ];
        });
    }

    public function styles(Worksheet $sheet)
    {
        // إعدادات الحدود
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // لون الحدود (أسود)
                ],
            ],
        ];

        // تلوين الصفوف بالتناوب وإضافة الحدود
        for ($i = 3; $i <= 1000; $i++) { // نبدأ من الصف الثالث
            // تلوين الصفوف بالتناوب
            $sheet->getStyle("A$i:B$i")->applyFromArray([
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => [
                        'argb' => ($i % 2 == 0) ? 'FFE6F7FF' : 'FFFFFFFF', // لون الصفوف بالتناوب
                    ],
                ],
            ]);

            // إضافة الحدود
            $sheet->getStyle("A$i:B$i")->applyFromArray($styleArray);
        }

        // إضافة الحدود لجميع الخلايا
        $sheet->getStyle('A1:B1000')->applyFromArray($styleArray);

        // تنسيق بيانات الصفوف
        $sheet->getStyle('A3:B1000')->applyFromArray([
            'font' => ['size' => 11],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_YYYYMMDD, // تنسيق التاريخ في العمود B
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // إضافة اسم الجهة في السطر الأول
                $sheet->mergeCells('A1:B1'); // دمج الخلايا
                $sheet->setCellValue('A1', 'الجهة: العمليات '); // إضافة اسم الجهة
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => 'FFCCCCCC'], // لون الخلفية للخلية الأولى
                    ],
                ]);

                // إضافة أسماء الأعمدة في السطر الثاني
                $sheet->getCell('A2')->setValue('العمليات'); // عنوان العمود الأول
                $sheet->getCell('B2')->setValue('التاريخ'); // عنوان العمود الثاني

                // تنسيق عناوين الأعمدة
                $sheet->getStyle('A2:B2')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => 'CCCCFF'], // لون الهيدر
                    ],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
            },
        ];
    }
}
