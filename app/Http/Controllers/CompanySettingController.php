<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use Illuminate\Http\Request;

class CompanySettingController extends Controller
{
    //
    public function index()
    {
        $company = CompanySetting::first();
        return view('company.index', compact('company'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name'            => 'required',
            'address'         => 'nullable',
            'license_number'  => 'nullable',
            'engaz_email'     => 'required',
            'engaz_password'  => 'required',
            'logo'            => 'nullable|image',
        ]);

        $company = CompanySetting::first();

        // لو مفيش سجل، ننشئ جديد
        if (!$company) {
            $company = new CompanySetting();
        }

        // تحديث الحقول
        $company->name           = $data['name'];
        $company->address        = $data['address'] ?? null;
        $company->license_number = $data['license_number'] ?? null;
        $company->engaz_email    = $data['engaz_email'];
        $company->engaz_password = $data['engaz_password'];

        // التعامل مع الشعار
        if ($request->hasFile('logo')) {

            $path = $request->file('logo')->store('logos', 'public');
            $company->logo = $path;
        }

        $company->save();

        return redirect()->back()->with('success', 'تم تحديث معلومات الشركة بنجاح');
    }
}
