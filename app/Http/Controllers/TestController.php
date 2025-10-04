<?php

namespace App\Http\Controllers;

use App\Models\CustomerGroup;
use App\Models\Evaluation;
use App\Models\LeadsCustomers;
use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function index()
    {
        $tests = Test::withCount('leads')->latest()->get();
        return view('tests.index', compact('tests'));
    }

    /**
     * عرض نموذج إنشاء اختبار جديد
     */
    public function create()
    {
        return view('tests.create');
    }

    /**
     * حفظ اختبار جديد في قاعدة البيانات
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:tests,title',
        ], [
            'title.unique' => 'هذا الاسم موجود بالفعل.',
        ]);

        Test::create([
            'title' => $request->title,
        ]);

        return redirect()->route('test.index')->with('success', 'تم إنشاء الاختبار بنجاح');
    }

    /**
     * حذف اختبار
     */
    public function destroy($id)
    {
        $test = Test::findOrFail($id);
        $test->delete();

        return redirect()->route('test.index')->with('success', 'تم حذف الاختبار بنجاح');
    }

    public function showClients(Test $test)
    {
        $clients = $test->clients()->get();
        return view('tests.clients', compact('test', 'clients'));
    }

    public function customerTest($test_id)
    {
        # code...
        $test = Test::find($test_id);
        $groups = CustomerGroup::all();
        $tests = Test::latest()->get();
        return view("tests.customers-test", [
            "leads" => $test->leads,
            "test" => $test,
            "groups" => $groups,
            "tests" => $tests
        ]);
    }
    public function addCustomers(Request $request, Test $test)
    {
        $request->validate([
            'leads' => 'required',
            "test_id" => "required"
        ]);
        $leads = json_decode($request->leads, true);
        $test = Test::findOrFail($request->test_id);

        // إضافة العملاء بدون حذف الموجودين سابقًا
        foreach ($leads as $lead) {
            $test->leads()->syncWithoutDetaching($lead);

            // تحقق من وجود تقييم سابق لنفس العميل والاختبار
            $alreadyExists = Evaluation::where('lead_id', $lead)
                ->where('test_id', $test->id)
                ->exists();

            if (!$alreadyExists) {
                $lastCode = Evaluation::where('test_id', $test->id)
                    ->selectRaw('MAX(CAST(code AS UNSIGNED)) as max_code')
                    ->value('max_code');
                $nextCode = $lastCode ? $lastCode + 1 : 1;
                // إرسال إشعار بعد التحديث
                $title = "تمت إضافتك إلى اختبار جديد";
                $body = "تمت إضافتك إلى اختبار جديد ضمن النظام، ونتمنى لك التوفيق والنجاح.";
                $icon = null; // أو رابط أيقونة
                app(ApiAppController::class)->sendFcmMessage("customer", $lead, $title, $body, $icon);

                Evaluation::create([
                    'lead_id' => $lead,
                    'test_id' => $test->id,
                    'code'    => $nextCode,
                ]);
            }
        }
        return redirect()->back();
    }

    public function removeLead($testId, $leadId)
    {
        $test = Test::findOrFail($testId);

        // 1. إزالة الربط بين العميل والاختبار
        $test->leads()->detach($leadId);

        // 2. حذف كل التقييمات المتعلقة بهذا العميل وهذا الاختبار
        Evaluation::where('lead_id', $leadId)
            ->where('test_id', $testId)
            ->delete();

        return redirect()->back()->with('success', 'تم إزالة العميل وجميع تقييماته من الاختبار بنجاح.');
    }
    public function show_evaluation($testId, $leadId)
    {
        $test = Test::findOrFail($testId);
        $evaluations = Evaluation::where('lead_id', $leadId)->where('test_id', $test->id)->get();
        $lead = $test->leads()->find($leadId);

        if (!$evaluations) {
            return redirect()->back()->with('error', 'لا يوجد تقييم لهذا العميل في هذا الاختبار.');
        }

        return view('tests.show-evaluation', [
            'test' => $test,
            'evaluations' => $evaluations,
            'lead' => $lead
        ]);
    }
    public function storeEvaluation(Request $request, $id)
    {
        $request->validate([
            'evaluation' => 'required|string',
            'score'      => 'required',
            'notes'      => 'nullable',
            'attach'     => 'nullable|file',
        ]);

        // حساب ترتيب الكود داخل نفس الاختبار
        $evaluation = Evaluation::find($id);

        // رفع الملف إن وُجد
        $filePath = null;
        if ($request->hasFile('attach')) {
            $filePath = $request->file('attach')->store('uploads', 'public');
        }
        $evaluation->evaluation = $request->evaluation;
        $evaluation->score = $request->score;
        $evaluation->notes = $request->notes;
        $evaluation->attach = $filePath;
        $evaluation->save();

        return redirect()->back()->with('success', 'تم إضافة التقييم بنجاح.');
    }
    public function createEvaluation(Request $request)
    {
        $request->validate([
            'lead_id'    => 'required',
            'test_id'    => 'required',
            'evaluation' => 'required|string',
            'score'      => 'required',
            'notes'      => 'nullable|string',
            'attach'     => 'required',
        ]);

        // حساب الكود التالي
        $lastCode = Evaluation::where('test_id', $request->test_id)
            ->selectRaw('MAX(CAST(code AS UNSIGNED)) as max_code')
            ->value('max_code');

        $nextCode = $lastCode ? $lastCode + 1 : 1;

        // رفع الملف
        $filePath = $request->file('attach')->store('uploads', 'public');

        // إنشاء التقييم
        Evaluation::create([
            'lead_id'    => $request->lead_id,
            'test_id'    => $request->test_id,
            'evaluation' => $request->evaluation,
            'score'      => $request->score,
            'notes'      => $request->notes,
            'attach'     => $filePath,
            'code'       => $nextCode,
        ]);

        return redirect()->back()->with('success', 'تم اضافة التقييم بنجاح.');
    }

    public function callingClient($test_id, $lead_id)
    {
        # code...
        $test = Test::findOrFail($test_id);
        $lead = LeadsCustomers::findOrFail($lead_id);
        if ($test->leads()->where('leads_customers.id', $lead->id)->exists()) {
            return redirect()->back()->with('already_exists', "العميل موجود بالفعل داخل هذا الاختبار");
        }
        $test->leads()->syncWithoutDetaching($lead->id);


        // تحقق من وجود تقييم سابق لنفس العميل والاختبار
        $alreadyExists = Evaluation::where('lead_id', $lead->id)
            ->where('test_id', $test->id)
            ->exists();

        if (! $alreadyExists) {
            $lastCode = Evaluation::where('test_id', $test->id)
                ->selectRaw('MAX(CAST(code AS UNSIGNED)) as max_code')
                ->value('max_code');
            $nextCode = $lastCode ? $lastCode + 1 : 1;

            Evaluation::create([
                'lead_id' => $lead->id,
                'test_id' => $test->id,
                'code'    => $nextCode,
            ]);
        }
        return app(ReportsController::class)->test_card($lead->id, $test_id);
    }
    public function safeDriving($test_name)
    {
        # code...
        $test = Test::where('title', $test_name)->first();
        if (!$test) {
            return "الاختبار غير موجود";
        }
        return view("tests.customers-test", [
            "leads" => $test->leads,
            "test" => $test,
            'groups' => collect([])
        ]);
    }
}
