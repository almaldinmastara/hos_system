<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\LabImport;
use App\Imports\AywaImport;
use App\Imports\ClinicImport;
use App\Exports\AwyaExport;
use App\Exports\labExport;
use App\Exports\clinicExport;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;


class exporcontroller extends Controller
{
    public function home()
    {

        return view('user.home');

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

    try {
        switch ($uploadType) {
            case 'clinic':
                Excel::import(new ClinicImport, $request->file('file'));
                break;

            case 'lab':
                Excel::import(new LabImport, $request->file('file'));
                break;

            case 'Awya':
                Excel::import(new AywaImport, $request->file('file'));
                break;

            default:
                return back()->withErrors(['error' => 'الرجاء اختيار قسم صحيح']);
        }

        return back()->with('success', 'تم رفع الملف بنجاح!');
    } catch (\Exception $e) {
        Log::error('خطأ في رفع الملف: ' . $e->getMessage());
        return back()->withErrors(['error' => 'حدث خطأ أثناء رفع الملف.']);
    }
}


    public function downloadExcel()
    {
        return Excel::download(new LabExport(), 'alm.xlsx');
    }














}
