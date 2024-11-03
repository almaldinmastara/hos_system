<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ClinicExport;
use App\Models\Clinic;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class ClinicController extends Controller
{

  // دالة البحث في العيادات
  public function clinicSearch(Request $request)
  {
      // التحقق من صحة المدخلات
      $request->validate([
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'clinicsearch' => 'nullable|string',
    ]);

    $searchTerm = trim($request->clinicsearch);
      // تسجيل قيمة البحث
      $results = Clinic::whereBetween('date', [$request->start_date, $request->end_date])
      ->when($searchTerm, function ($query) use ($searchTerm) {
          return $query->where(function($query) use ($searchTerm) {
              $query->where('name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('department', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('pleace', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('phone', 'LIKE', '%' . $searchTerm . '%');
          });
      })
      ->get();

      // التحقق من أن النتائج ليست فارغة
      if ($results->isEmpty()) {
          return back()->withErrors(['error' => 'لا توجد بيانات في هذا النطاق الزمني أو البحث.']);
      }

      // عرض النتائج في الـ view
      return view('view_pages.eyadat', compact('results'));
  }


// دالة تنزيل بيانات العيادات
public function clinicDownload(Request $request)
{
    // نفس المنطق المطبق في دالة البحث لجلب البيانات
    $results = Clinic::whereBetween('date', [$request->start_date, $request->end_date])
                ->when($request->search, function ($query) use ($request) {
                    return $query->where('name', 'LIKE', '%' . $request->search . '%')
                                 ->orWhere('department', 'LIKE', '%' . $request->search . '%')
                                 ->orWhere('pleace', 'LIKE', '%' . $request->search . '%')
                                 ->orWhere('phone', 'LIKE', '%' . $request->search . '%');
                })
                ->get();

    return Excel::download(new ClinicExport($results), 'clinic_results.xlsx');
}


}
