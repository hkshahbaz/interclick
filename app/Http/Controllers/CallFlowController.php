<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\TwiML\VoiceResponse;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Cache;

class CallFlowController extends Controller
{
    
    private $phoneNumbers = ['+1234567890', '+9876543210', '+5555555555'];

    public function handleIncomingCall()
    {
       // Handle the array of numbers received in the request body
       $requestNumbers = $request->input('numbers');

        // Check if the caller has a previous destination number
        $previousNumber = Cache::get($callerNumber);
        
        if ($previousNumber !== null) {
            // Repeat caller detected, route the call to the previous destination number
            $response = new VoiceResponse();
            $response->dial($previousNumber);
        } else {
            
            // Rotate calls evenly among the group of people
            $nextNumber = $this->getNextNumber();
            
            // Store the destination number in cache for repeat callers
            Cache::put($callerNumber, $nextNumber, 60); // Cache for 60 minutes
            
            $response = new VoiceResponse();
            $response->dial($nextNumber);
        }

        return response($response)->header('Content-Type', 'text/xml');
    }

    private function getNextNumber()
    {
        $nextNumber = Cache::get('nextNumberIndex', 0);
        $destinationNumber = $this->phoneNumbers[$nextNumber];

        $nextNumber = ($nextNumber + 1) % count($this->phoneNumbers);
        Cache::put('nextNumberIndex', $nextNumber, 0);

        return $destinationNumber;
    }
    
}
