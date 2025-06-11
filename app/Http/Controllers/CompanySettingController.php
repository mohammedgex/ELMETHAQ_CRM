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
            'name'            => 'required|string|max:255',
            'address'         => 'nullable|string|max:255',
            'license_number'  => 'nullable|string|max:100',
            'engaz_email'     => 'required|email',
            'engaz_password'  => 'required|string',
            'logo'            => 'nullable|image|max:2048', // max 2MB
        ]);

        $company = CompanySetting::first();

        if (!$company) {
            $company = new CompanySetting();
        }

        // رفع الشعار إذا تم رفعه
        if ($request->hasFile('logo')) {
            // حذف الشعار القديم
            $data['logo'] = $request->file('logo')->store('uploads', 'public');

            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $company->fill($data)->save();

        return redirect()->back()->with('success', 'تم تحديث معلومات الشركة بنجاح');
    }
}
