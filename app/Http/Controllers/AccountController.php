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

        return view('accounts.customers-summary', compact('customers'));
    }
    public function customersSearch(Request $request)
    {
        $search = $request->q;

        $customers = \App\Models\Customer::where('name_ar', 'LIKE', "%{$search}%")
            ->limit(20)
            ->get();

        return response()->json(
            $customers->map(function ($customer) {
                return [
                    'id' => $customer->id,
                    'text' => $customer->name_ar
                ];
            })
        );
    }
}
