<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Delegate;
use App\Models\Evaluation;
use App\Models\LeadsCustomers;
use App\Models\Test;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\DB;

class DelegateController extends Controller
{
    public function index($id = null)
    {
        $delegateEdit = new Delegate();
        $delegateEdit->name = '';
        $delegateEdit->phone = '';
        $delegateEdit->card_id = '';

        if (!empty($id)) {
            $delegateEdit = Delegate::find($id);
        }

        $delegates = Delegate::all();
        return view('Delegates', [
            'delegates' => $delegates,
            'delegatesEdit' => $delegateEdit
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string|unique:delegates,phone',
            'card_id' => 'required|string',
        ], [
            'phone.unique' => 'رقم الهاتف مسجل بالفعل.',
        ]);

        Delegate::create($request->all());

        return redirect()->back()->with('success', 'تمت إضافة المندوب بنجاح!');
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'card_id' => 'required|string',
        ]);
        $delegate = Delegate::find($id);
        if (!$delegate) {
            return response()->json([
                'error' => 'the delegate is not found.',
            ]);
        }
        $delegate->name = $request->name;
        $delegate->phone = $request->phone;
        $delegate->card_id = $request->card_id;
        $delegate->save();
        return redirect()->route('Delegates.create')->with('edit_success', value: $delegate->name);
    }

    public function delete($id)
    {
        // return $id;
        $delegate = Delegate::find($id);
        if (!$delegate) {
            # code...
            return response()->json([
                'error' => 'the delegate is not find.'
            ]);
        }
        $delegate->delete();
        return redirect()->route('Delegates.create')->with('delete_success', '');
    }

    // طباعة pdf المندوب
    public function downloadPdf($id)
    {
        // Fetch delegate data (change '1' to a dynamic value if needed)
        $delegate = Delegate::find($id);


        // Check if delegate exists
        if (!$delegate) {
            return abort(404, message: 'Delegate not found');
        }

        // Load the Blade view with delegate data
        $pdf = SnappyPdf::loadView('pdf.invoice', ['delegate' => $delegate])
            ->setPaper('a4');

        // Download the PDF
        return $pdf->download("delegate_{$delegate->name}.pdf");
    }

    public function assignDelegate(Request $request)
    {
        # code...
        $request->validate([
            'customers' => 'required|array',
            'delegate' => 'required|exists:delegates,id'
        ]);
        $customers = Customer::whereIn('id', $request->customers)->get();

        foreach ($customers as $customer) {
            $customer->delegate_id = $request->delegate;
            $customer->save();
        }
        return response()->json(['message' => 'تم تعيين المندوب بنجاح']);
    }

    public function statistics($test_id)
    {
        $test = Test::findOrFail($test_id);

        $delegates = Delegate::whereHas('leadsCustomers.tests', function ($q) use ($test_id) {
            $q->where('tests.id', $test_id);
        })->get(['id', 'name']);

        $delegateNames = [];
        $customersCount = [];
        $successCount = [];

        foreach ($delegates as $delegate) {
            // إجمالي العملاء المرتبطين بالاختبار
            $total = LeadsCustomers::where('delegate_id', $delegate->id)
                ->whereHas('tests', fn($q) => $q->where('tests.id', $test_id))
                ->count();

            // أحدث تقييم لكل عميل مرتبط بالاختبار والمندوب
            $latestEvaluations = Evaluation::where('test_id', $test_id)
                ->whereHas('leads', fn($q) => $q->where('delegate_id', $delegate->id))
                ->select('lead_id', DB::raw('MAX(id) as latest_id'))
                ->groupBy('lead_id')
                ->pluck('latest_id');

            // العملاء الناجحين فقط من أحدث تقييم
            $passed = Evaluation::whereIn('id', $latestEvaluations)
                ->where('evaluation', 'مقبول')
                ->count();

            $delegateNames[] = $delegate->name;
            $customersCount[] = $total;
            $successCount[] = $passed;
        }

        // العملاء بدون مندوب
        $withoutDelegateTotal = LeadsCustomers::whereNull('delegate_id')
            ->whereHas('tests', fn($q) => $q->where('tests.id', $test_id))
            ->count();

        $latestEvaluationsWithoutDelegate = Evaluation::where('test_id', $test_id)
            ->whereHas('leads', fn($q) => $q->whereNull('delegate_id'))
            ->select('lead_id', DB::raw('MAX(id) as latest_id'))
            ->groupBy('lead_id')
            ->pluck('latest_id');

        $withoutDelegatePassed = Evaluation::whereIn('id', $latestEvaluationsWithoutDelegate)
            ->where('evaluation', 'مقبول')
            ->count();

        if ($withoutDelegateTotal > 0) {
            $delegateNames[] = 'بدون مندوب';
            $customersCount[] = $withoutDelegateTotal;
            $successCount[] = $withoutDelegatePassed;
        }

        return view('tests.test-statistics', compact('test', 'delegateNames', 'customersCount', 'successCount'));
    }
}
