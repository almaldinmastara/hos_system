<?php

namespace App\Imports;

use App\Exports\AwyaExport;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class AywaImport implements ToModel, WithHeadingRow
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
                if (is_numeric($row['date'])) {

                    $date = ExcelDate::excelToDateTimeObject($row['date'])->format('Y-m-d');
                } else {

                    $date = Carbon::parse($row['date'])->format('Y-m-d');
                }
            } catch (\Exception $e) {
                Log::error('خطأ في تحليل التاريخ: ' . $e->getMessage());

                $date = null; // أو يمكنك تعيين قيمة افتراضية مثل '1970-01-01'
            }
        } else {

            $date = Carbon::now()->format('Y-m-d');
        }


        return new AwyaExport([
            'name' => $row['name'],
            'department' => $row['department'] ?? null,
            'date' => $date,
            'phone' => $row['phone'] ?? null,
        ]);


    }
}
