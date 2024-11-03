<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\AmlyatExport;
use App\Models\amlyat;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;



class AmlyatController extends Controller
{

  // دالة البحث في العيادات
  public function amlyatSearch(Request $request)
{
    // التحقق من صحة المدخلات
    $request->validate([
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'search' => 'nullable|string',
    ]);

    $searchTerm = trim($request->search);

    $results = amlyat::whereBetween('date', [$request->start_date, $request->end_date])
    ->when($searchTerm, function ($query) use ($searchTerm) {
        return $query->where('amlya', 'LIKE', '%' . $searchTerm . '%');
    })
    ->get();

// جمع القيم في حقل amlya بعد تنفيذ المعادلات
$totalAmlyat = $results->isEmpty() ? 0 : $results->sum(function ($item) {
    // إزالة علامة `=` من بداية المعادلة
    $expression = ltrim($item->amlya, '=');

    // التحقق من وجود تعبير صالح
    if (preg_match('/^[0-9+\-*\/().\s]+$/', $expression)) {
        // تقييم المعادلة للحصول على المجموع
        return eval("return $expression;");
    }

    return 0; // إعادة 0 إذا كانت المعادلة غير صالحة
});

// تحقق من وجود نتائج
if ($totalAmlyat === 0) {
    return back()->withErrors(['error' => 'لا توجد بيانات في مدى التاريخ الذي اخترته.']);
}


// عرض النتائج في الـ view
return view('view_pages.amlyat', compact('results', 'totalAmlyat'));


}


// دالة تنزيل بيانات العيادات
public function amlyatDownload(Request $request)
{
    // نفس المنطق المطبق في دالة البحث لجلب البيانات
    $results = amlyat::whereBetween('date', [$request->start_date, $request->end_date])
                ->when($request->search, function ($query) use ($request) {
                    return $query->where('amlya', 'LIKE', '%' . $request->search . '%');

                })
                ->get();

    return Excel::download(new AmlyatExport($results), 'amlya_results.xlsx');
}













}
