<?php

namespace App\Http\Controllers\SMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\SMSRequestValidator;

use App\Helpers\Common;
use App\Services\SMSClone;

use Illuminate\Support\Facades\Log;

class SMSController extends Controller
{
    public function sendMessage(SMSRequestValidator $request) {
        try {
            $body = $request->validated();
            $page = $body['page'] ?? 1;
            
            $common = new Common();
            
            $recipients = htmlspecialchars($body['recipients']);

            $normalised_numbers = $common->normalise_phone_numbers($recipients);
            
            $phone_numbers = $common->validate_phone_numbers($normalised_numbers);
            
            $prices = $common->get_prices();

            $cost_per_recipient = [];
            $costs = [];
            
            foreach ($phone_numbers as $key => $number) {
                $phone_number = $common->adjust_phone_number($number);
                $needle = substr($phone_number, 0, 6);
                
                $price = $common->get_prefix_price($needle, $prices);
                
                $cost = round($page * $price, PHP_ROUND_HALF_UP);

                $cost_per_recipient[$phone_number] = $cost;
                array_push($costs, $cost);
            }

            $data = [
                'cost_per_recipient' => $cost_per_recipient,
                'total_cost' => array_sum($costs),
                'total_numbers' => count($phone_numbers),
                'total_pages' => $page
            ];

            //send_sms
            $response = (new SMSClone())->send($body['message'], $body['sender_id'], $phone_numbers);

            Log::info("SMS_CLONE_RESPONSE => " . $response);

            return response()->json(['data' => $data, 'message' => 'Message successfully sent.'], 200);
        } catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
