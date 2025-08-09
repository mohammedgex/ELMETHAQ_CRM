<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DocumentType;
use App\Models\History;
use App\Models\LeadsCustomers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use DevKandil\NotiFire\Facades\Fcm;
use DevKandil\NotiFire\Enums\MessagePriority;
use Illuminate\Support\Facades\Validator;
use GPBMetadata\Google\Api\Log;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class ApiAppController extends Controller
{
    //
    public function sendFcmMessage($type, $id, $title, $body, $icon = null)
    {
        if ($type === 'lead') {
            $model = LeadsCustomers::find($id);
        } elseif ($type === 'customer') {
            $model = Customer::find($id);
        } else {
            $model = User::find($id);
        }

        if (!$model || !$model->fcm_token) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found or FCM token missing'
            ], 404);
        }

        try {
            $messaging = Firebase::messaging();

            $message = CloudMessage::withTarget('token', $model->fcm_token)
                ->withNotification(Notification::create($title, $body))
                ->withData([
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                    'type' => $type,
                    'id' => (string) $id,
                    'icon' => $icon ?? '',
                ]);

            $messaging->send($message);

            return response()->json(['status' => 'success', 'message' => 'Notification sent successfully']);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send notification',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        // التحقق من المدخلات
        $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);

        // البحث عن المستخدم بناءً على رقم الهاتف
        $user = LeadsCustomers::where('phone', $request->phone)->first();

        // التحقق من وجود المستخدم
        if (!$user) {
            return response()->json(['message' => 'الحساب غير موجود'], 404);
        }

        // التحقق من صحة كلمة المرور
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'كلمة المرور خطأ'], 401);
        }

        // إنشاء توكن للمستخدم باستخدام Sanctum
        $token = $user->createToken($user->name)->plainTextToken;

        // إرجاع التوكن في الاستجابة
        if ($user->customer_id !== null) {
            # code...
            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user,
                'customer' => $user->customer
            ], 200);
        } else {
            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user,
            ], 200);
        }
    }

    public function getUserData()
    {
        $user = auth('sanctum')->user(); // Use sanctum guard to get LeadsCustomers

        if (!$user) {
            return response()->json(['message' => 'انتهاء صلاحية التسجيل'], 401);
        }

        return response()->json([
            'message' => 'User data retrieved successfully',
            'user' => $user->load('jobTitle'), // تحميل بيانات الوظيفة مع المستخدم
            'customer' => $user->customer ? $user->customer->load('documentTypes') : null
        ], 200);
    }

    public function register(Request $request)
    {
        # code...
        $request->validate([
            'image' => 'required',
            'phone' => 'nullable|unique:leads_customers,phone',
            'job_title_id' => 'required',
            'password' => 'nullable',
            'fcm_token' => 'nullable|string',
        ], [
            'image.required' => 'صورة المستخدم مطلوبة.',
            'phone.unique' => 'رقم الهاتف مستخدم بالفعل.',
            'job_title_id.required' => 'يرجى اختيار الوظيفة.',
            'fcm_token.string' => 'رمز الإشعارات يجب أن يكون نصًا.',
        ]);
        // حفظ الصورة
        $filePath = $request->file('image')->store('uploads', 'public');
        // إنشاء سجل جديد
        $user = LeadsCustomers::create([
            'phone' => $request->phone,
            'image' => $filePath,
            'job_title_id' => $request->job_title_id,
            'password' => $request->password ? Hash::make($request->password) : null,
            'status' => 'عميل محتمل',
            'fcm_token' => $request->fcm_token,
            "registration_date" => Carbon::now(),
        ]);
        if (!$user->phone) {
            # code...
            $token = $user->createToken($user->image ?: 'lead-customer')->plainTextToken;
            return response()->json([
                'status' => 'success',
                'data' => $user->id,
                "token" => $token,
            ], 201);
        }
        $this->sendOtp($request->phone);

        // لا ترسل OTP هنا لأن الهاتف لم يُسجل بعد
        return response()->json([
            'status' => 'success',
            'message' => 'OTP sent successfully!',
            'data' => $user->id,
        ], 201);
    }

    public function sendOtp($phone)
    {
        $code = rand(1000, 9999);

        // حفظ الكود في جدول OTP
        Otp::create([
            'phone' => $phone,
            'code' => $code,
            'expires_at' => Carbon::now()->addMinutes(5), // مدة صلاحية الكود
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer 714|qEOqBniIAUxUDwelNt6yR243dSFztZgBeEOmcm8Hb27a6438',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post('https://bulk.whysms.com/api/v3/sms/send', [
            'recipient' => '2' . $phone,
            'sender_id' => 'Elmethaq Co',
            'type' => 'plain',
            'message' => 'الكود الخاص بك:' . $code . " يرجى إدخاله لتأكيد رقم هاتفك. ",
        ]);

        if ($response->successful()) {
            return response()->json([
                'message' => 'OTP sent successfully!',
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to send OTP',
                'error' => $response->body(),
            ], 400);
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'code' => 'required'
        ]);

        $otp = Otp::where('phone', $request->phone)
            ->where('code', $request->code)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$otp) {
            return response()->json(['message' => 'كود التاكيد خطأ'], 422);
        }

        // حذف الكود بعد التحقق (اختياري)
        $otp->delete();
        $user = LeadsCustomers::where('phone', $request->phone)->first();
        $user->phone_verified_at = now();
        $user->save();
        $token = $user->createToken($user->name ?: 'lead-customer')->plainTextToken;


        return response()->json([
            'message' => 'OTP verified successfully',
            'token' => $token
        ]);
    }

    public function completeData(Request $request)
    {
        # code...
        $request->validate([
            'name' => 'required',
            'phone_two' => 'nullable',
            'card_id' => 'required|digits:14|unique:leads_customers,card_id',
            'date_of_birth' => 'required',
            'age' => 'required',
            'img_national_id_card' => 'required',
            'img_national_id_card_back' => 'required',
            'passport_numder' => 'nullable',
            'passport_photo' => 'nullable',
            'license_photo' => 'required',
            'have_you_ever_traveled_before?' => 'required',
            'governorate' => 'required',
            'fcm_token' => 'nullable|string',
        ], [
            'name.required' => 'الاسم مطلوب.',
            'card_id.required' => 'رقم البطاقة مطلوب.',
            'card_id.digits' => 'رقم البطاقة يجب أن يكون 14 رقمًا.',
            'card_id.unique' => 'رقم البطاقة مستخدم بالفعل.',
            'date_of_birth.required' => 'تاريخ الميلاد مطلوب.',
            'age.required' => 'العمر مطلوب.',
            'img_national_id_card.required' => 'صورة البطاقة الشخصية (الوجه الأمامي) مطلوبة.',
            'img_national_id_card_back.required' => 'صورة البطاقة الشخصية (الوجه الخلفي) مطلوبة.',
            'license_photo.required' => 'صورة الرخصة مطلوبة.',
            'have_you_ever_traveled_before?.required' => 'يرجى تحديد ما إذا كنت قد سافرت من قبل.',
            'governorate.required' => 'المحافظة مطلوبة.',
            'fcm_token.string' => 'رمز الإشعارات يجب أن يكون نصًا.',
        ]);
        $user = auth('sanctum')->user(); // Use sanctum guard to get LeadsCustomers
        // تحديث الاسم والهاتف الثاني
        $user->name = $request->name;
        $user->phone_two = $request->phone_two;
        // حفظ الصور
        $imgNationalIdCardPath = $request->file('img_national_id_card')->store('uploads/', 'public');
        $imgNationalIdCardBackPath = $request->file('img_national_id_card_back')->store('uploads/', 'public');
        $passportPhotoPath = null;
        if ($request->hasFile('passport_photo')) {
            $passportPhotoPath = $request->file('passport_photo')->store('uploads/', 'public');
        }
        $licensePhotoPath = $request->file('license_photo')->store('uploads/', 'public');
        // تحديث باقي البيانات
        $user->card_id = $request->card_id;
        $user->date_of_birth = $request->date_of_birth;
        $user->age = $request->age;
        $user->img_national_id_card = $imgNationalIdCardPath;
        $user->img_national_id_card_back = $imgNationalIdCardBackPath;
        $user->passport_numder = $request->passport_numder;
        $user->passport_photo = $passportPhotoPath;
        $user->license_photo = $licensePhotoPath;
        $user->evaluation = "جارى المعالجة";
        $user['have_you_ever_traveled_before?'] = $request['have_you_ever_traveled_before?'];
        $user->governorate = $request->governorate;
        if ($request->filled('fcm_token')) {
            $user->fcm_token = $request->fcm_token;
        }
        $user->save();

        // إرسال رسالة SMS عادية
        $this->sendSms($user->phone, 'تم استلام بياناتك بنجاح وهي قيد المراجعة. شكراً لتسجيلك في المنصة.');

        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 201);
    }

    public function send_file(Request $request, $id)
    {
        # code...
        $document = DocumentType::find($id);
        if (!$document) {
            return response()->json(['message' => 'Document not found'], 404);
        }
        $request->validate([
            'file' => 'required',
        ]);
        // حفظ الملف
        $filePath = $request->file('file')->store('uploads/documents', 'public');
        $document->file = $filePath;
        $document->order_status =  'panding';
        $document->save();
        return response()->json([
            'status' => 'success',
            'message' => 'File uploaded successfully',
            "document" => $document->customer->documentTypes,
        ], 201);
    }

    public function saveAnyFcmToken(Request $request)
    {
        $request->validate([
            'type' => 'required|in:lead,customer',
            'id' => 'required|integer',
            'fcm_token' => 'required|string',
        ]);
        if ($request->type === 'lead') {
            $model = \App\Models\LeadsCustomers::find($request->id);
        } else if ($request->type === 'customer') {
            $model = \App\Models\Customer::find($request->id);
        }
        if (!$model) {
            return response()->json(['status' => 'error', 'message' => 'Not found'], 404);
        }
        $model->fcm_token = $request->fcm_token;
        $model->save();
        return response()->json(['status' => 'success']);
    }

    public function sendSms($phone, $message)
    {
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'Authorization' => 'Bearer 714|qEOqBniIAUxUDwelNt6yR243dSFztZgBeEOmcm8Hb27a6438',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post('https://bulk.whysms.com/api/v3/sms/send', [
            'recipient' => '2' . $phone,
            'sender_id' => 'Elmethaq Co',
            'type' => 'plain',
            'message' => $message,
        ]);

        return $response->successful();
    }

    public function sendNotifaction(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'icon' => 'nullable|url',
        ]);

        // استخدام FCM لإرسال الإشعار مباشرة إلى التوكن
        Fcm::withTitle($request->title)
            ->withBody($request->description)
            ->withImage($request->icon ?? 'https://yourdomain.com/default-icon.png')
            ->withPriority(MessagePriority::HIGH)
            ->sendNotification($request->fcm_token);

        return response()->json(['message' => 'تم إرسال الإشعار بنجاح']);
    }

    public function checkMedicalStatus($token)
    {
        $medicalUrl = "https://wafid.com/medical-status-display/" . $token;
        $slipUrl = "https://wafid.com/appointment/" . $token . "/slip";

        if (!$token) {
            return redirect()->back()->with('swal', [
                'icon' => 'error',
                'title' => 'خطأ',
                'text' => 'التوكن مطلوب'
            ]);
        }
        $customer = Customer::where("token_medical", $token)->first();
        $user = auth()->user();

        $status = 'غير معروف';
        $address = 'لم يتم العثور على العنوان';
        $errors = [];

        try {
            // ✅ أولا: فحص صفحة الـ Slip
            $slipResponse = Http::get($slipUrl);
            if ($slipResponse->status() === 404) {
                $errors[] = 'لا يوجد عنوان للمستشفي, تاكد من عملية الدفع';
            } elseif (!$slipResponse->successful()) {
                $errors[] = 'خطا غير معروف';
            } else {
                $slipHtml = $slipResponse->body();
                preg_match('/<td class="field_value" colspan="2">\s*<i[^>]*><\/i>\s*(.*?)\s*<\/td>/s', $slipHtml, $match);
                $address = isset($match[1]) ? trim(strip_tags($match[1])) : 'لم يتم العثور على العنوان';
                if ($address != 'لم يتم العثور على العنوان') {
                    # code...
                    $customer->hospital_address = $address;
                    $customer->save();
                    $history = new History();
                    $history->description = "تم جلب عنوان المستشفي وتخزينه";
                    $history->date = now();
                    $history->customer_id = $customer->id;
                    $history->user_id = $user->id;
                    $history->save();
                    // حذف أي مستندات سابقة من نوع "المستشفي"
                    $customer->documentTypes()->where('document_type', 'المستشفي')->delete();
                    // إنشاء مستند جديد
                    $document = new DocumentType();
                    $document->document_type = "المستشفي";
                    $document->status = "موجود بالمكتب";
                    $document->file = "https://wafid.com/appointment/" . $token . "/slip/print";
                    $document->customer_id = $customer->id;
                    $document->required = "اجباري";
                    $document->save();
                }
            }

            // ✅ ثانياً: فحص صفحة الحالة الطبية
            $medicalResponse = Http::get($medicalUrl);
            if ($medicalResponse->status() === 404) {
                $errors[] = 'النتيجة لم تظهر';
            } elseif (!$medicalResponse->successful()) {
                $errors[] = "خطا غير معروف";
            } else {
                $html = $medicalResponse->body();

                if (preg_match('/<span[^>]*style="[^"]*color\s*:\s*green[^"]*"[^>]*>\s*<i[^>]*><\/i>\s*Fit\s*<\/span>/i', $html)) {
                    $status = 'Fit';
                    $customer->medical_examination = "لائق";
                    $customer->save();
                    $history = new History();
                    $history->description = "تم جلب نتيجة الكشف الطبي وهو :لائق";
                    $history->date = now();
                    $history->customer_id = $customer->id;
                    $history->user_id = $user->id;
                    $history->save();
                    // حذف أي مستندات سابقة من نوع نتيجة الكشف الطبي
                    $customer->documentTypes()->where('document_type', "نتيجة الكشف الطبي")->delete();
                    // إنشاء مستند جديد
                    $document = new DocumentType();
                    $document->document_type = "نتيجة الكشف الطبي";
                    $document->status = "موجود بالمكتب";
                    $document->file = "https://wafid.com/medical-status/" . $token . "/print";
                    $document->customer_id = $customer->id;
                    $document->required = "اجباري";
                    $document->save();
                } elseif (preg_match('/<span[^>]*style="[^"]*color\s*:\s*red[^"]*"[^>]*>\s*<i[^>]*><\/i>\s*Unfit\s*<\/span>/i', $html)) {
                    $status = 'Unfit';
                    $customer->medical_examination = "غير لائق";
                    $customer->save();
                    $history = new History();
                    $history->description = "تم جلب نتيجة الكشف الطبي وهو : غير لائق";
                    $history->date = now();
                    $history->customer_id = $customer->id;
                    $history->user_id = $user->id;
                    $history->save();
                    // حذف أي مستندات سابقة من نوع نتيجة الكشف الطبي
                    $customer->documentTypes()->where('document_type', "نتيجة الكشف الطبي")->delete();
                    // إنشاء مستند جديد
                    $document = new DocumentType();
                    $document->document_type = "نتيجة الكشف الطبي";
                    $document->status = "موجود بالمكتب";
                    $document->file = "https://wafid.com/medical-status/" . $token . "/print";
                    $document->customer_id = $customer->id;
                    $document->required = "اجباري";
                    $document->save();
                }
            }
        } catch (\Exception $e) {
            $errors[] = 'حدث خطأ في الاتصال: ' . $e->getMessage();
        }

        $customer->save();
        // ✅ الإرجاع النهائي
        return redirect()->back()->with('swal', [
            'icon' => empty($errors) ? 'success' : 'error',
            'title' => empty($errors) ? 'تم التحقق بنجاح' : 'حدثت بعض الأخطاء',
            'html' => empty($errors)
                ? "<b>الحالة الطبية:</b> $status<br><b>العنوان:</b> $address"
                : implode('<br>', $errors),
        ]);
    }

    public function TokenCheckMedical(Request $request)
    {
        $customer = Customer::where('card_id', $request->card_id)->first();
        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'العميل غير موجود'], 404);
        }
        $customer->token_medical = $request->token_medical;
        $customer->medical_examination = "تم الحجز";
        $customer->save();

        $user = User::where('email', $request->email)->first();
        $history = new History();
        $history->description = "تم حجز الكشف الطبي للعميل";
        $history->date = now();

        $history->customer_id = $customer->id;
        $history->user_id = $user->id;
        $history->save();

        return response()->json(['success' => true, 'message' => 'تم حفظ التوكن بنجاح']);
    }

    public function visa(Request $request, $id)
    {
        $request->validate([
            'visa' => 'required|file', // max 10MB
            'type' => 'required|string',
            'email' => 'required|email',
        ]);
        $customer = Customer::find($id);
        $user = User::where('email', $request->email)->first();
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        if ($request->type == "request") {
            # code...
            $customer->documentTypes()->where('document_type', 'طلب الدخول')->delete();
            $document = new DocumentType();
            $document->document_type = "طلب الدخول";
            $document->status = "موجود بالمكتب";
            $document->file = $request->file('visa')->store('uploads', 'public');
            $document->customer_id = $customer->id;
            $document->required = "اجباري";
            $document->save();
            // انشاء سجل تاريخي
            $history = new History();
            $history->description = "تم رفع طلب الدخول";
            $history->date = now();
            $history->customer_id = $customer->id;
            $history->user_id = $user->id;
            $history->save();
        } elseif ($request->type == "visa") {
            # code...
            $customer->visa_number = $request->visa_number;
            $customer->visa_issuance_date = $request->validFrom;
            $customer->save();
            $customer->documentTypes()->where('document_type', 'التاشيرة')->delete();
            $document = new DocumentType();
            $document->document_type = "التاشيرة";
            $document->status = "موجود بالمكتب";
            $document->file = $request->file('visa')->store('uploads', 'public');
            $document->customer_id = $customer->id;
            $document->required = "اجباري";
            $document->save();
            // انشاء سجل تاريخي
            $history = new History();
            $history->description = "تم رفع التأشيرة";
            $history->date = now();
            $history->customer_id = $customer->id;
            $history->user_id = $user->id;
            $history->save();
        }
        return response()->json([
            'status' => 'success',
            'message' => 'تم رفع الملف بنجاح',
            'document' => $document,
        ]);
    }

    public function store(Request $request)
    {
        $customer = Customer::where("token_medical", $request->token)->first();
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }
        $user = User::where('email', $request->email)->first();

        $customer->hospital_address =  $request->address . "|---|" . $request->cleanedAddress;
        $customer->medical_examination = "تم الحجز";
        $customer->save();
        $history = new History();
        $history->description = "تم جلب عنوان المستشفي وتخزينه";
        $history->date = now();
        $history->customer_id = $customer->id;
        $history->user_id = $user->id; // يجب تعديل هذا إلى معرف المستخدم الصحيح
        $history->save();
        // حذف أي مستندات سابقة من نوع "المستشفي"
        $customer->documentTypes()->where('document_type', 'المستشفي')->delete();
        // إنشاء مستند جديد
        $document = new DocumentType();
        $document->document_type = "المستشفي";
        $document->status = "موجود بالمكتب";
        $document->file = "https://wafid.com/appointment/" . $request->token . "/slip/print";
        $document->customer_id = $customer->id;
        $document->required = "اجباري";
        $document->save();

        if ($request->status == 'Fit') {
            # code...
            $customer->medical_examination = 'لائق';
            $customer->save();
            $history = new History();
            $history->description = "تم جلب نتيجة الكشف الطبي وهو :لائق";
            $history->date = now();
            $history->customer_id = $customer->id;
            $history->user_id = $user->id; // يجب تعديل هذا إلى معرف المستخدم الصحيح
            $history->save();
            // حذف أي مستندات سابقة من نوع نتيجة الكشف الطبي
            $customer->documentTypes()->where('document_type', "نتيجة الكشف الطبي")->delete();
            // إنشاء مستند جديد
            $document = new DocumentType();
            $document->document_type = "نتيجة الكشف الطبي";
            $document->status = "موجود بالمكتب";
            $document->file = "https://wafid.com/medical-status/" . $request->token . "/print";
            $document->customer_id = $customer->id;
            $document->required = "اجباري";
            $document->save();
        } elseif ($request->status == 'Unfit') {
            # code...
            $customer->medical_examination = "غير لائق";
            $customer->save();
            $history = new History();
            $history->description = "تم جلب نتيجة الكشف الطبي وهو : غير لائق";
            $history->date = now();
            $history->customer_id = $customer->id;
            $history->user_id = $user->id;
            $history->save();
            // حذف أي مستندات سابقة من نوع نتيجة الكشف الطبي
            $customer->documentTypes()->where('document_type', "نتيجة الكشف الطبي")->delete();
            // إنشاء مستند جديد
            $document = new DocumentType();
            $document->document_type = "نتيجة الكشف الطبي";
            $document->status = "موجود بالمكتب";
            $document->file = "https://wafid.com/medical-status/" . $request->token . "/print";
            $document->customer_id = $customer->id;
            $document->required = "اجباري";
            $document->save();
        }

        return response()->json(['message' => 'تم التحديث بنجاح']);
    }

    public function forgetPasswordPhone(Request $request)
    {
        $request->validate([
            'phone' => 'required|exists:leads_customers,phone',
        ]);

        $this->sendOtp($request->phone);

        return response()->json(['message' => 'تم إرسال كود إعادة تعيين كلمة المرور إلى هاتفك']);
    }

    public function verifyPasswordOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'code' => 'required'
        ]);

        $otp = Otp::where('phone', $request->phone)
            ->where('code', $request->code)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$otp) {
            return response()->json(['message' => 'كود التاكيد خطأ'], 422);
        }

        // حذف الكود بعد التحقق (اختياري)
        $otp->delete();
        $user = LeadsCustomers::where('phone', $request->phone)->first();
        $token = $user->createToken($user->name ?: 'lead-customer')->plainTextToken;

        return response()->json([
            'message' => 'OTP verified successfully',
            'token' => $token
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required|exists:leads_customers,phone',
            'password' => 'required|min:8',
        ]);

        $user = LeadsCustomers::where('phone', $request->phone)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Password reset successfully']);
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            "phone" => 'required|exists:leads_customers,phone',
            'current_password' => 'required',
            'new_password' => 'required|min:8',
        ]);

        $user = LeadsCustomers::where('phone', $request->phone)->first();

        // التحقق من الباسورد القديمة
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'كلمة المرور الحالية غير صحيحة.'], 403);
        }

        // تغيير الباسورد
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'تم تغيير كلمة المرور بنجاح.']);
    }
}
