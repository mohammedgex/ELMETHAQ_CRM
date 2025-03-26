<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Delegate;
use App\Models\DocumentType;
use App\Models\History;
use App\Models\JobTitle;
use App\Models\LeadsCustomers;
use Carbon\Carbon;
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

        $lead['status'] = 'عميل محتمل';
        $lead['customer_id'] = null;

        LeadsCustomers::create($lead);

        return redirect()->back();
    }

    public function show($id)
    {
        # code...
        $lead = LeadsCustomers::find($id);
        return view('leads-customers.leads-customers-show', [
            'lead' => $lead
        ]);
    }

    public function update($id)
    {
        # code...
        $lead = LeadsCustomers::find($id);
        $delegates = Delegate::all();
        $jobs = JobTitle::all();

        return view('leads-customers.leads-customers-edit', [
            'lead' => $lead,
            'delegates' => $delegates,
            'jobs' => $jobs
        ]);
    }
    public function edit(Request $request, $id)
    {
        // جلب البيانات من قاعدة البيانات
        $lead = LeadsCustomers::findOrFail($id);

        // تحديث الحقول النصية والمعلومات الأساسية
        $lead->update([
            'name' => $request->input('name'),
            'age' => $request->input('age'),
            'card_id' => $request->input('card_id'),
            'governorate' => $request->input('governorate'),
            'evaluation' => $request->input('evaluation'),
            'phone' => $request->input('phone'),
            'licence_type' => $request->input('licence_type'),
            'status' => $request->input('status', 'مرحلة الاختبار'), // القيمة الافتراضية
            'test_type' => $request->input('test_type'),
            'registration_date' => $request->input('registration_date'),
            'job_title_id' => $request->input('job_title_id'),
            'delegate_id' => $request->input('delegate_id'),
            'customer_id' => null,
        ]);

        // **تحديث الصور في حالة رفع صور جديدة**
        if ($request->hasFile('image')) {
            $lead->image = $request->file('image')->store('uploads', 'public');
        }
        if ($request->hasFile('passport_photo')) {
            $lead->passport_photo = $request->file('passport_photo')->store('uploads', 'public');
        }
        if ($request->hasFile('img_national_id_card')) {
            $lead->img_national_id_card = $request->file('img_national_id_card')->store('uploads', 'public');
        }
        if ($request->hasFile('license_photo')) {
            $lead->license_photo = $request->file('license_photo')->store('uploads', 'public');
        }

        // حفظ التعديلات
        $lead->save();

        return redirect()->route('leads-customers.index')->with('success', 'تم تحديث البيانات بنجاح');
    }
    public function delete($id)
    {
        // جلب البيانات من قاعدة البيانات
        $lead = LeadsCustomers::findOrFail($id);
        $lead->delete();

        return redirect()->route('leads-customers.index')->with('success', 'تم حذف البيانات بنجاح');
    }

    public function leadToCustomer($leadId)
    {
        # code...
        $lead = LeadsCustomers::find($leadId);
        $customer = new Customer();
        $customer->image = $lead->image;
        $customer->name_ar = $lead->name;
        $customer->age = $lead->age;
        $customer->card_id = $lead->card_id;
        $customer->governorate = $lead->governorate_live;
        $customer->phone = $lead->phone;
        $customer->license_type = $lead->licence_type;
        $customer->card_id = $lead->card_id;
        $customer->job_title_id = $lead->job_title_id;
        $customer->delegate_id = $lead->delegate_id;
        $customer->save();
        $lead->status = 'عميل اساسي';
        $lead->customer_id = $customer->id;
        $lead->save();

        $history = new History();
        $history->description = 'انتقل من عميل محتمل الي عميل اساسي';
        $history->date = Carbon::now();
        $history->customer_id = $customer->id;
        $history->user_id = auth()->id();
        $history->save();

        $passport_photo = new DocumentType();
        $passport_photo->document_type = "جواز السفر";
        $passport_photo->status = "لا يوجد في المكتب";
        $passport_photo->file = $lead->passport_photo;
        $passport_photo->note = 'قادم من عميل محتمل';
        $passport_photo->customer_id = $customer->id;
        $passport_photo->save();

        $img_national_id_card = new DocumentType();
        $img_national_id_card->document_type = "البطاقة الشخصية";
        $img_national_id_card->status = "لا يوجد في المكتب";
        $img_national_id_card->file = $lead->img_national_id_card;
        $img_national_id_card->note = 'قادم من عميل محتمل';
        $img_national_id_card->customer_id = $customer->id;
        $img_national_id_card->save();

        $license_photo = new DocumentType();
        $license_photo->document_type = "صورة الرخصة";
        $license_photo->status = "لا يوجد في المكتب";
        $license_photo->file = $lead->license_photo;
        $license_photo->note = 'قادم من عميل محتمل';
        $license_photo->customer_id = $customer->id;
        $license_photo->save();
        return redirect()->route('customer.indes');
    }
}
