<?php

namespace App\Imports;

use App\Models\Aywa;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class AywaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // التحقق من وجود اسم
        if (empty($row['name'])) {
            Log::error('اسم غير موجود في الصف: ' . json_encode($row));
            return null;
        }

        $date = null;

        // معالجة التاريخ
        if (!empty($row['date'])) {
            try {
                $date = is_numeric($row['date'])
                        ? ExcelDate::excelToDateTimeObject($row['date'])->format('Y-m-d')
                        : Carbon::parse($row['date'])->format('Y-m-d');
            } catch (\Exception $e) {
                Log::error('خطأ في تحليل التاريخ: ' . $e->getMessage());
                $date = Carbon::now()->format('Y-m-d'); // تعيين تاريخ افتراضي
            }
        } else {
            $date = Carbon::now()->format('Y-m-d'); // تعيين تاريخ افتراضي
        }

        // تعيين قيمة افتراضية لحقل الهاتف
        $phone = $row['phone'] ?? 'ليس له رقم هاتف';
        $department = $row['department'] ?? 'لم يتم تحديد القسم';

        return new Aywa([
            'name' => $row['name'],
            'department' => $department,
            'date' => $date,
            'phone' => $phone,
        ]);
    }
}
