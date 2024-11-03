<?php

namespace App\Imports;

use App\Models\Amlyat;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NewAmlyatImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
{
    Log::info('Importing row: ' . json_encode($row)); // تتبع البيانات

    // التحقق من وجود اسم العملية
    if (empty($row['amlya'])) {
        Log::error('اسم غير موجود في الصف: ' . json_encode($row));
        return null;
    }

    // معالجة التاريخ
    $date = null;
    if (!empty($row['date'])) {
        try {
            if (is_numeric($row['date'])) {
                // تحويل التاريخ من صيغة Excel إذا كان رقميًا
                $date = ExcelDate::excelToDateTimeObject($row['date'])->format('Y-m-d');
            } else {
                // تحويل التاريخ باستخدام Carbon إذا لم يكن رقميًا
                $date = Carbon::parse($row['date'])->format('Y-m-d');
            }
        } catch (\Exception $e) {
            Log::error('خطأ في تحليل التاريخ: ' . $e->getMessage());
            $date = Carbon::now()->format('Y-m-d'); // تعيين تاريخ اليوم إذا حدث خطأ
        }
    } else {
        // تعيين تاريخ اليوم إذا لم يتم توفير تاريخ
        $date = Carbon::now()->format('Y-m-d');
    }

    Log::info("Final date value: " . $date); // تتبع التاريخ النهائي

    return new Amlyat([
        'amlya' => $row['amlya'],
        'date' => $date,
    ]);
}

}
