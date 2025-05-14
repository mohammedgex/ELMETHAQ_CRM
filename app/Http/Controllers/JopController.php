<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JopController extends Controller
{
    public function net($id)
    {
        ini_set('max_execution_time', 300); // 5 minutes

        $customer = Customer::find($id);

        if (!$customer) {
            return redirect()->back()->with(['error' => 'Customer not found']);
        }

        // Check required fields exist
        if (
            empty($customer->name_ar) || empty($customer->name_en_mrz) ||
            empty($customer->passport_id) || empty($customer->passport_expire_date) ||
            empty($customer->date_birth) || empty($customer->card_id) ||
            !$customer->sponser || !$customer->visaType || !$customer->customerGroup ||
            !$customer->customerGroup->visaProfession
        ) {
            return redirect()->back()->with(['error' => 'الرجاء التأكد من اكمال بيانات العميل']);
        }

        $name_ar = explode(" ", $customer->name_ar);
        $name_en = explode(" ", $customer->name_en_mrz);

        if (count($name_ar) < 3 || count($name_en) < 3) {
            return response()->json(['error' => 'Invalid name format'], 400);
        }

        // Assign name parts safely
        $first_ar = $name_ar[0];
        $middle_ar = $name_ar[1] ?? '';
        $last_ar = $name_ar[2] ?? '';
        $end_ar = end($name_ar);

        $first_en = $name_en[0];
        $middle_en = $name_en[1] ?? '';
        $last_en = $name_en[2] ?? '';
        $end_en = end($name_en);

        $data = [
            "UserName" => "مكتب768",
            "Password" => "Ahmed121@@@",
            "VisaKind" => "تأشيرة العمل المؤقت لخدمات الحج والعمرة",
            "NATIONALITY" => "EGY",
            "ResidenceCountry" => "272",
            "EmbassyCode" => "320",
            "NumberOfEntries" => "0",
            "NumberEntryDay" => "90",
            "ResidencyInKSA" => "120",
            "AFIRSTNAME" => $first_ar,
            "AFATHER" => $middle_ar,
            "AGRAND" => $last_ar,
            "AFAMILY" => $end_ar,
            "EFIRSTNAME" => $first_en,
            "EFATHER" => $middle_en,
            "EGRAND" => $last_en,
            "EFAMILY" =>  $end_en,
            "PASSPORTnumber" => $customer->passport_id,
            "PASSPORType" => "1",
            "PASSPORT_ISSUE_PLACE" => "مصر",
            "PASSPORT_ISSUE_DATE" => "05/04/2023",
            "PASSPORT_EXPIRY_DATE" => $customer->passport_expire_date,
            "BIRTH_PLACE" => "القاهرة",
            "BIRTH_DATE" => $customer->date_birth,
            "PersonId" => $customer->card_id,
            "DEGREE" => "-",
            "DEGREE_SOURCE" => "-",
            "ADDRESS_HOME" => "بحره",
            "Personal_Email" => "moha@gmail.com",
            "SPONSER_NAME" => $customer->sponser->name,
            "SPONSER_NUMBER" => $customer->sponser->id_number,
            "SPONSER_ADDRESS" => $customer->sponser->address,
            "SPONSER_PHONE" => $customer->sponser->phone,
            "COMING_THROUGH" => "2",
            "ENTRY_POINT" => "1",
            "ExpectedEntryDate" =>  Carbon::now()->addMonths(2)->format('d/m/Y'),
            "porpose" => $customer->visaType->porpose,
            "car_number" => "SV123",
            "RELIGION" => "1",
            "SOCIAL_STATUS" => "2",
            "Sex" => "1",
            "ClassifyOccupations" => $customer->customerGroup->visaProfession->job_title,
            "JOB_OR_RELATION_Id" => $customer->customerGroup->visaProfession->job
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->timeout(0)->post('http://localhost:3000/submit-all', data: $data);

        $json = $response->json();

        if (isset($json['appNo'])) {
            $customer->e_visa_number = "E" . $json['appNo'];
            $customer->engaz_request = 'تم الحجز';
            $customer->save();
            return redirect()->route('customer.indes')->with("success", "نجح حجز أنجاز للعميل: " . $first_ar . " وتم تخزين الـ e number الخاص به");
        } else {
            return response()->json(['error' => 'Failed to get application number from response'], 500);
        }
    }

    public function sendSms(Request $request)
    {
        $request->validate([
            'customer_ids' => "required",
            "templite"=>"required"
        ]);
        ini_set('max_execution_time', 300); // 5 minutes

        $customers = Customer::whereIn("id", $request->customer_ids)->get();
        foreach ($customers as $customer) {

            Http::withHeaders([
                'Authorization' => 'Bearer 490|iWcKkcltFVb9x4Or4r1uWDbUBiPXt1N4qU7bHmMM61249c65',
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post('https://bulk.whysms.com/api/v3/sms/send', [
                'recipient' => "2".$customer->phone, // make sure it's in correct international format
                'sender_id' => 'Elmethaq Co',
                'type' => 'plain',
                'message' => $request->templite,
            ]);
        }
        return response()->json([
            'success'=>'true'
        ]);
    }
}
