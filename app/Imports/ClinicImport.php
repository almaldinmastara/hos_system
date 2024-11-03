<?php

namespace App\Imports;

use App\Models\Clinic;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class ClinicImport implements ToModel ,WithHeadingRow
{

    public function model(array $row)
    {

        if (empty($row['name'])) {
            Log::error('اسم غير موجود في الصف: ' . json_encode($row));
            return null;
        }

        $date = null;


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
               // تعيين قيمة افتراضية لحقل phone إذا كان فارغًا
       $phone = $row['phone'] ?? 'ليس له رقم هاتف';
       $department = $row['department'] ?? 'لم يتم تحديد القسم';

        return new Clinic([
            'name' => $row['name'],
            'date' => $date,
            'department' => $row['department'] ?? null,
            'pleace' => $row['pleace'] ?? null,
            'phone' => $phone,
        ]);
    }
}
