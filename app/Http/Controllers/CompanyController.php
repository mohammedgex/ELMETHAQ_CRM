<?php

namespace App\Http\Controllers;

use App\Models\Company;
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
}
