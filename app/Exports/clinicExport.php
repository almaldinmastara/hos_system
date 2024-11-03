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
use Illuminate\Support\Collection;



class ClinicExport implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting, WithEvents
{
    protected $results;

    public function __construct(Collection $results)
    {
        $this->results = $results;
    }

    public function collection()
    {
        return $this->results->map(function ($item) {
            return [
                'name' => $item->name,
                'date' => $item->date,
                'department' => $item->department,
                'pleace' => $item->pleace,
                'phone' => $item->phone,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'الاسم',
            'التاريخ',
            'القسم',
            'المكان',
            'الهاتف',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // لون الحدود (أسود)
                ],
            ],
        ];

        // تنسيق الهيدر في الصف الثاني
        $sheet->getStyle('A2:E2')->applyFromArray([
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['argb' => 'FFFFC107'], // لون الهيدر
            ],
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 14],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);

        // تلوين الصفوف بالتناوب وإضافة الحدود
        for ($i = 3; $i <= 1000; $i++) {
            $sheet->getStyle("A$i:E$i")->applyFromArray([
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => [
                        'argb' => ($i % 2 == 0) ? 'FFE6F7FF' : 'FFFFFFFF', // لون الصفوف بالتناوب
                    ],
                ],
            ]);

            $sheet->getStyle("A$i:E$i")->applyFromArray($borderStyle);
        }

        // إضافة الحدود لجميع الخلايا
        $sheet->getStyle('A1:E1000')->applyFromArray($borderStyle);

        // تنسيق بيانات الصفوف
        $sheet->getStyle('A3:E1000')->applyFromArray([
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

                // إضافة اسم الجهة في الصف الأول
                $sheet->mergeCells('A1:E1'); // دمج الخلايا من A1 إلى E1
                $sheet->setCellValue('A1', 'الجهة:  العيادات'); // تعيين اسم الجهة
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => 'FFCCCCCC'], // لون الخلفية للخلية الأولى
                    ],
                ]);
            },
        ];
    }
}
