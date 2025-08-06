<?php

namespace App\Http\Controllers;

use App\Models\bag;
use App\Models\Customer;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    //
    public function showReportes($id)
    {
        # code...
        $customer = Customer::find($id);
        if (!$customer) {
            return redirect()->back()->withErrors(['لم يتم العثور على بيانات العميل.']);
        }

        return view("reports.show", compact('customer'));
    }

    public function nomination_card($id)
    {
        # code...
        $customer = Customer::find($id);
        $errors = [];

        if (!$customer) {
            $errors[] = 'لم يتم العثور على بيانات العميل.';
        } else {
            if (!$customer->name_ar) {
                $errors[] = 'الاسم العربي للعميل مفقود.';
            }
            if (!$customer->customerGroup?->visaType?->embassy?->title) {
                $errors[] = 'عنوان السفارة مفقود.';
            }
            if (!$customer->customerGroup?->visaProfession?->job) {
                $errors[] = 'المسمى الوظيفي في التأشيرة مفقود.';
            }
            if (!$customer->e_visa_number) {
                $errors[] =  'الـ E Number مفقود.';
            }
            if (!$customer->visa_number) {
                $errors[] = 'رقم التأشيرة مفقود.';
            }
            if (!$customer->customerGroup?->visaType?->issuing_visa) {
                $errors[] = 'جهة إصدار التأشيرة مفقودة.';
            }
            if (!$customer->customerGroup?->visaType?->sponser?->name) {
                $errors[] = 'اسم الكفيل مفقود.';
            }
            if (!$customer->image) {
                $errors[] = 'الصورة الشخصية مفقودة.';
            }
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors);
        }


        return view("reports.nomination_card.nomination_card", compact('customer'));
    }

    public function E_number_barcode($id)
    {
        # code...
        $customer = Customer::find($id);
        if (!$customer) {
            return redirect()->back()->withErrors(['لم يتم العثور على بيانات العميل.']);
        }
        if (!$customer->e_visa_number) {
            return redirect()->back()->withErrors(['الـ E Number مفقود.']);
        }

        return view("reports.E_nummber_barcode.index", [
            "code" => $customer->e_visa_number,
        ]);
    }

    public function visaNumberBarcode($id)
    {
        # code...
        $customer = Customer::find($id);
        if (!$customer) {
            return redirect()->back()->withErrors(['لم يتم العثور على بيانات العميل.']);
        }
        if (!$customer->visa_number) {
            return redirect()->back()->withErrors(['رقم التأشيرة مفقود.']);
        }

        return view("reports.E_nummber_barcode.index", [
            "code" => $customer->visa_number,
        ]);
    }

    public function transaction_statement($id)
    {
        // جلب الحقيبة مع العملاء ومع العلاقات المطلوبة (eager load)
        $bag = Bag::with('customers.customerGroup.visaType')->find($id);

        if (!$bag) {
            return redirect()->back()->withErrors(['لم يتم العثور على بيانات الحقيبة.']);
        }

        $customers = $bag->customers;
        if ($customers->isEmpty()) {
            return redirect()->back()->withErrors(['لا توجد معاملات لهذه الحقيبة.']);
        }

        // اختيار الـ view بناءً على عنوان السفارة بأمان (null-safe)
        $embassyTitle = $customers->first()->customerGroup?->visaType?->embassy?->title ?? null;

        if ($embassyTitle === "القاهرة") {
            return view("reports.Transaction statement.transaction_statement_cairo", compact('bag', 'customers'));
        } elseif ($embassyTitle === "السويس") {
            return view("reports.Transaction statement.transaction_statement_souis", compact('bag', 'customers'));
        }

        return redirect()->back()->withErrors(['نوع السفارة غير مدعوم.']);
    }
}
