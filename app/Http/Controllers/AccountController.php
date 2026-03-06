<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Customer;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    // عرض كشف حساب عميل
    public function index($customer_id)
    {
        $customer = Customer::with('accounts')->findOrFail($customer_id);

        $accounts = $customer->accounts()->latest()->get();

        $totalDebit = $accounts->sum('debit');
        $totalCredit = $accounts->sum('credit');
        $balance = $totalDebit - $totalCredit;

        return view('accounts.index', compact(
            'customer',
            'accounts',
            'totalDebit',
            'totalCredit',
            'balance'
        ));
    }

    // صفحة إضافة عملية
    public function create($customer_id)
    {
        $customer = Customer::findOrFail($customer_id);
        return view('accounts.create', compact('customer'));
    }

    // حفظ العملية
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'debit' => 'nullable|numeric',
            'credit' => 'nullable|numeric',
            'description' => 'nullable|string',
        ]);

        Account::create([
            'customer_id' => $request->customer_id,
            'debit' => $request->debit ?? 0,
            'credit' => $request->credit ?? 0,
            'description' => $request->description,
        ]);

        return redirect()->back()
            ->with('success', 'تم إضافة العملية بنجاح');
    }

    public function customersSummary($group_id)
    {
        $customers = Customer::where('customer_group_id', $group_id)
            ->withSum('accounts as total_debit', 'debit')
            ->withSum('accounts as total_credit', 'credit')
            ->get();

        foreach ($customers as $customer) {
            $customer->balance =
                ($customer->total_debit ?? 0) -
                ($customer->total_credit ?? 0);
        }

        return view('accounts.customers-summary', compact('customers', 'group_id'));
    }
    public function customersSearch(Request $request)
    {
        $search = $request->q;
        $groupId = $request->group_id; // جلب الـ group_id لو موجود

        $query = \App\Models\Customer::query();

        // فلتر بالاسم
        if ($search) {
            $query->where('name_ar', 'LIKE', "%{$search}%");
        }

        // فلتر حسب المجموعة لو معرف
        if ($groupId) {
            $query->where('customer_group_id', $groupId);
        }

        $customers = $query->limit(20)->get();

        return response()->json(
            $customers->map(function ($customer) {
                return [
                    'id' => $customer->id,
                    'text' => $customer->name_ar
                ];
            })
        );
    }

    public function destroy(Account $account)
    {
        $account->delete();

        return back()->with('success', 'تم حذف القيد بنجاح');
    }

    public function accDay(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        $accounts = Account::with('customer')->whereDate('created_at', $date)->get();

        // الحسابات المالية
        $totalDebit = $accounts->sum('debit');
        $totalCredit = $accounts->sum('credit');
        $netBalance = $totalDebit - $totalCredit; // صافي الحركة

        return view('accounts.acc-day', compact('accounts', 'date', 'totalDebit', 'totalCredit', 'netBalance'));
    }
}
