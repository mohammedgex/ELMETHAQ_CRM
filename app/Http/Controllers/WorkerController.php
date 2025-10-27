<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    //
    public function store(Request $request)
    {
        // ✅ الفاليديشن
        $validated = $request->validate([
            'name' => ['nullable', 'regex:/^[\p{Arabic}\s]+$/u'],
            'national_id' => ['nullable', 'digits:14', 'regex:/^[23]\d{13}$/', 'unique:workers,national_id'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^(010|011|012|015)[0-9]{8}$/'],
            'personal_photo' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'id_card_photo' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'message' => ['nullable', 'string', 'max:2000'],
        ], [
            'name.regex' => 'الاسم يجب أن يكون باللغة العربية فقط.',
            'national_id.digits' => 'الرقم القومي يجب أن يتكون من 14 رقمًا.',
            'national_id.regex' => 'الرقم القومي غير صالح.',
            'national_id.unique' => 'هذا الرقم القومي مسجل بالفعل.',
            'phone.required' => 'رقم الهاتف مطلوب.',
            'phone.regex' => 'رقم الهاتف يجب أن يبدأ بـ 010 أو 011 أو 012 أو 015 ويتكون من 11 رقمًا.',
            'personal_photo.image' => 'يجب أن تكون الصورة بصيغة صحيحة (JPG أو PNG).',
            'personal_photo.max' => 'أقصى حجم مسموح للصورة هو 2 ميجابايت.',
            'id_card_photo.image' => 'يجب أن تكون صورة البطاقة بصيغة صحيحة (JPG أو PNG).',
        ]);

        // ✅ رفع الملفات إن وجدت
        if ($request->hasFile('personal_photo')) {
            $validated['personal_photo'] = $request->file('personal_photo')->store('workers/photos', 'public');
        }

        if ($request->hasFile('id_card_photo')) {
            $validated['id_card_photo'] = $request->file('id_card_photo')->store('workers/id_cards', 'public');
        }

        // ✅ إنشاء السجل
        Worker::create($validated);

        return redirect()->back()->with('success', 'تم تسجيل بياناتك بنجاح ✅');
    }
}
