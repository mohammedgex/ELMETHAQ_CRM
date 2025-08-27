<?php

namespace App\Http\Controllers;

use App\Models\bag;
use App\Models\Customer;
use App\Models\History;
use Carbon\Carbon;
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
            if (!$customer->customerGroup?->visaType?->outgoing_number) {
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
            return redirect()->back()->with('swal_errors', $errors);
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
        if (!$customer->customerGroup?->visaType?->outgoing_number) {
            return redirect()->back()->withErrors(['رقم التأشيرة مفقود.']);
        }

        return view("reports.E_nummber_barcode.index", [
            "code" => $customer->customerGroup?->visaType?->outgoing_number ?? '',
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
    public function transaction_statement_cairo($id)
    {
        $bag = Bag::with('customers.customerGroup.visaType.embassy')->find($id);

        if (!$bag) {
            return redirect()->back()->withErrors(['لم يتم العثور على بيانات الحقيبة.']);
        }

        $customers = $bag->customers->filter(function ($customer) {
            return $customer->customerGroup?->visaType?->embassy?->title === "القاهرة";
        });
        $customers = $customers->filter(function ($customer) {
            return empty($customer->visa_number) || is_null($customer->visa_number);
        });

        if ($customers->isEmpty()) {
            return redirect()->back()->withErrors(['لا توجد معاملات لهذه الحقيبة تخص سفارة القاهرة.']);
        }
        $customers = $customers->toArray();

        return view("reports.Transaction statement.transaction_statement_cairo", compact('bag', 'customers'));
    }

    public function transaction_statement_suez($id)
    {
        $bag = Bag::with('customers.customerGroup.visaType.embassy')->find($id);

        if (!$bag) {
            return redirect()->back()->withErrors(['لم يتم العثور على بيانات الحقيبة.']);
        }

        $customers = $bag->customers->filter(function ($customer) {
            return $customer->customerGroup?->visaType?->embassy?->title === "السويس"
                && empty($customer->visa_number);
        });

        if ($customers->isEmpty()) {
            return redirect()->back()->withErrors(['لا توجد معاملات لهذه الحقيبة تخص قنصلية السويس.']);
        }

        // نحول الـ Collection لآراي
        $customers = $customers->toArray();

        return view("reports.Transaction statement.transaction_statement_souis", compact('bag', 'customers'));
    }

    public function print_visaEntriy($id)
    {
        $customer = Customer::find($id);

        $history = new History();
        $history->description = "تم طباعة طلب الدخول";
        $history->date = Carbon::now();
        $history->customer_id = $customer->id;
        $history->user_id = auth()->id();
        $history->save();

        return view('print-customer.print-entry_application', [
            'customers' => [$customer]
        ]);
    }
}
