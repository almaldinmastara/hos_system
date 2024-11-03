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

class AwyaExport implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting, WithEvents
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
                'phone' => $item->phone,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'الاسم', 'القسم', 'التاريخ', 'الهاتف'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // لون الحدود (أسود)
                ],
            ],
        ];

        // تنسيق الهيدر في الصف الثاني
        $sheet->getStyle('A2:D2')->applyFromArray([
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['argb' => 'FFFFC107'], // لون الهيدر
            ],
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 14],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);

        // تلوين الصفوف بالتناوب وإضافة الحدود
        for ($i = 3; $i <= 1000; $i++) {
            $sheet->getStyle("A$i:D$i")->applyFromArray([
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => [
                        'argb' => ($i % 2 == 0) ? 'FFE6F7FF' : 'FFFFFFFF', // لون الصفوف بالتناوب
                    ],
                ],
            ]);

            $sheet->getStyle("A$i:D$i")->applyFromArray($styleArray);
        }

        // إضافة الحدود لجميع الخلايا
        $sheet->getStyle('A1:D1000')->applyFromArray($styleArray);

        // تنسيق بيانات الصفوف
        $sheet->getStyle('A3:D1000')->applyFromArray([
            'font' => ['size' => 11],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_DATE_YYYYMMDD, // تنسيق التاريخ في العمود C
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // إضافة اسم الجهة في السطر الأول
                $sheet->mergeCells('A1:D1'); // دمج الخلايا من A1 إلى D1
                $sheet->setCellValue('A1', 'الجهة: الطب الوقائي'); // تعيين اسم الجهة
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => 'FFCCCCCC'], // لون الخلفية للخلية الأولى
                    ],
                ]);

                // إعداد عناوين الأعمدة في الصف الثاني
                $sheet->getCell('A2')->setValue('الاسم');
                $sheet->getCell('B2')->setValue('القسم');
                $sheet->getCell('C2')->setValue('التاريخ');
                $sheet->getCell('D2')->setValue('الهاتف');

                // تنسيق عناوين الأعمدة
                $sheet->getStyle('A2:D2')->applyFromArray([
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
