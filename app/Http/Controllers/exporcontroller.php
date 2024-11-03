<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\LabImport;
use App\Imports\AywaImport;
use App\Imports\ClinicImport;
use App\Exports\AwyaExport;
use App\Exports\LabExport;
use Illuminate\Support\Facades\App;
use App\Models\Exportlab;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use App\Models\Aywa;
use App\Imports\NewAmlyatImport;
use App\Models\Clinic;
use App\Models\Amlyat;



class exporcontroller extends Controller
{
    public function home()
    {
     // عدد الفحوصات للسنة الحالية for lab
     $Year = Exportlab::whereYear('date', date('Y'))->count();

     // عدد الفحوصات للشهر الحالي
     $Month = Exportlab::whereMonth('date', date('m'))
         ->whereYear('date', date('Y'))
         ->count();

     // عدد الفحوصات لليوم
     $Today = Exportlab::whereDate('date', date('Y-m-d'))->count();

///////////////////////////////////////////////////////////////////////
// عدد دخول المستشفى للسنة الحالية
$aywa_y = Aywa::whereYear('date', date('Y'))->count();

// عدد دخول المستشفى للشهر الحالي
$aywa_m = Aywa::whereMonth('date', date('m'))
    ->whereYear('date', date('Y'))
    ->count();

// عدد دخول المستشفى لليوم
$aywa_d = Aywa::whereDate('date', date('Y-m-d'))->count();

///////////////////////////////////////////////////////////////////////
// عدد دخول العيادات للسنة الحالية
$Clinic_y = Clinic::whereYear('date', date('Y'))->count();

// عدد دخول العيادات للشهر الحالي
$Clinic_m = Clinic::whereMonth('date', date('m'))
    ->whereYear('date', date('Y'))
    ->count();

// عدد دخول العيادات لليوم
$Clinic_d = Clinic::whereDate('date', date('Y-m-d'))->count();


///////////////////////////////////////////////////////////////////////
// عدد العمليات للسنة الحالية
$Amlyat_y = Amlyat::whereYear('date', date('Y'))->count();

// عدد العمليات للشهر الحالي
$Amlyat_m = Amlyat::whereMonth('date', date('m'))
    ->whereYear('date', date('Y'))
    ->count();

// عدد العمليات لليوم
$Amlyat_d = Amlyat::whereDate('date', date('Y-m-d'))->count();


        return view('user.home', compact('Year', 'Month', 'Today','aywa_y','aywa_m','aywa_d','Clinic_y','Clinic_m','Clinic_d','Amlyat_y','Amlyat_m','Amlyat_d'));

    }


    public function lab()
    {
        return view('view_pages.lab');
    }


    public function ewaa()
    {

        return view('view_pages.ewaa');
    }


    public function eyadat()
    {
        return view('view_pages.eyadat');
    }


    public function amlyat()
    {
        return view('view_pages.amlyat');
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
            'upload_type' => 'required'
        ]);

        $uploadType = $request->input('upload_type');

        set_time_limit(120);

        try {
            switch ($uploadType) {
                case 'clinic':
                    return $this->importClinic($request);
                case 'lab':
                    return $this->importLab($request);
                    case 'surgery':
                        return $this->importAmlyat($request);
                case 'Awya':
                    return $this->importAwya($request);
                default:
                    return back()->withErrors(['error' => 'الرجاء اختيار قسم صحيح']);
            }
        } catch (\Exception $e) {
            // تسجيل تفاصيل الخطأ في السجلات
            Log::error('خطأ في رفع الملف:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            // عرض رسالة خطأ للمستخدم
            return back()->withErrors(['error' => 'حدث خطأ أثناء رفع الملف. يرجى التحقق من السجلات للمزيد من التفاصيل.']);
        }
    }

    private function importClinic(Request $request)
    {
        Excel::import(new ClinicImport, $request->file('file'));
        return back()->with('success', 'تم رفع ملف العيادات بنجاح!');
    }

    private function importLab(Request $request)
    {
        Excel::import(new LabImport, $request->file('file'));
        return back()->with('success', 'تم رفع ملف المعمل بنجاح!');
    }

    private function importAwya(Request $request)
    {
        Excel::import(new AywaImport, $request->file('file'));
        return back()->with('success', 'تم رفع ملف الايواء بنجاح!');
    }
    public function importAmlyat(Request $request)
    {
        Excel::import(new NewAmlyatImport, $request->file('file'));
        return back()->with('success', 'تم رفع ملف العمليات بنجاح!');
    }











 //  كود فلترة بيانات المعمل
 public function search(Request $request)
{
    // التحقق من صحة المدخلات
    $request->validate([
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'search' => 'nullable|string',
    ]);

    $searchTerm = trim($request->search);

    // تسجيل قيمة البحث
    Log::info('Searching Labs:', ['search' => $searchTerm]);

    // تنفيذ البحث
    $results = Exportlab::whereBetween('date', [$request->start_date, $request->end_date])
        ->when($searchTerm, function ($query) use ($searchTerm) {
            // تطبيق شرط البحث على جميع الحقول المرغوبة
            return $query->where(function($query) use ($searchTerm) {
                $query->where('name', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('department', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('analysis', 'LIKE', '%' . $searchTerm . '%');
            });
        })
        ->get();

    // التحقق من أن النتائج ليست فارغة
    if ($results->isEmpty()) {
        return back()->withErrors(['error' => 'لا توجد بيانات في هذا النطاق الزمني أو البحث.']);
    }

    // عرض النتائج في الـ view
    return view('view_pages.lab', compact('results'));
}


 public function download(Request $request)
 {
     // نفس المنطق المطبق في دالة البحث لجلب البيانات
     $results = Exportlab::whereBetween('date', [$request->start_date, $request->end_date])
                 ->when($request->search, function ($query) use ($request) {
                     return $query->where('name', 'LIKE', '%' . $request->search . '%')
                                  ->orWhere('department', 'LIKE', '%' . $request->search . '%')
                                  ->orWhere('analysis', 'LIKE', '%' . $request->search . '%');
                 })
                 ->get();

     return Excel::download(new LabExport($results), 'exportlab_results.xlsx');
 }









}










