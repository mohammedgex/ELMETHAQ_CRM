<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Taakeb;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    //
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'phone'    => 'required|string|max:20|unique:companies,phone',
            'password' => 'required|string|min:8',
            'logo'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            "status"   => 'nullable|string|in:company,individual', // الحالة الافتراضية للشركة
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors'  => $validator->errors()
            ], 422);
        }

        // رفع اللوجو إن وُجد
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        // إنشاء الشركة
        $company = Company::create([
            'name'     => $request->name,
            'phone'    => $request->phone,
            'password' => $request->password, // bcrypt يتم تلقائياً من الموديل
            'logo'     => $logoPath,
            'status'   => $request->status ?? 'company', // الحالة الافتراضية للشركة
        ]);

        return response()->json([
            'message' => 'Company registered successfully',
            'company' => $company
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        $company = Company::where('phone', $request->phone)->first();

        if (! $company || ! Hash::check($request->password, $company->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        // إنشاء التوكن
        $token = $company->createToken('company-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'company' => $company
        ]);
    }

    public function getCompanyData()
    {
        $company = auth()->user(); // Assuming the user is authenticated as a company

        return response()->json([
            'company' => $company
        ]);
    }

    // اضافة تعقيب
    public function addTaakeb(Request $request)
    {
        # code...
        $validated = $request->validate([
            'lead_id'            => 'required|exists:leads_customers,id',
            'visa_image'         => 'required|image',
            'issued_number'      => 'required|string|max:255',
            'sponsor_id_number'  => 'required|string|max:255',
            'sponsor_name'       => 'required|string|max:255',
            'sponsor_address'    => 'required|string|max:255',
            'sponsor_phone'      => 'required|string|max:255',
            'consulate'          => 'required|string|max:255',
            'purpose'            => 'required|string|max:255',
        ]);

        // معالجة رفع الصورة إن وجدت
        if ($request->hasFile('visa_image')) {
            $path = $request->file('visa_image')->store('visa_images', 'public');
            $validated['visa_image'] = $path;
        }
        // تعيين الحالة الافتراضية
        $validated['status'] = 'pending';
        $validated['company_id'] = auth()->user()->id; // تعيين معرف الشركة من المستخدم الحالي

        // إنشاء التعقيب
        $taakeb = Taakeb::create($validated);

        return response()->json([
            'message' => 'تم إنشاء التعقيب بنجاح.',
            'data' => $taakeb
        ]);
    }

    public function index()
    {
        $taakebs = Taakeb::latest()->get();
        return view('taakebs.index', compact('taakebs'));
    }

    public function approve($id)
    {
        $taakeb = Taakeb::findOrFail($id);
        $taakeb->status = 'approved';
        $taakeb->save();

        return redirect()->route('taakebs.index')->with('success', 'تمت الموافقة على الطلب.');
    }

    public function reject($id)
    {
        $taakeb = Taakeb::findOrFail($id);
        $taakeb->status = 'rejected';
        $taakeb->save();

        return redirect()->route('taakebs.index')->with('error', 'تم رفض الطلب.');
    }
}
