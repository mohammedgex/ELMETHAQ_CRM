<?php

namespace App\Http\Controllers;

use App\Models\Delegate;
use App\Models\JobTitle;
use App\Models\LeadsCustomers;
use Illuminate\Http\Request;

class LeadsCustomersController extends Controller
{
    //
    public function index()
    {
        # code...
        $leads = LeadsCustomers::all();
        $delegates = Delegate::all();
        $jobs = JobTitle::all();
        return view('leads-customers.leads-customers', [
            'leads' => $leads,
            'jobs' => $jobs,
            'delegates' => $delegates
        ]);
    }
    public function create(Request $request)
    {
        // التحقق من صحة البيانات
        // $validatedData = $request->validate([
        //     'name' => 'required',
        //     'image' => 'required',
        //     'passport_photo' => 'required',
        //     'img_national_id_card' => 'required',
        //     'license_photo' => 'required',
        //     'age' => 'required',
        //     'card_id' => 'required',
        //     'governorate' => 'required',
        //     'evaluation' => 'required',
        //     'phone' => 'required',
        //     'licence_type' => 'required',
        //     'status' => 'required',
        //     'test_type' => 'required',
        //     'registration_date' => 'required',
        //     'job_title_id' => 'required',
        //     'delegate_id' => 'required',
        // ]);
        $lead = $request->all();

        // رفع الصور إذا كانت موجودة
        if ($request->hasFile('image')) {
            $lead['image'] = $request->file('image')->store('uploads', 'public');
        }
        if ($request->hasFile('passport_photo')) {
            $lead['passport_photo'] = $request->file('passport_photo')->store('uploads', 'public');
        }
        if ($request->hasFile('img_national_id_card')) {
            $lead['img_national_id_card'] = $request->file('img_national_id_card')->store('uploads', 'public');
        }
        if ($request->hasFile('license_photo')) {
            $lead['license_photo'] = $request->file('license_photo')->store('uploads', 'public');
        }

        $lead['status'] = 'مرحلة الاختبار';
        $lead['customer_id'] = null;

        LeadsCustomers::create($lead);

        return redirect()->back();
    }
}
