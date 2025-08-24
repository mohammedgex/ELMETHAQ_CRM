<?php

namespace App\Http\Controllers;

use App\Models\bag;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Delegate;
use App\Models\DocumentType;
use App\Models\Evaluation;
use App\Models\FileTitle;
use App\Models\History;
use App\Models\JobTitle;
use App\Models\LeadsCustomers;
use App\Models\Payments;
use App\Models\PaymentTitle;
use App\Models\Sponser;
use App\Models\Test;
use App\Models\User;
use App\Models\User_task;
use App\Models\VisaType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $delegates = Delegate::latest()->get();
        $groups = CustomerGroup::latest()->get();
        $jobs = JobTitle::latest()->get();
        $sponsers = Sponser::latest()->get();
        $visas = VisaType::withCount('outgoingCustomers')->latest()->get();
        $customers = Customer::latest()->get();
        $bags = Bag::latest()->get();
        $users = User::latest()->get();
        $tests = Test::latest()->get();
        $histories = History::latest()->take(10)->get();
        $tasks = User_task::with(['sender', 'receiver'])
            ->latest() // مرتب بالأحدث
            ->take(10) // حد أقصى 10
            ->get();

        $mainCustomers = Customer::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month');

        // العملاء المحتملين
        $potentialCustomers = LeadsCustomers::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month');
        $months = range(1, 12);

        $groupchs = CustomerGroup::withCount('customers')
            ->latest()
            ->take(5)
            ->get();

        $delegatesTravel = Delegate::withCount([
            'customers as total_customers',
            'traveledCustomers as traveled_customers'
        ])->get();

        return view('home', [
            'customers' => $customers,
            'visas' => $visas,
            'sponsers' => $sponsers,
            'jobs' => $jobs,
            'groups' => $groups,
            'delegates' => $delegates,
            'users' => $users,
            'bags' => $bags,
            "tests" => $tests,
            'histories' => $histories,
            'months' => $months,
            'mainCounts' => collect($months)->map(fn($m) => $mainCustomers[$m] ?? 0),
            'potentialCounts' => collect($months)->map(fn($m) => $potentialCustomers[$m] ?? 0),
            'groupNames' => $groupchs->pluck('title'),
            'customerCounts' => $groupchs->pluck('customers_count'),
            'delegateNames' => $delegatesTravel->pluck('name'),
            'totalDCustomers' => $delegatesTravel->pluck('total_customers'),
            'traveledCustomers' => $delegatesTravel->pluck('traveled_customers'),
            'tasks' => $tasks,
        ]);
    }

    public function potentialChartData(Request $request)
    {
        $filter = $request->get('filter', 'month');

        // العملاء المحتملين (مثال شرط: password != null)
        $basePotential = LeadsCustomers::whereNotNull('password');

        // العملاء المحولين (أساسيين) مع وجود علاقة customer
        $baseConverted = LeadsCustomers::where('status', 'عميل اساسي')
            ->whereHas('customer');

        // تحديد الفلتر وتجهيز اللابلز
        if ($filter === 'day') {
            $labels = range(0, 23); // ساعات اليوم
            $basePotential->whereDate('created_at', today());
            $baseConverted->whereHas('customer', function ($q) {
                $q->whereDate('created_at', today());
            });
        } elseif ($filter === 'year') {
            $labels = range(1, 12); // الشهور
            $basePotential->whereYear('created_at', now()->year);
            $baseConverted->whereHas('customer', function ($q) {
                $q->whereYear('created_at', now()->year);
            });
        } else { // month (افتراضي)
            $labels = range(1, now()->daysInMonth); // أيام الشهر
            $basePotential->whereMonth('created_at', now()->month);
            $baseConverted->whereHas('customer', function ($q) {
                $q->whereMonth('created_at', now()->month);
            });
        }

        $potential = [];
        $converted = [];

        // الحساب لكل فترة
        foreach ($labels as $label) {
            if ($filter === 'day') {
                $potential[] = (clone $basePotential)
                    ->whereRaw('HOUR(created_at) = ?', [$label])
                    ->count();

                $converted[] = (clone $baseConverted)
                    ->whereHas('customer', function ($q) use ($label) {
                        $q->whereRaw('HOUR(created_at) = ?', [$label]);
                    })
                    ->count();
            } elseif ($filter === 'year') {
                $potential[] = (clone $basePotential)
                    ->whereMonth('created_at', $label)
                    ->count();

                $converted[] = (clone $baseConverted)
                    ->whereHas('customer', function ($q) use ($label) {
                        $q->whereMonth('created_at', $label);
                    })
                    ->count();
            } else { // month
                $potential[] = (clone $basePotential)
                    ->whereDay('created_at', $label)
                    ->count();

                $converted[] = (clone $baseConverted)
                    ->whereHas('customer', function ($q) use ($label) {
                        $q->whereDay('created_at', $label);
                    })
                    ->count();
            }
        }

        return response()->json([
            'labels' => $labels,
            'potential' => $potential,
            'converted' => $converted
        ]);
    }

    public function groupVisa($visaid)
    {
        # code...
        $visa = VisaType::findOrFail($visaid);
        $groups = CustomerGroup::where('visa_type_id', $visaid)->get();
        return view('visa.visa-groups', [
            'visa' => $visa,
            'groups' => $groups,
        ]);
    }

    public function visaCustomersChartData()
    {
        $visaTypes = VisaType::with('customerGroups.customers')->get();

        $labels = [];
        $totalCustomers = [];
        $withVisaNumber = [];

        foreach ($visaTypes as $visaType) {
            $labels[] = $visaType->name ?? 'VisaType #' . $visaType->id;

            // جمع كل العملاء من كل المجموعات المرتبطة بالتأشيرة
            $allCustomers = $visaType->customerGroups->flatMap(function ($group) {
                return $group->customers;
            });

            // إجمالي العملاء
            $totalCustomers[] = $allCustomers->count();

            // العملاء الذين لديهم رقم تأشيرة (visa_number غير فارغ)
            $withVisaNumber[] = $allCustomers->whereNotNull('visa_number')->count();
        }

        return response()->json([
            'labels' => $labels,
            'total' => $totalCustomers,
            'withVisa' => $withVisaNumber,
        ]);
    }

    public function testEvaluationStats($testId)
    {
        // جلب آخر تقييم لكل عميل في الاختبار حسب أكبر id (أي أحدث تقييم)
        $latestEvaluations = DB::table('evaluations as e1')
            ->select('e1.lead_id', 'e1.evaluation')
            ->where('e1.test_id', $testId)
            ->whereRaw('e1.id = (select max(id) from evaluations where lead_id = e1.lead_id and test_id = e1.test_id)')
            ->get();

        $counts = [
            'accepted' => 0,   // مقبول
            'reserve' => 0,    // احتياطي
            'trained' => 0,    // غير مقبول (مروضين حسب طلبك)
            'pending' => 0,    // معلقين (evaluation = null)
        ];

        foreach ($latestEvaluations as $eval) {
            if ($eval->evaluation === null) {
                $counts['pending']++;
            } elseif ($eval->evaluation === 'مقبول') {
                $counts['accepted']++;
            } elseif ($eval->evaluation === 'احتياطي') {
                $counts['reserve']++;
            } elseif ($eval->evaluation === 'غير مقبول') {
                $counts['trained']++;
            }
        }

        return response()->json([
            'labels' => ['مقبولين', 'احتياطي', 'مروضين', 'معلقين'],
            'data' => [
                $counts['accepted'],
                $counts['reserve'],
                $counts['trained'],
                $counts['pending'],
            ],
        ]);
    }
}
