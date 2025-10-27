<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($credentials['username'] === 'admin' && $credentials['password'] === 'admin123') {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'username' => 'بيانات الدخول غير صحيحة',
        ]);
    }

    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        // مشاركة بيانات الطلبات قيد الانتظار
        $this->sharePendingOrdersData();

        // إحصائيات عامة
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $inProgressOrders = Order::where('status', 'in_progress')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $rejectedOrders = Order::where('status', 'rejected')->count();
        $urgentOrders = Order::where('priority', 3)->count();

        // إحصائيات حسب النوع
        $ordersByType = Order::select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->get()
            ->pluck('count', 'type')
            ->toArray();

        // إحصائيات الشهر الحالي
        $currentMonthOrders = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // آخر الطلبات
        $recentOrders = Order::orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // إحصائيات الأسبوع
        $weeklyStats = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('count(*) as count')
        )
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $requests = [];
        $file = storage_path('company_requests.txt');
        if (file_exists($file)) {
            $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $parts = explode(' | ', $line);
                $requests[] = [
                    'company_name' => $parts[0] ?? '',
                    'email' => $parts[1] ?? '',
                    'job_title' => $parts[2] ?? '',
                    'workers_count' => $parts[3] ?? '',
                    'message' => $parts[4] ?? '',
                ];
            }
        }

        return view('admin.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'inProgressOrders',
            'completedOrders',
            'rejectedOrders',
            'urgentOrders',
            'ordersByType',
            'currentMonthOrders',
            'recentOrders',
            'weeklyStats',
            'requests'
        ));
    }

    // عرض طلبات الطيران
    public function flightOrders(Request $request)
    {
        // مشاركة بيانات الطلبات قيد الانتظار
        $this->sharePendingOrdersData();

        // إحصائيات جميع طلبات الطيران
        $stats = [
            'total' => Order::where('type', 'flight')->count(),
            'pending' => Order::where('type', 'flight')->where('status', 'pending')->count(),
            'in_progress' => Order::where('type', 'flight')->where('status', 'in_progress')->count(),
            'completed' => Order::where('type', 'flight')->where('status', 'completed')->count(),
            'rejected' => Order::where('type', 'flight')->where('status', 'rejected')->count(),
            'urgent' => Order::where('type', 'flight')->where('priority', 3)->count(),
        ];

        $query = Order::where('type', 'flight');

        // البحث في الاسم
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // فلترة حسب الأولوية
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // فلترة حسب التاريخ
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(20);

        return view('admin.orders', [
            'orders' => $orders,
            'type' => 'flight',
            'title' => 'طلبات حجز الطيران',
            'stats' => $stats,
        ]);
    }

    // عرض طلبات الفنادق
    public function hotelOrders(Request $request)
    {
        // مشاركة بيانات الطلبات قيد الانتظار
        $this->sharePendingOrdersData();

        // إحصائيات جميع طلبات الفنادق
        $stats = [
            'total' => Order::where('type', 'hotel')->count(),
            'pending' => Order::where('type', 'hotel')->where('status', 'pending')->count(),
            'in_progress' => Order::where('type', 'hotel')->where('status', 'in_progress')->count(),
            'completed' => Order::where('type', 'hotel')->where('status', 'completed')->count(),
            'rejected' => Order::where('type', 'hotel')->where('status', 'rejected')->count(),
            'urgent' => Order::where('type', 'hotel')->where('priority', 3)->count(),
        ];

        $query = Order::where('type', 'hotel');

        // البحث في الاسم
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // فلترة حسب الأولوية
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // فلترة حسب التاريخ
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(20);

        return view('admin.orders', [
            'orders' => $orders,
            'type' => 'hotel',
            'title' => 'طلبات حجز الفنادق',
            'stats' => $stats,
        ]);
    }

    // عرض طلبات التأشيرات
    public function visaOrders(Request $request)
    {
        // مشاركة بيانات الطلبات قيد الانتظار
        $this->sharePendingOrdersData();

        // إحصائيات جميع طلبات التأشيرات
        $stats = [
            'total' => Order::where('type', 'visa')->count(),
            'pending' => Order::where('type', 'visa')->where('status', 'pending')->count(),
            'in_progress' => Order::where('type', 'visa')->where('status', 'in_progress')->count(),
            'completed' => Order::where('type', 'visa')->where('status', 'completed')->count(),
            'rejected' => Order::where('type', 'visa')->where('status', 'rejected')->count(),
            'urgent' => Order::where('type', 'visa')->where('priority', 3)->count(),
        ];

        $query = Order::where('type', 'visa');

        // البحث في الاسم
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // فلترة حسب الأولوية
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // فلترة حسب التاريخ
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(20);

        return view('admin.orders', [
            'orders' => $orders,
            'type' => 'visa',
            'title' => 'طلبات التأشيرات',
            'stats' => $stats,
        ]);
    }

    // عرض طلبات جواز السفر
    public function passportOrders(Request $request)
    {
        // مشاركة بيانات الطلبات قيد الانتظار
        $this->sharePendingOrdersData();

        // إحصائيات جميع طلبات جواز السفر
        $stats = [
            'total' => Order::where('type', 'passport')->count(),
            'pending' => Order::where('type', 'passport')->where('status', 'pending')->count(),
            'in_progress' => Order::where('type', 'passport')->where('status', 'in_progress')->count(),
            'completed' => Order::where('type', 'passport')->where('status', 'completed')->count(),
            'rejected' => Order::where('type', 'passport')->where('status', 'rejected')->count(),
            'urgent' => Order::where('type', 'passport')->where('priority', 3)->count(),
        ];

        $query = Order::where('type', 'passport');

        // البحث في الاسم
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // فلترة حسب الأولوية
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // فلترة حسب التاريخ
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(20);

        return view('admin.orders', [
            'orders' => $orders,
            'type' => 'passport',
            'title' => 'طلبات جواز السفر',
            'stats' => $stats,
        ]);
    }

    // عرض طلبات الترجمة
    public function translationOrders(Request $request)
    {
        // مشاركة بيانات الطلبات قيد الانتظار
        $this->sharePendingOrdersData();

        // إحصائيات جميع طلبات الترجمة
        $stats = [
            'total' => Order::where('type', 'translation')->count(),
            'pending' => Order::where('type', 'translation')->where('status', 'pending')->count(),
            'in_progress' => Order::where('type', 'translation')->where('status', 'in_progress')->count(),
            'completed' => Order::where('type', 'translation')->where('status', 'completed')->count(),
            'rejected' => Order::where('type', 'translation')->where('status', 'rejected')->count(),
            'urgent' => Order::where('type', 'translation')->where('priority', 3)->count(),
        ];

        $query = Order::where('type', 'translation');

        // البحث في الاسم
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // فلترة حسب الأولوية
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // فلترة حسب التاريخ
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(20);

        return view('admin.orders', [
            'orders' => $orders,
            'type' => 'translation',
            'title' => 'طلبات الترجمة المعتمدة',
            'stats' => $stats,
        ]);
    }

    // عرض طلبات التوثيقات الخارجية
    public function foreignOrders(Request $request)
    {
        // مشاركة بيانات الطلبات قيد الانتظار
        $this->sharePendingOrdersData();

        // إحصائيات جميع طلبات التوثيقات الخارجية
        $stats = [
            'total' => Order::where('type', 'foreign')->count(),
            'pending' => Order::where('type', 'foreign')->where('status', 'pending')->count(),
            'in_progress' => Order::where('type', 'foreign')->where('status', 'in_progress')->count(),
            'completed' => Order::where('type', 'foreign')->where('status', 'completed')->count(),
            'rejected' => Order::where('type', 'foreign')->where('status', 'rejected')->count(),
            'urgent' => Order::where('type', 'foreign')->where('priority', 3)->count(),
        ];

        $query = Order::where('type', 'foreign');

        // البحث في الاسم
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // فلترة حسب الأولوية
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // فلترة حسب التاريخ
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(20);

        return view('admin.orders', [
            'orders' => $orders,
            'type' => 'foreign',
            'title' => 'طلبات التوثيقات الخارجية',
            'stats' => $stats,
        ]);
    }

    // عرض طلبات السفارات والقنصليات
    public function embassyOrders(Request $request)
    {
        // مشاركة بيانات الطلبات قيد الانتظار
        $this->sharePendingOrdersData();

        // إحصائيات جميع طلبات السفارات
        $stats = [
            'total' => Order::where('type', 'embassy')->count(),
            'pending' => Order::where('type', 'embassy')->where('status', 'pending')->count(),
            'in_progress' => Order::where('type', 'embassy')->where('status', 'in_progress')->count(),
            'completed' => Order::where('type', 'embassy')->where('status', 'completed')->count(),
            'rejected' => Order::where('type', 'embassy')->where('status', 'rejected')->count(),
            'urgent' => Order::where('type', 'embassy')->where('priority', 3)->count(),
        ];

        $query = Order::where('type', 'embassy');

        // البحث في الاسم
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // فلترة حسب الأولوية
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // فلترة حسب التاريخ
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(20);

        return view('admin.orders', [
            'orders' => $orders,
            'type' => 'embassy',
            'title' => 'طلبات السفارات والقنصليات',
            'stats' => $stats,
        ]);
    }

    // عرض طلبات المستخرجات الرسمية
    public function extractsOrders(Request $request)
    {
        // مشاركة بيانات الطلبات قيد الانتظار
        $this->sharePendingOrdersData();

        // إحصائيات جميع طلبات المستخرجات
        $stats = [
            'total' => Order::where('type', 'extracts')->count(),
            'pending' => Order::where('type', 'extracts')->where('status', 'pending')->count(),
            'in_progress' => Order::where('type', 'extracts')->where('status', 'in_progress')->count(),
            'completed' => Order::where('type', 'extracts')->where('status', 'completed')->count(),
            'rejected' => Order::where('type', 'extracts')->where('status', 'rejected')->count(),
            'urgent' => Order::where('type', 'extracts')->where('priority', 3)->count(),
        ];

        $query = Order::where('type', 'extracts');

        // البحث في الاسم
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // فلترة حسب الأولوية
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // فلترة حسب التاريخ
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(20);

        return view('admin.orders', [
            'orders' => $orders,
            'type' => 'extracts',
            'title' => 'طلبات المستخرجات الرسمية',
            'stats' => $stats,
        ]);
    }

    // دالة عامة للبحث والفلترة
    public function searchOrders(Request $request, $type = null)
    {
        $query = Order::query();

        // فلترة حسب النوع
        if ($type) {
            $query->where('type', $type);
        }

        // البحث في الاسم
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // فلترة حسب الأولوية
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // فلترة حسب التاريخ
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // ترتيب النتائج
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $orders = $query->paginate(20);

        return response()->json([
            'orders' => $orders,
            'filters' => $request->all()
        ]);
    }

    // دالة لجلب تفاصيل الطلب
    public function getOrderDetails($orderId)
    {
        $order = Order::findOrFail($orderId);

        $details = [
            'id' => $order->id,
            'type' => $this->getTypeText($order->type),
            'name' => $order->name,
            'phone' => $order->phone,
            'email' => $order->email,
            'status' => $order->getStatusText(),
            'status_color' => $order->getStatusColor(),
            'priority' => $order->getPriorityText(),
            'priority_color' => $order->getPriorityColor(),
            'created_at' => $order->created_at->format('Y-m-d H:i:s'),
            'status_updated_at' => $order->status_updated_at ? $order->status_updated_at->format('Y-m-d H:i:s') : 'غير محدد',
            'status_notes' => $order->status_notes,
            'assigned_to' => $order->assigned_to
        ];

        // إضافة تفاصيل إضافية حسب نوع الطلب
        if ($order->details && is_array($order->details)) {
            switch ($order->type) {
                case 'passport':
                    // لطلبات جواز السفر - إظهار جميع التفاصيل بتصميم جميل
                    $filteredDetails = [];

                    // التأكد من أن details هو array
                    $orderDetails = is_string($order->details) ? json_decode($order->details, true) : $order->details;

                    if (is_array($orderDetails)) {
                        foreach ($orderDetails as $key => $value) {
                            if (!empty($value) && !in_array($key, ['_token', 'Source', 'التصنيف', 'الخدمة'])) {
                                // معالجة خاصة لنوع الجواز
                                if ($key === 'type') {
                                    $filteredDetails[$this->getFieldLabel($key)] = $this->getPassportTypeText($value);
                                } else {
                                    $filteredDetails[$this->getFieldLabel($key)] = $value;
                                }
                            }
                        }
                    }

                    if (!empty($filteredDetails)) {
                        $details['details'] = $filteredDetails;
                    }
                    break;

                case 'flight':
                case 'hotel':
                case 'visa':
                case 'foreign':
                case 'embassy':
                case 'extracts':
                case 'translation':
                    // للأنواع الأخرى - إظهار جميع التفاصيل
                    $orderDetails = is_string($order->details) ? json_decode($order->details, true) : $order->details;
                    if (is_array($orderDetails)) {
                        $details['details'] = $orderDetails;
                    }
                    break;

                default:
                    // للحالات الأخرى - إظهار جميع التفاصيل
                    $orderDetails = is_string($order->details) ? json_decode($order->details, true) : $order->details;
                    if (is_array($orderDetails)) {
                        $details['details'] = $orderDetails;
                    }
                    break;
            }
        }

        return response()->json($details);
    }

    // دالة مساعدة لتحويل نوع الطلب إلى نص عربي
    private function getTypeText($type)
    {
        return match ($type) {
            'flight' => 'حجز طيران',
            'hotel' => 'حجز فندق',
            'visa' => 'تأشيرة',
            'passport' => 'جواز سفر',
            'foreign' => 'توثيق خارجي',
            'embassy' => 'سفارة',
            'extracts' => 'مستخرج رسمي',
            'translation' => 'ترجمة',
            default => 'غير محدد'
        };
    }

    // دالة مساعدة لتحويل أسماء الحقول إلى نصوص عربية
    private function getFieldLabel($field)
    {
        return match ($field) {
            // حقول جواز السفر
            'type' => 'نوع الجواز',
            'name' => 'الاسم الكامل',
            'phone' => 'رقم الهاتف',
            'email' => 'البريد الإلكتروني',
            'country_code1' => 'دولة الإقامة',
            'city' => 'المحافظة',
            'call_time' => 'وقت التواصل المفضل',
            'address' => 'العنوان',
            'whatsapp' => 'رقم الواتساب',

            // حقول الطيران
            'departure_date' => 'تاريخ المغادرة',
            'return_date' => 'تاريخ العودة',
            'destination' => 'الوجهة',
            'passengers' => 'عدد المسافرين',
            'class' => 'فئة المقعد',

            // حقول الفندق
            'hotel_name' => 'اسم الفندق',
            'check_in' => 'تاريخ الوصول',
            'check_out' => 'تاريخ المغادرة',
            'rooms' => 'عدد الغرف',
            'guests' => 'عدد الضيوف',

            // حقول التأشيرة
            'visa_type' => 'نوع التأشيرة',
            'purpose' => 'الغرض من السفر',
            'duration' => 'مدة الإقامة',
            'entry_type' => 'نوع الدخول',

            // حقول التوثيق
            'document_type' => 'نوع المستند',
            'embassy_name' => 'اسم السفارة',
            'translation_type' => 'نوع الترجمة',
            'language_from' => 'اللغة المصدر',
            'language_to' => 'اللغة الهدف',
            'pages' => 'عدد الصفحات',

            // حقول عامة
            'notes' => 'ملاحظات إضافية',
            'urgency' => 'مستوى الأولوية',
            'budget' => 'الميزانية المطلوبة',
            'deadline' => 'الموعد النهائي',

            default => ucfirst(str_replace('_', ' ', $field))
        };
    }

    // دالة مساعدة لتحويل نوع الجواز إلى نص عربي
    private function getPassportTypeText($type)
    {
        return match ($type) {
            'توكيل VIP' => 'توكيل VIP',
            'فوري VIP' => 'فوري VIP',
            'عاجل' => 'عاجل',
            'عادي' => 'عادي',
            default => $type
        };
    }

    // دالة لتحديث حالة الطلب
    public function updateOrderStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,under_review,approved,completed,rejected,cancelled',
            'status_notes' => 'nullable|string|max:500',
            'priority' => 'nullable|in:1,2,3',
            'assigned_to' => 'nullable|string|max:100'
        ]);

        $order = Order::findOrFail($orderId);

        $order->update([
            'status' => $request->status,
            'status_notes' => $request->status_notes,
            'status_updated_at' => now(),
            'priority' => $request->priority ?? $order->priority,
            'assigned_to' => $request->assigned_to ?? $order->assigned_to
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث حالة الطلب بنجاح',
            'order' => [
                'id' => $order->id,
                'status' => $order->getStatusText(),
                'status_color' => $order->getStatusColor(),
                'priority' => $order->getPriorityText(),
                'priority_color' => $order->getPriorityColor()
            ]
        ]);
    }

    // دالة مساعدة لحساب الطلبات قيد الانتظار لكل نوع
    private function getPendingOrdersCount($type = null)
    {
        $query = Order::where('status', 'pending');
        if ($type) {
            $query->where('type', $type);
        }
        return $query->count();
    }

    // دالة لمشاركة بيانات الطلبات قيد الانتظار مع جميع الصفحات
    private function sharePendingOrdersData()
    {
        $pendingOrdersData = [
            'dashboard' => $this->getPendingOrdersCount(),
            'flights' => $this->getPendingOrdersCount('flight'),
            'hotels' => $this->getPendingOrdersCount('hotel'),
            'visas' => $this->getPendingOrdersCount('visa'),
            'passports' => $this->getPendingOrdersCount('passport'),
            'foreign' => $this->getPendingOrdersCount('foreign'),
            'embassy' => $this->getPendingOrdersCount('embassy'),
            'extracts' => $this->getPendingOrdersCount('extracts'),
            'translation' => $this->getPendingOrdersCount('translation'),
        ];

        view()->share('pendingOrdersData', $pendingOrdersData);
    }

    public function contacts()
    {
        $contacts = \App\Models\Contact::orderBy('created_at', 'desc')->get();
        return view('admin.contacts', compact('contacts'));
    }
}
