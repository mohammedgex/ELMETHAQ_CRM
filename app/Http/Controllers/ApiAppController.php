<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\LeadsCustomers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Otp;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ApiAppController extends Controller
{
    //
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
            return response()->json(['message' => 'User not found'], 404);
        }
        if ($user->customer_id == null && $user->evaluation == "جارى المعالجة") {
            # code...
            return response()->json(['message' => 'جاري مراجعة بياناتك'], 404);
        }

        // التحقق من صحة كلمة المرور
        // if (!Hash::check($request->password, $user->password)) {
        //     return response()->json(['message' => 'Invalid password'], 401);
        // }



        // $customer = Customer::where('phone', $request->phone)->first();


        // إنشاء توكن للمستخدم باستخدام Sanctum
        $token = $user->createToken('YourAppName')->plainTextToken;

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

    public function getUserData(Request $request)
    {
        $user = Auth::user(); // يجلب المستخدم من التوكن المرسل في الهيدر

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        return response()->json([
            'message' => 'User data retrieved successfully',
            'user' => $user,
            'customer' => $user->customer ? $user->customer->load('documentTypes') : null
        ], 200);
    }
    public function register(Request $request)
    {
        # code...
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'governorate' => 'required',
            'phone' => 'required|unique:leads_customers,phone',
            'phone_two' => 'required|unique:leads_customers,phone_two',
            'job_title_id' => 'required',
            'have_you_ever_traveled_before?' => 'required',
            'password' => 'required',
        ]);
        // حفظ الصورة
        $filePath = $request->file('image')->store('uploads', 'public');
        // إنشاء سجل جديد
        $user = LeadsCustomers::create([
            'name' => $request->name,
            'image' => $filePath,
            'governorate' => $request->governorate,
            'phone' => $request->phone,
            'phone_two' => $request->phone_two,
            'job_title_id' => $request->job_title_id,
            'have_you_ever_traveled_before?' => $request['have_you_ever_traveled_before?'],
            'password' => Hash::make($request->password),
            'status' => 'عميل محتمل'
        ]);
        $this->sendOtp($request->phone);

        // استجابة (ممكن ترجع JSON لو API)
        return response()->json([
            'status' => 'success',
            'message' => 'Check messages on your phone.',
            'data' => $user->phone,
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
            'Authorization' => 'Bearer 490|iWcKkcltFVb9x4Or4r1uWDbUBiPXt1N4qU7bHmMM61249c65',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post('https://bulk.whysms.com/api/v3/sms/send', [
            'recipient' => '2' . $phone,
            'sender_id' => 'Elmethaq Co',
            'type' => 'plain',
            'message' => 'Your OTP code is: ' . $code,
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
            return response()->json(['message' => 'Invalid or expired OTP'], 422);
        }

        // حذف الكود بعد التحقق (اختياري)
        $otp->delete();
        $user = LeadsCustomers::where('phone', $request->phone)->first();
        $user->phone_verified_at = now();
        $user->save();
        $token = $user->createToken($user->name)->plainTextToken;


        return response()->json([
            'message' => 'OTP verified successfully',
            'token' => $token
        ]);
    }
    public function completeData(Request $request)
    {
        # code...
        $request->validate([
            'card_id' => 'required',
            'date_of_birth' => 'required',
            'age' => 'required',
            'img_national_id_card' => 'required',
            'img_national_id_card_back' => 'required',
            'passport_numder' => 'nullable',
            'passport_photo' => 'nullable',
            'licence_type' => 'required',
            'license_photo' => 'required',
        ]);
        $user = auth()->user();

        // حفظ الصور
        $imgNationalIdCardPath = $request->file('img_national_id_card')->store('uploads/national_id_cards', 'public');
        $imgNationalIdCardBackPath = $request->file('img_national_id_card_back')->store('uploads/national_id_cards_back', 'public');

        $passportPhotoPath = null;
        if ($request->hasFile('passport_photo')) {
            $passportPhotoPath = $request->file('passport_photo')->store('uploads/passports', 'public');
        }

        $licensePhotoPath = $request->file('license_photo')->store('uploads/licenses', 'public');

        // إنشاء سجل جديد
        $customer = $user->update([
            'card_id' => $request->card_id,
            'date_of_birth' => $request->date_of_birth,
            'age' => $request->age,
            'img_national_id_card' => $imgNationalIdCardPath,
            'img_national_id_card_back' => $imgNationalIdCardBackPath,
            'passport_numder' => $request->passport_numder,
            'passport_photo' => $passportPhotoPath,
            'licence_type' => $request->licence_type,
            'license_photo' => $licensePhotoPath,
            'evaluation' => "جارى المعالجة",
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $customer
        ], 201);
    }
}
