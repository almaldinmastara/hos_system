<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use App\Models\Aywa;
use App\Exports\AwyaExport;

class AywaController extends Controller
{
    public function AywaSearch(Request $request)
{
    // التحقق من صحة المدخلات
    $request->validate([
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'AywaSearch' => 'nullable|string', // يجب أن يتطابق مع اسم حقل الإدخال في النموذج
    ]);

    $searchTerm = trim($request->AywaSearch); // تأكد من استخدام الاسم الصحيح

    // تسجيل قيمة البحث
    Log::info('Searching Aywa:', ['search' => $searchTerm]);

    // تنفيذ البحث
    $results = Aywa::whereBetween('date', [$request->start_date, $request->end_date])
        ->when($searchTerm, function ($query) use ($searchTerm) {
            return $query->where(function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('department', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('phone', 'LIKE', '%' . $searchTerm . '%');
            });
        })
        ->get();

    // التحقق من أن النتائج ليست فارغة
    if ($results->isEmpty()) {
        return back()->withErrors(['error' => 'لا توجد بيانات في هذا النطاق الزمني أو البحث.']);
    }

    // عرض النتائج في الـ view
    return view('view_pages.ewaa', compact('results'));
}




// دالة تنزيل بيانات العيادات
public function AywaDownload(Request $request)
{
    // نفس المنطق المطبق في دالة البحث لجلب البيانات
    $results = Aywa::whereBetween('date', [$request->start_date, $request->end_date])
                ->when($request->search, function ($query) use ($request) {
                    return $query->where('name', 'LIKE', '%' . $request->search . '%')
                                 ->orWhere('department', 'LIKE', '%' . $request->search . '%')
                                 ->orWhere('pleace', 'LIKE', '%' . $request->search . '%')
                                 ->orWhere('phone', 'LIKE', '%' . $request->search . '%');
                })
                ->get();

    return Excel::download(new AwyaExport($results), 'Aywa_results.xlsx');
}

















}
