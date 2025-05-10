<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

use Illuminate\Http\Request;

class JopController extends Controller
{
    public function net($id)
    {
        $customer = Customer::find($id);

        $name_ar = explode(" ", $customer->name_ar);

        $first_ar = $name_ar[0];  // "محمد"
        $middle_ar = $name_ar[1]; // "سيد"
        $last_ar = $name_ar[2];   // "احمد"
        $end_ar = end($name_ar); // "صديق"

        $name_en = explode(" ", $customer->name_en_mrz);

        $first_en = $name_en[0];  // "محمد"
        $middle_en = $name_en[1]; // "سيد"
        $last_en = $name_en[2];   // "احمد"
        $end_en = end($name_en); // "صديق"

        $data = [
            "UserName" => "مكتب768",
            "Password" => "Ahmed121@@@",
            "VisaKind" => "عمل مؤقت",
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
            "ClassifyOccupations" => "833",
            "JOB_OR_RELATION_Id" => "833101"
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('http://localhost:3000/submit-all', $data);

            if ($response->successful()) {
                return $response->json();
            } else {
                Log::error('فشل الإرسال إلى API', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return response()->json(['error' => 'فشل الإرسال إلى السيرفر الخارجي'], 500);
            }
        } catch (\Exception $e) {
            Log::error('استثناء أثناء الإرسال إلى API', [
                'message' => $e->getMessage()
            ]);
            return response()->json(['error' => 'حدث خطأ أثناء محاولة الإرسال'], 500);
        }
    }
}
