<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Twilio\TwiML\VoiceResponse;
use App\Models\Attribute;
use Twilio\Exceptions\TwilioException;
use App\Models\Tags;
use Log;
class TwilioController extends Controller
{
    public function show(Request $request, $phone_number)
    {
      $client = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
      $MY = env('TWILIO_PHONE_NUMBER');
      $messages = $client->messages->read([], 1000);
      $phoneNumbers = collect($messages)->map(function ($message) {
          return $message->to;
      })->unique();
      $involvedNumbers = array_unique(array_merge(array_column($messages, 'to'), array_column($messages, 'from')));
      $sidebar = [];
      $tagarray = [];
      foreach ($involvedNumbers as $number) {
          $COST = 0;
          if ($number != $MY && $number != '+16073095142') {
              $attribute = Attribute::where('user_number', $number)->first();
      
              if (!empty($attribute)) {
                  $tags = $attribute["tags"];
                  $decodedData = json_decode($tags, true); // Set the second parameter to true for an associative array
      
                  if (!empty($decodedData)) {
                      foreach ($decodedData as $tagDetail) {
                          $tag = Tags::find($tagDetail);
                          if (!empty($tag["cost"])) {
                              $COST += $tag["cost"];
                              $tagarray[] = [
                                  'id' => $tag["id"],
                                  'name' => $tag["name"],
                                  'cost' => $tag["cost"]
                              ];
                          }
                      }
                  }
      
                  if (!empty($attribute["status"])) {
                      $status = $attribute["status"];
                  } else {
                      $status = 'open';
                  }
      
                  $attribute = [
                      'campaign' => $attribute["campaign"],
                      'source' => $attribute["source"],
                      'custom_note' => $attribute["custom_note"]
                  ];
              } else {
                  $campaign = 'campaign';
                  $source = 'source';
                  $custom_note = '';
                  $status = 'open';
                  $attribute = [
                      'campaign' => $campaign,
                      'source' => $source,
                      'custom_note' => $custom_note
                  ];
              }
      
              $matching_messages = []; // Reset the $matching_messages array for each number
      
              foreach ($messages as $message) {
                  if ($message->from == $number || $message->to == $number) {
                      $matching_messages[] = [
                          'body' => $message->body,
                          'time' => $message->dateCreated->format('Y-m-d h:i:A'),
                          'time2' => $message->dateCreated->format('h:i:A'),
                          'create_at' => $message->dateCreated->format('Y-m-d h:i:s'),
                          'to' => $message->to,
                          'from' => $message->from,
                      ];
                  }
              }
      
              usort($matching_messages, function ($a, $b) {
                  return strtotime($a['create_at']) > strtotime($b['create_at']) ? 1 : -1;
              });
      
              $sidebar[] = [
                  'number' => $number,
                  'tags' => $tagarray,
                  'status' => $status,
                  'total_cost' => $COST,
                  'attribute' => $attribute,
                  'message' => $matching_messages,
                  'time' => end($matching_messages)['time2'],
                  'lastmsg' => end($matching_messages)['body']
              ];
          }
      }
      

      foreach ($sidebar as $currentValue) {
        if ($phone_number == $currentValue["number"]) {
          $current=[
            'number'=>$currentValue["number"],
            'tags'=>$currentValue["tags"],
            'status'=>$currentValue["status"],
            'total_cost'=>$currentValue["total_cost"],
            'attribute'=> $currentValue["attribute"],
            'message'=>$currentValue["message"],
            'time'=>$currentValue["time"],
            'lastmsg'=>$currentValue["lastmsg"]
          ];
          
        }
      }
      return view('conversation', [
        'data'=>$sidebar,
        'current'=>$current
      ]);
  }
    
public function getConversations()
{
  $client = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
  $MY = env('TWILIO_PHONE_NUMBER');
  $messages = $client->messages->read([], 1000);
  $phoneNumbers = collect($messages)->map(function ($message) {
      return $message->to;
  })->unique();
  
  $involvedNumbers = array_unique(array_merge(array_column($messages, 'to'), array_column($messages, 'from')));
  $sidebar = [];
  $tagarray = [];
  foreach ($involvedNumbers as $number) {
      $COST = 0;
      if ($number != $MY && $number != '+16073095142') {
          $attribute = Attribute::where('user_number', $number)->first();
  
          if (!empty($attribute)) {
              $tags = $attribute["tags"];
              $decodedData = json_decode($tags, true); // Set the second parameter to true for an associative array
  
              if (!empty($decodedData)) {
                  foreach ($decodedData as $tagDetail) {
                      $tag = Tags::find($tagDetail);
                      if (!empty($tag["cost"])) {
                          $COST += $tag["cost"];
                          $tagarray[] = [
                              'id' => $tag["id"],
                              'name' => $tag["name"],
                              'cost' => $tag["cost"]
                          ];
                      }
                  }
              }
  
              if (!empty($attribute["status"])) {
                  $status = $attribute["status"];
              } else {
                  $status = 'open';
              }
  
              $attribute = [
                  'campaign' => $attribute["campaign"],
                  'source' => $attribute["source"],
                  'custom_note' => $attribute["custom_note"]
              ];
          } else {
              $campaign = 'campaign';
              $source = 'source';
              $custom_note = '';
              $status = 'open';
              $attribute = [
                  'campaign' => $campaign,
                  'source' => $source,
                  'custom_note' => $custom_note
              ];
          }
  
          $matching_messages = []; // Reset the $matching_messages array for each number
  
          foreach ($messages as $message) {
              if ($message->from == $number || $message->to == $number) {
                  $matching_messages[] = [
                      'body' => $message->body,
                      'time' => $message->dateCreated->format('Y-m-d h:i:A'),
                      'time2' => $message->dateCreated->format('h:i:A'),
                      'create_at' => $message->dateCreated->format('Y-m-d h:i:s'),
                      'to' => $message->to,
                      'from' => $message->from,
                  ];
              }
          }
  
          usort($matching_messages, function ($a, $b) {
              return strtotime($a['create_at']) > strtotime($b['create_at']) ? 1 : -1;
          });
  
          $sidebar[] = [
              'number' => $number,
              'tags' => $tagarray,
              'status' => $status,
              'total_cost' => $COST,
              'attribute' => $attribute,
              'message' => $matching_messages,
              'time' => end($matching_messages)['time2'],
              'lastmsg' => end($matching_messages)['body']
          ];
      }
  }
  
  return view('conversation', [
      'data' => $sidebar,
      'current' => $sidebar[0]
  ]);
}
public function sendSms(Request $request)
    {
        $sid = env('TWILIO_ACCOUNT_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $twilioNumber = env('TWILIO_PHONE_NUMBER');

        $client = new Client($sid, $token);

        $toNumber = $request->input('to');
        $message = $request->input('message');
        if (empty($message)) {
            return redirect()->back()->with('error', 'Please enter a message.');
        }
        $client->messages->create(
            $toNumber,
            array(
                'from' => $twilioNumber,
                'body' => $message
            )
        );

        return redirect()->back();
    }
    public function getTrackingNumbers()
    {
        $client = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
        
        $matching_messages = [];
    
        $numbers = $client->incomingPhoneNumbers->read(['voiceUrl'], 20); // Retrieve up to 20 numbers with voiceUrl
        
        foreach ($numbers as $number) {
            $activeNumberSid = $number->sid;
            $forwardedNumber = $number->phoneNumber ?? 'N/A';
            if ($number->voiceUrl) {
                $xml = simplexml_load_string(file_get_contents($number->voiceUrl));
                $forwardedNumber = $xml->Dial[0]->Number ?? $forwardedNumber;
            }
            $calls = $client->calls->read([
                'to' => $number->phoneNumber,
                'status' => 'completed',
                'limit' => 1
            ]); // Retrieve the last completed call for the number
            $campaign = $number->friendlyName;
            $lastCallTime = $calls ? $calls[0]->endTime->format('n/j - g:ia') : 'N/A';
            $totalCalls = $client->calls->read([
                'to' => $number->phoneNumber,
                'status' => 'completed'
            ]);
            $matching_messages[] = [
                'tracking' => $number->phoneNumber,
                'sid' =>  $activeNumberSid,
                'forwarded'=> $forwardedNumber,
                'lastCallTime' => $lastCallTime,
                'totalCalls' => count($totalCalls),
                'campaign'=> $campaign,
            ];
        }
        
        return view('my-number', [
            'Tracking' => $matching_messages,
        ]);
    }


    public function customNote()
    {
        return view('customNote');
    }
    public function customNotePost(Request $request, Attribute $attribute)
    {
        $input = $request->all();
          
        Log::info($input);
        $id='+'.$input["id"];
        Attribute::where('user_number', $id)
            ->update([
                'custom_note' => '',
            ]);
        return response()->json(['success'=>'Got Simple Ajax Request.'.$id,
    'status'=>true]);
    }
    public function edit()
    {
        return view('edit');
    }
    public function editPost(Request $request, Attribute $attribute)
    {
        $input = $request->all();
        Log::info($input);
        $id='+'.$input["id"];
        $status = 'open'; // toggle status
        Attribute::where('user_number', $id)
            ->update([
                'status' => $status,
            ]);
            return response()->json([
                'status' => true
            ]);
    }
    public function edit2()
    {
        return view('edit2');
    }
    public function editPost2(Request $request, Attribute $attribute)
    {
        $input = $request->all();
        Log::info($input);
        $id='+'.$input["id"];
        $status = 'pending'; // toggle status
        Attribute::where('user_number',$id)
            ->update([
                'status' => $status,
            ]);
            return response()->json([
                'status' => true
            ]);
    }
    public function edit3()
    {
        return view('edit2');
    }
    public function editPost3(Request $request, Attribute $attribute)
    {
        $input = $request->all();
        Log::info($input);
        $id='+'.$input["id"];
        $status = 'close'; // toggle status
        Attribute::where('user_number',$id)
            ->update([
                'status' => $status,
            ]);
            return response()->json([
                'status' => true
            ]);
    }
    // PPC Page
    public function PPC(Request $request, $sid)
    {
        $client = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
        // Retrieve the phone number details
        $phoneNumber = $client->incomingPhoneNumbers($sid)->fetch();
        $my = $phoneNumber->phoneNumber;
        $myfriendlyName = $phoneNumber->friendlyName;
        $calls = $client->calls->read([
          'to' => $my
      ]);
        $logs=[];
        // Iterate over each call and fetch the associated flow friendly name
        foreach ($calls as $call) {
            $callsid = $call->sid;
            $status = $call->status;
            $duration = gmdate('H:i:s', $call->duration);
            $from = $call->from;
            $to = $call->to;
            $dateCreated = $call->dateCreated;
            $callTime = $dateCreated->format('n/j - g:ia');
            if ($to == $my) {
              $logs[] = [
                'type' => 'CALL',
                'campaign'=>$myfriendlyName,
                // 'source'=>$source,
                'executionsid'=>$callsid,
                'status'=>$status,
                'dailed'=>$my,
                'duration'=>$duration,
                'from'=>$from,
                'date'=> $callTime
                  ];
            }
        }
        $smsLogs = $client->messages->read([
          'to' => $my
      ]);
        foreach ($smsLogs as $smsLog) {
          $attribute = Attribute::where('user_number', $smsLog->from)->first();
            if(!empty($attribute->campaign)){
                $campaign = $attribute->campaign;
            }else{
                $campaign = 'N/A';
            }
            if(!empty($attribute->source)){
                $source = $attribute->source;
            }else{
                $source = 'N/A';
            }
          $logs[] = [
            'type' => 'SMS',
            'campaign'=>$myfriendlyName,
            // 'source'=>$source,
            'executionsid' => $smsLog->sid,
            'from' => $smsLog->from,
            'dailed' => $smsLog->to,
            'status' => $smsLog->status,
            'duration'=>'N/A',
            'date' => $smsLog->dateSent->format('n/j - g:ia'),
        ];
      }
      usort($logs, function ($a, $b) {
        $dateA = strtotime($a['date']);
        $dateB = strtotime($b['date']);
        return $dateA <=> $dateB;
    });
        return view('PPC-landing-page', [
          'data'=> $logs,
          'friendlyName'=>$myfriendlyName,
          'sid'=>$sid
      ]);
        
    }
    public function realtime(Request $request, $sid)
    {
      $client = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
      $phoneNumber = $client->incomingPhoneNumbers($sid)->fetch();
      $my = $phoneNumber->phoneNumber;
      $myfriendlyName = $phoneNumber->friendlyName;
      try {
        $events = $client->monitor->v1->events
        ->read([
          'phoneNumber' => $my
               ],
               20
        );
        // Extract the desired details from the logs
        $eventLogs = [];

        foreach ($events as $log) {
            $eventLogs[] = [
                'sid' => $log->sid,
                'eventType' => $log->eventType,
                'actorType' => $log->actorType,
                'dateCreated' => $log->eventDate->format('D, n/j/y, g:i:s A'),
                'source' => $log->source
                // Add any additional details you need
            ];
        }
        return view('real-time', [
          'my'=>$my,
          'friendlyName'=>$myfriendlyName,
          'sid'=>$sid,
          'eventlogs'=>$eventLogs
      ]);
    } catch (Exception $e) {
        // Handle any errors that occur during the process
        return null;
    }
  
    }
    public function callconfig(Request $request, $sid)
    {
      $twilio = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
      $phoneNumber = $twilio->incomingPhoneNumbers($sid)->fetch();
      $my = $phoneNumber->phoneNumber;
      $myfriendlyName = $phoneNumber->friendlyName;
      $lookup = $twilio->lookups->v1->phoneNumbers($my)->fetch(['type' => 'carrier']);
      $countryCode = $lookup->countryCode;
      $firstDigit = (int) substr($my, 1, 1);
      $flows = $twilio->studio->v1->flows->read();
      $array = [];
      foreach ($flows as $flow) {
        $flowSid = $flow->sid;
        $flowFriendlyName = $flow->friendlyName;
        $dateCreated = $flow->dateCreated->format('D, n/j/y, g:i:s A');
        $phoneNumbers = $twilio->incomingPhoneNumbers->read([
          'voiceApplicationSid' => $flowSid,
        ]);
        $phoneNumberCount = count($phoneNumbers);
        $array[] =  [
          'flowSid'=>$flowSid,
          'friendlyName'=>$flowFriendlyName,
      ];
      }
      return view('call-config', [
        'sid'=>$sid,
        'callflows'=>$array,
        'mynumber'=>$my,
        'friendlyName'=>$myfriendlyName,
        'countrycode'=>$countryCode.' | '.$firstDigit
    ]);
    }
    public function configsystem(Request $request)
    {
        $sid = env('TWILIO_ACCOUNT_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $twilioNumber = env('TWILIO_PHONE_NUMBER');

        $client = new Client($sid, $token);
        $phoneNumberSid = $request->input('sid');
        $campaignname = $request->input('campaignname');
        if ($campaignname == '') {
          return redirect()->back()->with('error', 'Campaign name will never be empty');
        }
        $flow = $request->input('flow');
        $callrecording = $request->input('callrecording');
        $pool = $request->input('pool');
        $swapout = $request->input('swapout');
        $callerId = $request->input('callerId');
        if ($callerId == 'true') {
          # code...
          $callerId = true;
        }else{
          $callerId=false;
        }
        if ($callrecording == 'true') {
          # code...
          $incomingPhoneNumber = $client->incomingPhoneNumbers($phoneNumberSid)
          ->update(array('voiceMethod' => 'POST', 'voiceUrl' => 'http://127.0.0.1:8000/my-number'));
        }
        if ($flow != 'Select Call Flow' && $swapout != '') {
          $incomingPhoneNumber = $client->incomingPhoneNumbers($phoneNumberSid)
          ->update(array(
              'voiceMethod' => 'POST',
              'voiceUrl' => 'https://handler.twilio.com/twiml/'.$flow,
              'voiceCallerIdLookup' => true,
              'friendlyName' => $campaignname,
              'callerIdEnabled' => $callerId,
              'phoneNumber' => $swapout
          ));
          $phoneNumberPool = [];
    // Loop through to create 6 phone numbers
    for ($i = 0; $i < $pool; $i++) {
        $phoneNumber = $client->incomingPhoneNumbers
                              ->create(array('phoneNumber' => $swapout));
        $phoneNumberPool[] = $phoneNumber->sid;
    }
        }

        return redirect()->back()->with('success', 'Setting saved successfully');
    }
    public function automation(Request $request, $sid){

      return view('automation', [
        'sid'=>$sid,
    ]);

    }
    
    public function deleteevent()
    {
      
        return view('deleteevent');
    }
    public function deleteevent2(Request $request)
    {
      $sid = $request->sid;
      $client = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
      // Delete the Twilio number using its SID
    $response = $client->incomingPhoneNumbers($sid)->delete();
    if ($response) {
        // Number successfully deleted
        return response()->json(['status' => true,'message' => 'Number deleted successfully']);
    } else {
        // Failed to delete the number
        return response()->json(['status' => false,'message' => 'Failed to delete the number'], 500);
    }
    }



    public function makeflow()
    {
        return view('makeflow');
    }
    public function makeflowPost(Request $request)
    {
        $IVRNAmeva = $request->IVRNAme;
        $welcomeText = $request->welcomeText;
        $sid = getenv("TWILIO_ACCOUNT_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio = new Client($sid, $token);
        $forword_number = $request->forword_number;
        $sim_check = $request->sim_check1;
        $forword_check = $request->forword_check;
        $forword_duration = $request->forword_duration;
        $sim_numbers = $request->sim_numbers;//array
        $sim_duration = $request->sim_duration;
        $menu_text = $request->menu_text;
        $pressNumber = $request->pressNumber;
        $press = $request->press;
        $menucount = count($press);
        $rubin_numbers = $request->rubin_numbers;//array
        if(empty($sim_numbers) && empty($rubin_numbers) && empty($menu_text) && !empty($forword_number)) {
            if ($forword_check == "true") {
                $flow = $twilio->studio->v2->flows
        ->create("$IVRNAmeva", // friendlyName
         "draft", // status
         [
            "description"=> "IVR",
            "states"=> [
              [
                "name"=> "Trigger",
                "type"=> "trigger",
                "transitions"=> [
                  [
                    "event"=> "incomingMessage"
                  ],
                  [
                    "next"=> "Greeting",
                    "event"=> "incomingCall"
                  ],
                  [
                    "event"=> "incomingConversationMessage"
                  ],
                  [
                    "event"=> "incomingRequest"
                  ],
                  [
                    "event"=> "incomingParent"
                  ]
                ],
                "properties"=> [
                  "offset"=> [
                    "x"=> 250,
                    "y"=> 50
                  ]
                ]
              ],
              [
                "name"=> "connect_call_to_sales",
                "type"=> "connect-call-to",
                "transitions"=> [
                  [
                    "event"=> "callCompleted"
                  ]
                ],
                "properties"=> [
                  "offset"=> [
                    "x"=> 440,
                    "y"=> 710
                  ],
                  "caller_id"=> "[[contact.channel.address]]",
                  "record"=> true,
                  "noun"=> "number",
                  "to"=> "$forword_number",
                  "timeout"=> $forword_duration
                ]
              ],
              [
                "name"=> "Greeting",
                "type"=> "say-play",
                "transitions"=> [
                  [
                    "next"=> "gather_1",
                    "event"=> "audioComplete"
                  ]
                ],
                "properties"=> [
                  "voice"=> "alice",
                  "offset"=> [
                    "x"=> 440,
                    "y"=> 220
                  ],
                  "loop"=> 1,
                  "say"=> "$welcomeText",
                  "language"=> "en-US"
                ]
              ],
              [
                "name"=> "gather_1",
                "type"=> "gather-input-on-call",
                "transitions"=> [
                  [
                    "next"=> "connect_call_to_sales",
                    "event"=> "keypress"
                  ],
                  [
                    "event"=> "speech"
                  ],
                  [
                    "event"=> "timeout"
                  ]
                ],
                "properties"=> [
                  "voice"=> "alice",
                  "number_of_digits"=> 1,
                  "speech_timeout"=> "auto",
                  "offset"=> [
                    "x"=> 450,
                    "y"=> 450
                  ],
                  "loop"=> 1,
                  "finish_on_key"=> "",
                  "say"=> "Please press any key to continue.",
                  "language"=> "en-US",
                  "stop_gather"=> true,
                  "gather_language"=> "en",
                  "profanity_filter"=> "true",
                  "timeout"=> 3
                ]
              ]
            ],
            "initial_state"=> "Trigger",
            "flags"=> [
              "allow_concurrent_calls"=> true
            ]
          ]
        );
        return response()->json([
            'status' => true,
            'message' => 'Forwording Call Flow Created SuccessFully'
        ]);
            }else{
                $flow = $twilio->studio->v2->flows
                ->create("$IVRNAmeva", // friendlyName
                 "draft", // status
                 [
                    "description"=> "IVR",
                    "states"=> [
                      [
                        "name"=> "Trigger",
                        "type"=> "trigger",
                        "transitions"=> [
                          [
                            "event"=> "incomingMessage"
                          ],
                          [
                            "next"=> "Greeting",
                            "event"=> "incomingCall"
                          ],
                          [
                            "event"=> "incomingConversationMessage"
                          ],
                          [
                            "event"=> "incomingRequest"
                          ],
                          [
                            "event"=> "incomingParent"
                          ]
                        ],
                        "properties"=> [
                          "offset"=> [
                            "x"=> 250,
                            "y"=> 50
                          ]
                        ]
                      ],
                      [
                        "name"=> "connect_call_to_sales",
                        "type"=> "connect-call-to",
                        "transitions"=> [
                          [
                            "event"=> "callCompleted"
                          ]
                        ],
                        "properties"=> [
                          "offset"=> [
                            "x"=> 450,
                            "y"=> 460
                          ],
                          "caller_id"=> "[[contact.channel.address]]",
                          "record"=> true,
                          "noun"=> "number",
                          "to"=> "$forword_number",
                          "timeout"=> $forword_duration
                        ]
                      ],
                      [
                        "name"=> "Greeting",
                        "type"=> "say-play",
                        "transitions"=> [
                          [
                            "next"=> "connect_call_to_sales",
                            "event"=> "audioComplete"
                          ]
                        ],
                        "properties"=> [
                          "voice"=> "alice",
                          "offset"=> [
                            "x"=> 440,
                            "y"=> 220
                          ],
                          "loop"=> 1,
                          "say"=> "$welcomeText",
                          "language"=> "en-US"
                        ]
                      ]
                    ],
                    "initial_state"=> "Trigger",
                    "flags"=> [
                      "allow_concurrent_calls"=> true
                    ]
                  ]
                );
                return response()->json([
                    'status' => true,
                    'message' => ' Forwording Call Flow Created SuccessFully'
                ]);
            }
        }elseif(empty($forword_number) && empty($rubin_numbers) && empty($menu_text) && !empty($sim_numbers) ) {
            $formattedNumbers = '';
            $index = 0;
            while ($index < count($sim_numbers)) {
                $formattedNumbers .= $sim_numbers[$index];
                if ($index < count($sim_numbers) - 1) {
                    $formattedNumbers .= ',';
                }
                $index++;
            }
            
            
                    if ($sim_check == "true") {
                            $flow = $twilio->studio->v2->flows
                            ->create("$IVRNAmeva", // friendlyName
                     "draft", // status
                     [
                        "description"=> "IVR",
                        "states"=> [
                          [
                            "name"=> "Trigger",
                            "type"=> "trigger",
                            "transitions"=> [
                              [
                                "event"=> "incomingMessage"
                              ],
                              [
                                "next"=> "Greeting",
                                "event"=> "incomingCall"
                              ],
                              [
                                "event"=> "incomingConversationMessage"
                              ],
                              [
                                "event"=> "incomingRequest"
                              ],
                              [
                                "event"=> "incomingParent"
                              ]
                            ],
                            "properties"=> [
                              "offset"=> [
                                "x"=> 250,
                                "y"=> 50
                              ]
                            ]
                          ],
                          [
                            "name"=> "connect_call_to_sales",
                            "type"=> "connect-call-to",
                            "transitions"=> [
                              [
                                "event"=> "callCompleted"
                              ]
                            ],
                            "properties"=> [
                              "sip_username"=> "",
                              "sip_endpoint"=> "",
                              "offset"=> [
                                "x"=> 440,
                                "y"=> 710
                              ],
                              "caller_id"=> "[[contact.channel.address]]",
                              "record"=> true,
                              "noun"=> "number-multi",
                              "to"=> "$formattedNumbers",
                               "sip_password"=> "",
                               "timeout"=> $sim_duration
                            ]
                          ],
                          [
                            "name"=> "Greeting",
                            "type"=> "say-play",
                            "transitions"=> [
                              [
                                "next"=> "gather_1",
                                "event"=> "audioComplete"
                              ]
                            ],
                            "properties"=> [
                              "voice"=> "alice",
                              "offset"=> [
                                "x"=> 440,
                                "y"=> 220
                              ],
                              "loop"=> 1,
                              "say"=> "$welcomeText",
                              "language"=> "en-US"
                            ]
                          ],
                          [
                            "name"=> "gather_1",
                            "type"=> "gather-input-on-call",
                            "transitions"=> [
                              [
                                "next"=> "connect_call_to_sales",
                                "event"=> "keypress"
                              ],
                              [
                                "event"=> "speech"
                              ],
                              [
                                "event"=> "timeout"
                              ]
                            ],
                            "properties"=> [
                              "voice"=> "alice",
                              "number_of_digits"=> 1,
                              "speech_timeout"=> "auto",
                              "offset"=> [
                                "x"=> 450,
                                "y"=> 450
                              ],
                              "loop"=> 1,
                              "finish_on_key"=> "",
                              "say"=> "Please press any key to continue.",
                              "language"=> "en-US",
                              "stop_gather"=> true,
                              "gather_language"=> "en",
                              "profanity_filter"=> "true",
                              "timeout"=> 3
                            ]
                          ]
                        ],
                        "initial_state"=> "Trigger",
                        "flags"=> [
                          "allow_concurrent_calls"=> true
                        ]
                      ]
                    );
                    return response()->json([
                        'status' => true,
                        'message' => 'Simultaneous Ring Call Flow Created SuccessFully'
                    ]);
                           
                        }else {
                            
                            $flow = $twilio->studio->v2->flows
                            ->create("$IVRNAmeva", // friendlyName
                             "draft", // status
                             [
                                "description"=> "IVR",
                                "states"=> [
                                  [
                                    "name"=> "Trigger",
                                    "type"=> "trigger",
                                    "transitions"=> [
                                      [
                                        "event"=> "incomingMessage"
                                      ],
                                      [
                                        "next"=> "Greeting",
                                        "event"=> "incomingCall"
                                      ],
                                      [
                                        "event"=> "incomingConversationMessage"
                                      ],
                                      [
                                        "event"=> "incomingRequest"
                                      ],
                                      [
                                        "event"=> "incomingParent"
                                      ]
                                    ],
                                    "properties"=> [
                                      "offset"=> [
                                        "x"=> 250,
                                        "y"=> 50
                                      ]
                                    ]
                                  ],
                                  [
                                    "name"=> "connect_call_to_sales",
                                    "type"=> "connect-call-to",
                                    "transitions"=> [
                                      [
                                        "event"=> "callCompleted"
                                      ]
                                    ],
                                    "properties"=> [
                                      "sip_username"=> "",
                                      "sip_endpoint"=> "",
                                      "offset"=> [
                                        "x"=> 450,
                                        "y"=> 460
                                      ],
                                      "caller_id"=> "[[contact.channel.address]]",
                                      "record"=> true,
                                      "noun"=> "number-multi",
                                      "to"=> "$formattedNumbers",
                                      "sip_password"=> "",
                                      "timeout"=> $sim_duration
                                    ]
                                  ],
                                  [
                                    "name"=> "Greeting",
                                    "type"=> "say-play",
                                    "transitions"=> [
                                      [
                                        "next"=> "connect_call_to_sales",
                                        "event"=> "audioComplete"
                                      ]
                                    ],
                                    "properties"=> [
                                      "voice"=> "alice",
                                      "offset"=> [
                                        "x"=> 440,
                                        "y"=> 220
                                      ],
                                      "loop"=> 1,
                                      "say"=> "$welcomeText",
                                      "language"=> "en-US"
                                    ]
                                  ]
                                ],
                                "initial_state"=> "Trigger",
                                "flags"=> [
                                  "allow_concurrent_calls"=> true
                                ]
                              ]
                            );
                            return response()->json([
                                'status' => true,
                                'message' => 'Simultaneous Ring Call Flow Created SuccessFully'
                            ]);
                        }
}elseif(empty($sim_numbers) && empty($rubin_numbers) && empty($forword_number) && !empty($menu_text)) {

  if ($menucount == '2') {
    $flow = $twilio->studio->v2->flows
    ->create("$IVRNAmeva", // friendlyName
     "draft", // status
    [
          "description"=> "IVR",
          "states"=> [
            [
              "name"=> "Trigger",
              "type"=> "trigger",
              "transitions"=> [
                [
                  "event"=> "incomingMessage"
                ],
                [
                  "next"=> "Greeting",
                  "event"=> "incomingCall"
                ],
                [
                  "event"=> "incomingConversationMessage"
                ],
                [
                  "event"=> "incomingRequest"
                ],
                [
                  "event"=> "incomingParent"
                ]
              ],
              "properties"=> [
                "offset"=> [
                  "x"=> 250,
                  "y"=> 50
                ]
              ]
            ],
            [
              "name"=> "connect_call_to_sales",
              "type"=> "connect-call-to",
              "transitions"=> [
                [
                  "event"=> "callCompleted"
                ]
              ],
              "properties"=> [
                "offset"=> [
                  "x"=> 100,
                  "y"=> 1080
                ],
                "caller_id"=> "[[contact.channel.address]]",
                "record"=> true,
                "noun"=> "number",
                "to"=> "$pressNumber[0]",
                "timeout"=> 20
              ]
            ],
            [
              "name"=> "Greeting",
              "type"=> "say-play",
              "transitions"=> [
                [
                  "next"=> "gather_1",
                  "event"=> "audioComplete"
                ]
              ],
              "properties"=> [
                "voice"=> "alice",
                "offset"=> [
                  "x"=> 440,
                  "y"=> 220
                ],
                "loop"=> 1,
                "say"=>"$welcomeText",
                "language"=> "en-US"
              ]
            ],
            [
              "name"=> "gather_1",
              "type"=> "gather-input-on-call",
              "transitions"=> [
                [
                  "next"=> "press1",
                  "event"=> "keypress"
                ],
                [
                  "event"=> "speech"
                ],
                [
                  "event"=> "timeout"
                ]
              ],
              "properties"=> [
                "voice"=> "alice",
                "number_of_digits"=> 1,
                "speech_timeout"=> "auto",
                "offset"=> [
                  "x"=> 450,
                  "y"=> 450
                ],
                "loop"=> 1,
                "finish_on_key"=> "",
                "say"=>"$menu_text",
                "language"=> "en-US",
                "stop_gather"=> true,
                "gather_language"=> "en",
                "profanity_filter"=> "true",
                "timeout"=> 3
              ]
            ],
            [
              "name"=> "press1",
              "type"=> "split-based-on",
              "transitions"=> [
                [
                  "next"=> "wrong_input",
                  "event"=> "noMatch"
                ],
                [
                  "next"=> "wait_for_sales",
                  "event"=> "match",
                  "conditions"=> [
                    [
                      "friendly_name"=> "If value equal_to 1",
                      "arguments"=> [
                        "[[widgets.gather_1.Digits]]"
                      ],
                      "type"=> "equal_to",
                      "value"=> "$press[0]"
                    ]
                  ]
                ],
                [
                  "next"=> "wait_for_supports",
                  "event"=> "match",
                  "conditions"=> [
                    [
                      "friendly_name"=> "If value equal_to 2",
                      "arguments"=> [
                        "[[widgets.gather_1.Digits]]"
                      ],
                      "type"=> "equal_to",
                      "value"=> "$press[1]"
                    ]
                  ]
                ]
              ],
              "properties"=> [
                "input"=> "[[widgets.gather_1.Digits]]",
                "offset"=> [
                  "x"=> 80,
                  "y"=> 730
                ]
              ]
            ],
            [
              "name"=> "connect_to_support",
              "type"=> "connect-call-to",
              "transitions"=> [
                [
                  "event"=> "callCompleted"
                ]
              ],
              "properties"=> [
                "offset"=> [
                  "x"=> 520,
                  "y"=> 1020
                ],
                "caller_id"=> "[[contact.channel.address]]",
                "record"=> true,
                "noun"=> "number",
                "to"=> "13203318157",
                "timeout"=> 20
              ]
            ],
            [
              "name"=> "wait_for_sales",
              "type"=> "say-play",
              "transitions"=> [
                [
                  "next"=> "connect_call_to_sales",
                  "event"=> "audioComplete"
                ]
              ],
              "properties"=> [
                "offset"=> [
                  "x"=> -290,
                  "y"=> 940
                ],
                "loop"=> 1,
                "say"=> "please wait while your call is connecting.thank you."
              ]
            ],
            [
              "name"=> "wait_for_supports",
              "type"=> "say-play",
              "transitions"=> [
                [
                  "next"=> "connect_to_support",
                  "event"=> "audioComplete"
                ]
              ],
              "properties"=> [
                "offset"=> [
                  "x"=> 600,
                  "y"=> 800
                ],
                "loop"=> 1,
                "say"=> "please wait while your call is connecting. thank you."
              ]
            ],
            [
              "name"=> "wrong_input",
              "type"=> "say-play",
              "transitions"=> [
                [
                  "next"=> "gather_1",
                  "event"=> "audioComplete"
                ]
              ],
              "properties"=> [
                "offset"=> [
                  "x"=> -240,
                  "y"=> 500
                ],
                "loop"=> 1,
                "say"=> "Sorry Invalid Input key."
              ]
            ]
          ],
          "initial_state"=> "Trigger",
          "flags"=> [
            "allow_concurrent_calls"=> true
          ]
        ]
        );
  }elseif($menucount == '3') {
    $flow = $twilio->studio->v2->flows
  ->create("$IVRNAmeva", // friendlyName
   "draft", // status
   [
    "description"=> "IVR",
    "states"=> [
      [
        "name"=> "Trigger",
        "type"=> "trigger",
        "transitions"=> [
          [
            "event"=> "incomingMessage"
          ],
          [
            "next"=> "Greeting",
            "event"=> "incomingCall"
          ],
          [
            "event"=> "incomingConversationMessage"
          ],
          [
            "event"=> "incomingRequest"
          ],
          [
            "event"=> "incomingParent"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> 250,
            "y"=> 50
          ]
        ]
      ],
      [
        "name"=> "connect_call_to_sales",
        "type"=> "connect-call-to",
        "transitions"=> [
          [
            "event"=> "callCompleted"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> -290,
            "y"=> 1210
          ],
          "caller_id"=> "[[contact.channel.address]]",
          "record"=> true,
          "noun"=> "number",
          "to"=> "$pressNumber[0]",
          "timeout"=> 20
        ]
      ],
      [
        "name"=> "Greeting",
        "type"=> "say-play",
        "transitions"=> [
          [
            "next"=> "gather_1",
            "event"=> "audioComplete"
          ]
        ],
        "properties"=> [
          "voice"=> "alice",
          "offset"=> [
            "x"=> 440,
            "y"=> 220
          ],
          "loop"=> 1,
          "say"=>"$welcomeText",
          "language"=> "en-US"
        ]
      ],
      [
        "name"=> "gather_1",
        "type"=> "gather-input-on-call",
        "transitions"=> [
          [
            "next"=> "press1",
            "event"=> "keypress"
          ],
          [
            "event"=> "speech"
          ],
          [
            "event"=> "timeout"
          ]
        ],
        "properties"=> [
          "voice"=> "alice",
          "number_of_digits"=> 1,
          "speech_timeout"=> "auto",
          "offset"=> [
            "x"=> 450,
            "y"=> 450
          ],
          "loop"=> 1,
          "finish_on_key"=> "",
          "say"=>"$menu_text",
          "language"=> "en-US",
          "stop_gather"=> true,
          "gather_language"=> "en",
          "profanity_filter"=> "true",
          "timeout"=> 3
        ]
      ],
      [
        "name"=> "press1",
        "type"=> "split-based-on",
        "transitions"=> [
          [
            "next"=> "wrong_input",
            "event"=> "noMatch"
          ],
          [
            "next"=> "wait_for_sales",
            "event"=> "match",
            "conditions"=> [
              [
                "friendly_name"=> "If value equal_to 1",
                "arguments"=> [
                  "[[widgets.gather_1.Digits]]"
                ],
                "type"=> "equal_to",
                "value"=> "$press[0]"
              ]
            ]
          ],
          [
            "next"=> "wait_for_supports",
            "event"=> "match",
            "conditions"=> [
              [
                "friendly_name"=> "If value equal_to 2",
                "arguments"=> [
                  "[[widgets.gather_1.Digits]]"
                ],
                "type"=> "equal_to",
                "value"=> "$press[1]"
              ]
            ]
          ],
          [
            "next"=> "response3",
            "event"=> "match",
            "conditions"=> [
              [
                "friendly_name"=> "If value equal_to 3",
                "arguments"=> [
                  "[[widgets.gather_1.Digits]]"
                ],
                "type"=> "equal_to",
                "value"=> "$press[2]"
              ]
            ]
          ]
        ],
        "properties"=> [
          "input"=> "[[widgets.gather_1.Digits]]",
          "offset"=> [
            "x"=> 80,
            "y"=> 730
          ]
        ]
      ],
      [
        "name"=> "connect_to_support",
        "type"=> "connect-call-to",
        "transitions"=> [
          [
            "event"=> "callCompleted"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> 80,
            "y"=> 1240
          ],
          "caller_id"=> "[[contact.channel.address]]",
          "record"=> true,
          "noun"=> "number",
          "to"=> "$pressNumber[1]",
          "timeout"=> 20
        ]
      ],
      [
        "name"=> "wait_for_sales",
        "type"=> "say-play",
        "transitions"=> [
          [
            "next"=> "connect_call_to_sales",
            "event"=> "audioComplete"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> -300,
            "y"=> 980
          ],
          "loop"=> 1,
          "say"=> "please wait while your call is connecting.thank you."
        ]
      ],
      [
        "name"=> "wait_for_supports",
        "type"=> "say-play",
        "transitions"=> [
          [
            "next"=> "connect_to_support",
            "event"=> "audioComplete"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> 60,
            "y"=> 1010
          ],
          "loop"=> 1,
          "say"=> "please wait while your call is connecting. thank you."
        ]
      ],
      [
        "name"=> "wrong_input",
        "type"=> "say-play",
        "transitions"=> [
          [
            "next"=> "gather_1",
            "event"=> "audioComplete"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> -240,
            "y"=> 500
          ],
          "loop"=> 1,
          "say"=> "Sorry Invalid Input key."
        ]
      ],
      [
        "name"=> "response3",
        "type"=> "say-play",
        "transitions"=> [
          [
            "next"=> "connect3",
            "event"=> "audioComplete"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> 410,
            "y"=> 1010
          ],
          "loop"=> 1,
          "say"=> "please wait while your call is connecting. thank you."
        ]
      ],
      [
        "name"=> "connect3",
        "type"=> "connect-call-to",
        "transitions"=> [
          [
            "event"=> "callCompleted"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> 430,
            "y"=> 1240
          ],
          "caller_id"=> "[[contact.channel.address]]",
          "record"=> true,
          "noun"=> "number",
          "to"=> "13203318157",
          "timeout"=> 20
        ]
      ]
    ],
    "initial_state"=> "Trigger",
    "flags"=> [
      "allow_concurrent_calls"=> true
    ]
  ]
  );
  }elseif($menucount == '4') {
    $flow = $twilio->studio->v2->flows
  ->create("$IVRNAmeva", // friendlyName
   "draft", // status
   [
    "description"=> "IVR",
    "states"=> [
      [
        "name"=> "Trigger",
        "type"=> "trigger",
        "transitions"=> [
          [
            "event"=> "incomingMessage"
          ],
          [
            "next"=> "Greeting",
            "event"=> "incomingCall"
          ],
          [
            "event"=> "incomingConversationMessage"
          ],
          [
            "event"=> "incomingRequest"
          ],
          [
            "event"=> "incomingParent"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> 250,
            "y"=> 50
          ]
        ]
      ],
      [
        "name"=> "connect_call_to_sales",
        "type"=> "connect-call-to",
        "transitions"=> [
          [
            "event"=> "callCompleted"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> -290,
            "y"=> 1210
          ],
          "caller_id"=> "[[contact.channel.address]]",
          "record"=> true,
          "noun"=> "number",
          "to"=> "13203318157",
          "timeout"=> 20
        ]
      ],
      [
        "name"=> "Greeting",
        "type"=> "say-play",
        "transitions"=> [
          [
            "next"=> "gather_1",
            "event"=> "audioComplete"
          ]
        ],
        "properties"=> [
          "voice"=> "alice",
          "offset"=> [
            "x"=> 440,
            "y"=> 220
          ],
          "loop"=> 1,
          "say"=>"$welcomeText",
          "language"=> "en-US"
        ]
      ],
      [
        "name"=> "gather_1",
        "type"=> "gather-input-on-call",
        "transitions"=> [
          [
            "next"=> "press1",
            "event"=> "keypress"
          ],
          [
            "event"=> "speech"
          ],
          [
            "event"=> "timeout"
          ]
        ],
        "properties"=> [
          "voice"=> "alice",
          "number_of_digits"=> 1,
          "speech_timeout"=> "auto",
          "offset"=> [
            "x"=> 450,
            "y"=> 450
          ],
          "loop"=> 1,
          "finish_on_key"=> "",
          "say"=>"$menu_text",
          "language"=> "en-US",
          "stop_gather"=> true,
          "gather_language"=> "en",
          "profanity_filter"=> "true",
          "timeout"=> 3
        ]
      ],
      [
        "name"=> "press1",
        "type"=> "split-based-on",
        "transitions"=> [
          [
            "next"=> "wrong_input",
            "event"=> "noMatch"
          ],
          [
            "next"=> "wait_for_sales",
            "event"=> "match",
            "conditions"=> [
              [
                "friendly_name"=> "If value equal_to 1",
                "arguments"=> [
                  "[[widgets.gather_1.Digits]]"
                ],
                "type"=> "equal_to",
                "value"=> "$press[0]"
              ]
            ]
          ],
          [
            "next"=> "wait_for_supports",
            "event"=> "match",
            "conditions"=> [
              [
                "friendly_name"=> "If value equal_to 2",
                "arguments"=> [
                  "[[widgets.gather_1.Digits]]"
                ],
                "type"=> "equal_to",
                "value"=> "$press[1]"
              ]
            ]
          ],
          [
            "next"=> "response3",
            "event"=> "match",
            "conditions"=> [
              [
                "friendly_name"=> "If value equal_to 3",
                "arguments"=> [
                  "[[widgets.gather_1.Digits]]"
                ],
                "type"=> "equal_to",
                "value"=> "$press[2]"
              ]
            ]
          ],
          [
            "next"=> "response4",
            "event"=> "match",
            "conditions"=> [
              [
                "friendly_name"=> "If value equal_to 4",
                "arguments"=> [
                  "[[widgets.gather_1.Digits]]"
                ],
                "type"=> "equal_to",
                "value"=> "$press[3]"
              ]
            ]
          ]
        ],
        "properties"=> [
          "input"=> "[[widgets.gather_1.Digits]]",
          "offset"=> [
            "x"=> 80,
            "y"=> 730
          ]
        ]
      ],
      [
        "name"=> "connect_to_support",
        "type"=> "connect-call-to",
        "transitions"=> [
          [
            "event"=> "callCompleted"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> 80,
            "y"=> 1240
          ],
          "caller_id"=> "[[contact.channel.address]]",
          "record"=> true,
          "noun"=> "number",
          "to"=> "$pressNumber[1]",
          "timeout"=> 20
        ]
      ],
      [
        "name"=> "wait_for_sales",
        "type"=> "say-play",
        "transitions"=> [
          [
            "next"=> "connect_call_to_sales",
            "event"=> "audioComplete"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> -300,
            "y"=> 980
          ],
          "loop"=> 1,
          "say"=> "please wait while your call is connecting.thank you."
        ]
      ],
      [
        "name"=> "wait_for_supports",
        "type"=> "say-play",
        "transitions"=> [
          [
            "next"=> "connect_to_support",
            "event"=> "audioComplete"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> 60,
            "y"=> 1010
          ],
          "loop"=> 1,
          "say"=> "please wait while your call is connecting. thank you."
        ]
      ],
      [
        "name"=> "wrong_input",
        "type"=> "say-play",
        "transitions"=> [
          [
            "next"=> "gather_1",
            "event"=> "audioComplete"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> -240,
            "y"=> 500
          ],
          "loop"=> 1,
          "say"=> "Sorry Invalid Input key."
        ]
      ],
      [
        "name"=> "response3",
        "type"=> "say-play",
        "transitions"=> [
          [
            "next"=> "connect3",
            "event"=> "audioComplete"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> 410,
            "y"=> 1010
          ],
          "loop"=> 1,
          "say"=> "please wait while your call is connecting. thank you."
        ]
      ],
      [
        "name"=> "connect3",
        "type"=> "connect-call-to",
        "transitions"=> [
          [
            "event"=> "callCompleted"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> 430,
            "y"=> 1240
          ],
          "caller_id"=> "[[contact.channel.address]]",
          "record"=> true,
          "noun"=> "number",
          "to"=> "13203318157",
          "timeout"=> 20
        ]
      ],
      [
        "name"=> "response4",
        "type"=> "say-play",
        "transitions"=> [
          [
            "next"=> "connect4",
            "event"=> "audioComplete"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> 760,
            "y"=> 1010
          ],
          "loop"=> 1,
          "say"=> "please wait while your call is connecting. thank you."
        ]
      ],
      [
        "name"=> "connect4",
        "type"=> "connect-call-to",
        "transitions"=> [
          [
            "event"=> "callCompleted"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> 780,
            "y"=> 1240
          ],
          "caller_id"=> "[[contact.channel.address]]",
          "record"=> true,
          "noun"=> "number",
          "to"=> "13203318157",
          "timeout"=> 20
        ]
      ]
    ],
    "initial_state"=> "Trigger",
    "flags"=> [
      "allow_concurrent_calls"=> true
    ]
  ]
  );
  }elseif ($menucount == '5') {
    $flow = $twilio->studio->v2->flows
    ->create("$IVRNAmeva", // friendlyName
     "draft", // status
     [
      "description"=> "IVR",
      "states"=> [
        [
          "name"=> "Trigger",
          "type"=> "trigger",
          "transitions"=> [
            [
              "event"=> "incomingMessage"
            ],
            [
              "next"=> "Greeting",
              "event"=> "incomingCall"
            ],
            [
              "event"=> "incomingConversationMessage"
            ],
            [
              "event"=> "incomingRequest"
            ],
            [
              "event"=> "incomingParent"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 250,
              "y"=> 50
            ]
          ]
        ],
        [
          "name"=> "connect_call_to_sales",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> -290,
              "y"=> 1210
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "13203318157",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "Greeting",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "gather_1",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "voice"=> "alice",
            "offset"=> [
              "x"=> 440,
              "y"=> 220
            ],
            "loop"=> 1,
            "say"=>"$welcomeText",
            "language"=> "en-US"
          ]
        ],
        [
          "name"=> "gather_1",
          "type"=> "gather-input-on-call",
          "transitions"=> [
            [
              "next"=> "press1",
              "event"=> "keypress"
            ],
            [
              "event"=> "speech"
            ],
            [
              "event"=> "timeout"
            ]
          ],
          "properties"=> [
            "voice"=> "alice",
            "number_of_digits"=> 1,
            "speech_timeout"=> "auto",
            "offset"=> [
              "x"=> 450,
              "y"=> 450
            ],
            "loop"=> 1,
            "finish_on_key"=> "",
            "say"=>"$menu_text",
            "language"=> "en-US",
            "stop_gather"=> true,
            "gather_language"=> "en",
            "profanity_filter"=> "true",
            "timeout"=> 3
          ]
        ],
        [
          "name"=> "press1",
          "type"=> "split-based-on",
          "transitions"=> [
            [
              "next"=> "wrong_input",
              "event"=> "noMatch"
            ],
            [
              "next"=> "wait_for_sales",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 1",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[0]"
                ]
              ]
            ],
            [
              "next"=> "wait_for_supports",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 2",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[1]"
                ]
              ]
            ],
            [
              "next"=> "response3",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 3",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[2]"
                ]
              ]
            ],
            [
              "next"=> "response4",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 4",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[3]"
                ]
              ]
            ],
            [
              "next"=> "response5",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 5",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[4]"
                ]
              ]
            ]
          ],
          "properties"=> [
            "input"=> "[[widgets.gather_1.Digits]]",
            "offset"=> [
              "x"=> 80,
              "y"=> 730
            ]
          ]
        ],
        [
          "name"=> "connect_to_support",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 80,
              "y"=> 1240
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[1]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "wait_for_sales",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect_call_to_sales",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> -300,
              "y"=> 980
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting.thank you."
          ]
        ],
        [
          "name"=> "wait_for_supports",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect_to_support",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 60,
              "y"=> 1010
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "wrong_input",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "gather_1",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> -240,
              "y"=> 500
            ],
            "loop"=> 1,
            "say"=> "Sorry Invalid Input key."
          ]
        ],
        [
          "name"=> "response3",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect3",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 410,
              "y"=> 1010
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "connect3",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 430,
              "y"=> 1240
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[2]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "response4",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect4",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 760,
              "y"=> 1010
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "connect4",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 780,
              "y"=> 1240
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[3]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "response5",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect5",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1110,
              "y"=> 1010
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "connect5",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1140,
              "y"=> 1280
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "13203318157",
            "timeout"=> 20
          ]
        ]
      ],
      "initial_state"=> "Trigger",
      "flags"=> [
        "allow_concurrent_calls"=> true
      ]
    ]
  );
  }elseif ($menucount == '6') {
    $flow = $twilio->studio->v2->flows
    ->create("$IVRNAmeva", // friendlyName
     "draft", // status
     [
      "description"=> "IVR",
      "states"=> [
        [
          "name"=> "Trigger",
          "type"=> "trigger",
          "transitions"=> [
            [
              "event"=> "incomingMessage"
            ],
            [
              "next"=> "Greeting",
              "event"=> "incomingCall"
            ],
            [
              "event"=> "incomingConversationMessage"
            ],
            [
              "event"=> "incomingRequest"
            ],
            [
              "event"=> "incomingParent"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 250,
              "y"=> 50
            ]
          ]
        ],
        [
          "name"=> "connect_call_to_sales",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> -290,
              "y"=> 1210
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "13203318157",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "Greeting",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "gather_1",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "voice"=> "alice",
            "offset"=> [
              "x"=> 440,
              "y"=> 220
            ],
            "loop"=> 1,
            "say"=>"$welcomeText",
            "language"=> "en-US"
          ]
        ],
        [
          "name"=> "gather_1",
          "type"=> "gather-input-on-call",
          "transitions"=> [
            [
              "next"=> "press1",
              "event"=> "keypress"
            ],
            [
              "event"=> "speech"
            ],
            [
              "event"=> "timeout"
            ]
          ],
          "properties"=> [
            "voice"=> "alice",
            "number_of_digits"=> 1,
            "speech_timeout"=> "auto",
            "offset"=> [
              "x"=> 450,
              "y"=> 450
            ],
            "loop"=> 1,
            "finish_on_key"=> "",
            "say"=>"$menu_text",
            "language"=> "en-US",
            "stop_gather"=> true,
            "gather_language"=> "en",
            "profanity_filter"=> "true",
            "timeout"=> 3
          ]
        ],
        [
          "name"=> "press1",
          "type"=> "split-based-on",
          "transitions"=> [
            [
              "next"=> "wrong_input",
              "event"=> "noMatch"
            ],
            [
              "next"=> "wait_for_sales",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 1",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[0]"
                ]
              ]
            ],
            [
              "next"=> "wait_for_supports",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 2",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[1]"
                ]
              ]
            ],
            [
              "next"=> "response3",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 3",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[2]"
                ]
              ]
            ],
            [
              "next"=> "response4",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 4",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[3]"
                ]
              ]
            ],
            [
              "next"=> "response5",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 5",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[4]"
                ]
              ]
            ],
            [
              "next"=> "response6",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 6",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[5]"
                ]
              ]
            ]
          ],
          "properties"=> [
            "input"=> "[[widgets.gather_1.Digits]]",
            "offset"=> [
              "x"=> 80,
              "y"=> 730
            ]
          ]
        ],
        [
          "name"=> "connect_to_support",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 80,
              "y"=> 1240
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[1]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "wait_for_sales",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect_call_to_sales",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> -300,
              "y"=> 980
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting.thank you."
          ]
        ],
        [
          "name"=> "wait_for_supports",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect_to_support",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 60,
              "y"=> 1010
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "wrong_input",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "gather_1",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> -240,
              "y"=> 500
            ],
            "loop"=> 1,
            "say"=> "Sorry Invalid Input key."
          ]
        ],
        [
          "name"=> "response3",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect3",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 410,
              "y"=> 1010
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "connect3",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 430,
              "y"=> 1240
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[2]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "response4",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect4",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 760,
              "y"=> 1010
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "connect4",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 780,
              "y"=> 1240
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[3]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "response5",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect5",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1110,
              "y"=> 1010
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "connect5",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1140,
              "y"=> 1280
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[4]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "response6",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect6",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1490,
              "y"=> 1000
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "connect6",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1490,
              "y"=> 1280
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "13203318157",
            "timeout"=> 20
          ]
        ]
      ],
      "initial_state"=> "Trigger",
      "flags"=> [
        "allow_concurrent_calls"=> true
      ]
    ]
  );
  }elseif ($menucount == '7') {
    $flow = $twilio->studio->v2->flows
  ->create("$IVRNAmeva", // friendlyName
   "draft", // status
   [
    "description"=> "IVR",
    "states"=> [
      [
        "name"=> "Trigger",
        "type"=> "trigger",
        "transitions"=> [
          [
            "event"=> "incomingMessage"
          ],
          [
            "next"=> "Greeting",
            "event"=> "incomingCall"
          ],
          [
            "event"=> "incomingConversationMessage"
          ],
          [
            "event"=> "incomingRequest"
          ],
          [
            "event"=> "incomingParent"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> 250,
            "y"=> 50
          ]
        ]
      ],
      [
        "name"=> "connect_call_to_sales",
        "type"=> "connect-call-to",
        "transitions"=> [
          [
            "event"=> "callCompleted"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> -290,
            "y"=> 1210
          ],
          "caller_id"=> "[[contact.channel.address]]",
          "record"=> true,
          "noun"=> "number",
          "to"=> "13203318157",
          "timeout"=> 20
        ]
      ],
      [
        "name"=> "Greeting",
        "type"=> "say-play",
        "transitions"=> [
          [
            "next"=> "gather_1",
            "event"=> "audioComplete"
          ]
        ],
        "properties"=> [
          "voice"=> "alice",
          "offset"=> [
            "x"=> 440,
            "y"=> 220
          ],
          "loop"=> 1,
          "say"=>"$welcomeText",
          "language"=> "en-US"
        ]
      ],
      [
        "name"=> "gather_1",
        "type"=> "gather-input-on-call",
        "transitions"=> [
          [
            "next"=> "press1",
            "event"=> "keypress"
          ],
          [
            "event"=> "speech"
          ],
          [
            "event"=> "timeout"
          ]
        ],
        "properties"=> [
          "voice"=> "alice",
          "number_of_digits"=> 1,
          "speech_timeout"=> "auto",
          "offset"=> [
            "x"=> 450,
            "y"=> 450
          ],
          "loop"=> 1,
          "finish_on_key"=> "",
          "say"=>"$menu_text",
          "language"=> "en-US",
          "stop_gather"=> true,
          "gather_language"=> "en",
          "profanity_filter"=> "true",
          "timeout"=> 3
        ]
      ],
      [
        "name"=> "press1",
        "type"=> "split-based-on",
        "transitions"=> [
          [
            "next"=> "wrong_input",
            "event"=> "noMatch"
          ],
          [
            "next"=> "wait_for_sales",
            "event"=> "match",
            "conditions"=> [
              [
                "friendly_name"=> "If value equal_to 1",
                "arguments"=> [
                  "[[widgets.gather_1.Digits]]"
                ],
                "type"=> "equal_to",
                "value"=> "$press[0]"
              ]
            ]
          ],
          [
            "next"=> "wait_for_supports",
            "event"=> "match",
            "conditions"=> [
              [
                "friendly_name"=> "If value equal_to 2",
                "arguments"=> [
                  "[[widgets.gather_1.Digits]]"
                ],
                "type"=> "equal_to",
                "value"=> "$press[1]"
              ]
            ]
          ],
          [
            "next"=> "response3",
            "event"=> "match",
            "conditions"=> [
              [
                "friendly_name"=> "If value equal_to 3",
                "arguments"=> [
                  "[[widgets.gather_1.Digits]]"
                ],
                "type"=> "equal_to",
                "value"=> "$press[2]"
              ]
            ]
          ],
          [
            "next"=> "response4",
            "event"=> "match",
            "conditions"=> [
              [
                "friendly_name"=> "If value equal_to 4",
                "arguments"=> [
                  "[[widgets.gather_1.Digits]]"
                ],
                "type"=> "equal_to",
                "value"=> "$press[3]"
              ]
            ]
          ],
          [
            "next"=> "response5",
            "event"=> "match",
            "conditions"=> [
              [
                "friendly_name"=> "If value equal_to 5",
                "arguments"=> [
                  "[[widgets.gather_1.Digits]]"
                ],
                "type"=> "equal_to",
                "value"=> "$press[4]"
              ]
            ]
          ],
          [
            "next"=> "response6",
            "event"=> "match",
            "conditions"=> [
              [
                "friendly_name"=> "If value equal_to 6",
                "arguments"=> [
                  "[[widgets.gather_1.Digits]]"
                ],
                "type"=> "equal_to",
                "value"=> "$press[5]"
              ]
            ]
          ],
          [
            "next"=> "response7",
            "event"=> "match",
            "conditions"=> [
              [
                "friendly_name"=> "If value equal_to 7",
                "arguments"=> [
                  "[[widgets.gather_1.Digits]]"
                ],
                "type"=> "equal_to",
                "value"=> "$press[6]"
              ]
            ]
          ]
        ],
        "properties"=> [
          "input"=> "[[widgets.gather_1.Digits]]",
          "offset"=> [
            "x"=> 80,
            "y"=> 730
          ]
        ]
      ],
      [
        "name"=> "connect_to_support",
        "type"=> "connect-call-to",
        "transitions"=> [
          [
            "event"=> "callCompleted"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> 80,
            "y"=> 1240
          ],
          "caller_id"=> "[[contact.channel.address]]",
          "record"=> true,
          "noun"=> "number",
          "to"=> "$pressNumber[1]",
          "timeout"=> 20
        ]
      ],
      [
        "name"=> "wait_for_sales",
        "type"=> "say-play",
        "transitions"=> [
          [
            "next"=> "connect_call_to_sales",
            "event"=> "audioComplete"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> -300,
            "y"=> 980
          ],
          "loop"=> 1,
          "say"=> "please wait while your call is connecting.thank you."
        ]
      ],
      [
        "name"=> "wait_for_supports",
        "type"=> "say-play",
        "transitions"=> [
          [
            "next"=> "connect_to_support",
            "event"=> "audioComplete"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> 60,
            "y"=> 1010
          ],
          "loop"=> 1,
          "say"=> "please wait while your call is connecting. thank you."
        ]
      ],
      [
        "name"=> "wrong_input",
        "type"=> "say-play",
        "transitions"=> [
          [
            "next"=> "gather_1",
            "event"=> "audioComplete"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> -240,
            "y"=> 500
          ],
          "loop"=> 1,
          "say"=> "Sorry Invalid Input key."
        ]
      ],
      [
        "name"=> "response3",
        "type"=> "say-play",
        "transitions"=> [
          [
            "next"=> "connect3",
            "event"=> "audioComplete"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> 410,
            "y"=> 1010
          ],
          "loop"=> 1,
          "say"=> "please wait while your call is connecting. thank you."
        ]
      ],
      [
        "name"=> "connect3",
        "type"=> "connect-call-to",
        "transitions"=> [
          [
            "event"=> "callCompleted"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> 430,
            "y"=> 1240
          ],
          "caller_id"=> "[[contact.channel.address]]",
          "record"=> true,
          "noun"=> "number",
          "to"=> "13203318157",
          "timeout"=> 20
        ]
      ],
      [
        "name"=> "response4",
        "type"=> "say-play",
        "transitions"=> [
          [
            "next"=> "connect4",
            "event"=> "audioComplete"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> 760,
            "y"=> 1010
          ],
          "loop"=> 1,
          "say"=> "please wait while your call is connecting. thank you."
        ]
      ],
      [
        "name"=> "connect4",
        "type"=> "connect-call-to",
        "transitions"=> [
          [
            "event"=> "callCompleted"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> 780,
            "y"=> 1240
          ],
          "caller_id"=> "[[contact.channel.address]]",
          "record"=> true,
          "noun"=> "number",
          "to"=> "13203318157",
          "timeout"=> 20
        ]
      ],
      [
        "name"=> "response5",
        "type"=> "say-play",
        "transitions"=> [
          [
            "next"=> "connect5",
            "event"=> "audioComplete"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> 1110,
            "y"=> 1010
          ],
          "loop"=> 1,
          "say"=> "please wait while your call is connecting. thank you."
        ]
      ],
      [
        "name"=> "connect5",
        "type"=> "connect-call-to",
        "transitions"=> [
          [
            "event"=> "callCompleted"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> 1140,
            "y"=> 1280
          ],
          "caller_id"=> "[[contact.channel.address]]",
          "record"=> true,
          "noun"=> "number",
          "to"=> "13203318157",
          "timeout"=> 20
        ]
      ],
      [
        "name"=> "response6",
        "type"=> "say-play",
        "transitions"=> [
          [
            "next"=> "connect6",
            "event"=> "audioComplete"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> 1490,
            "y"=> 1000
          ],
          "loop"=> 1,
          "say"=> "please wait while your call is connecting. thank you."
        ]
      ],
      [
        "name"=> "connect6",
        "type"=> "connect-call-to",
        "transitions"=> [
          [
            "event"=> "callCompleted"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> 1490,
            "y"=> 1280
          ],
          "caller_id"=> "[[contact.channel.address]]",
          "record"=> true,
          "noun"=> "number",
          "to"=> "13203318157",
          "timeout"=> 20
        ]
      ],
      [
        "name"=> "response7",
        "type"=> "say-play",
        "transitions"=> [
          [
            "next"=> "connect7",
            "event"=> "audioComplete"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> 1830,
            "y"=> 980
          ],
          "loop"=> 1,
          "say"=> "please wait while your call is connecting. thank you."
        ]
      ],
      [
        "name"=> "connect7",
        "type"=> "connect-call-to",
        "transitions"=> [
          [
            "event"=> "callCompleted"
          ]
        ],
        "properties"=> [
          "offset"=> [
            "x"=> 1840,
            "y"=> 1280
          ],
          "caller_id"=> "[[contact.channel.address]]",
          "record"=> true,
          "noun"=> "number",
          "to"=> "13203318157",
          "timeout"=> 20
        ]
      ]
    ],
    "initial_state"=> "Trigger",
    "flags"=> [
      "allow_concurrent_calls"=> true
    ]
  ]
  );
    # code...
  }elseif ($menucount == '8') {
    $flow = $twilio->studio->v2->flows
    ->create("$IVRNAmeva", // friendlyName
     "draft", // status
     [
      "description"=> "IVR",
      "states"=> [
        [
          "name"=> "Trigger",
          "type"=> "trigger",
          "transitions"=> [
            [
              "event"=> "incomingMessage"
            ],
            [
              "next"=> "Greeting",
              "event"=> "incomingCall"
            ],
            [
              "event"=> "incomingConversationMessage"
            ],
            [
              "event"=> "incomingRequest"
            ],
            [
              "event"=> "incomingParent"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 250,
              "y"=> 50
            ]
          ]
        ],
        [
          "name"=> "connect_call_to_sales",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> -290,
              "y"=> 1210
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "13203318157",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "Greeting",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "gather_1",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "voice"=> "alice",
            "offset"=> [
              "x"=> 440,
              "y"=> 220
            ],
            "loop"=> 1,
            "say"=>"$welcomeText",
            "language"=> "en-US"
          ]
        ],
        [
          "name"=> "gather_1",
          "type"=> "gather-input-on-call",
          "transitions"=> [
            [
              "next"=> "press1",
              "event"=> "keypress"
            ],
            [
              "event"=> "speech"
            ],
            [
              "event"=> "timeout"
            ]
          ],
          "properties"=> [
            "voice"=> "alice",
            "number_of_digits"=> 1,
            "speech_timeout"=> "auto",
            "offset"=> [
              "x"=> 500,
              "y"=> 520
            ],
            "loop"=> 1,
            "finish_on_key"=> "",
            "say"=>"$menu_text",
            "language"=> "en-US",
            "stop_gather"=> true,
            "gather_language"=> "en",
            "profanity_filter"=> "true",
            "timeout"=> 3
          ]
        ],
        [
          "name"=> "press1",
          "type"=> "split-based-on",
          "transitions"=> [
            [
              "next"=> "wrong_input",
              "event"=> "noMatch"
            ],
            [
              "next"=> "wait_for_sales",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 1",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[0]"
                ]
              ]
            ],
            [
              "next"=> "wait_for_supports",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 2",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[1]"
                ]
              ]
            ],
            [
              "next"=> "response3",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 3",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[2]"
                ]
              ]
            ],
            [
              "next"=> "response4",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 4",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[3]"
                ]
              ]
            ],
            [
              "next"=> "response5",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 5",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[4]"
                ]
              ]
            ],
            [
              "next"=> "response6",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 6",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[5]"
                ]
              ]
            ],
            [
              "next"=> "response7",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 7",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[6]"
                ]
              ]
            ],
            [
              "next"=> "response8",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 8",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[7]"
                ]
              ]
            ]
          ],
          "properties"=> [
            "input"=> "[[widgets.gather_1.Digits]]",
            "offset"=> [
              "x"=> 130,
              "y"=> 750
            ]
          ]
        ],
        [
          "name"=> "connect_to_support",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 80,
              "y"=> 1240
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[1]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "wait_for_sales",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect_call_to_sales",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> -300,
              "y"=> 980
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting.thank you."
          ]
        ],
        [
          "name"=> "wait_for_supports",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect_to_support",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 60,
              "y"=> 1010
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "wrong_input",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "gather_1",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> -240,
              "y"=> 500
            ],
            "loop"=> 1,
            "say"=> "Sorry Invalid Input key."
          ]
        ],
        [
          "name"=> "response3",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect3",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 410,
              "y"=> 1010
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "connect3",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 430,
              "y"=> 1240
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[2]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "response4",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect4",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 760,
              "y"=> 1010
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "connect4",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 780,
              "y"=> 1240
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[3]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "response5",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect5",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1110,
              "y"=> 1010
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "connect5",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1140,
              "y"=> 1280
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[4]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "response6",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect6",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1490,
              "y"=> 1000
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "connect6",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1490,
              "y"=> 1280
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[5]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "response7",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect7",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1830,
              "y"=> 980
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "connect7",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1840,
              "y"=> 1280
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[6]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "response8",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect8",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 2170,
              "y"=> 960
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "connect8",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 2190,
              "y"=> 1280
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "13203318157",
            "timeout"=> 20
          ]
        ]
      ],
      "initial_state"=> "Trigger",
      "flags"=> [
        "allow_concurrent_calls"=> true
      ]
    ]
  );
  }elseif ($menucount == '9') {
    $flow = $twilio->studio->v2->flows
    ->create("$IVRNAmeva", // friendlyName
     "draft", // status
     [
      "description"=> "IVR",
      "states"=> [
        [
          "name"=> "Trigger",
          "type"=> "trigger",
          "transitions"=> [
            [
              "event"=> "incomingMessage"
            ],
            [
              "next"=> "Greeting",
              "event"=> "incomingCall"
            ],
            [
              "event"=> "incomingConversationMessage"
            ],
            [
              "event"=> "incomingRequest"
            ],
            [
              "event"=> "incomingParent"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 250,
              "y"=> 50
            ]
          ]
        ],
        [
          "name"=> "connect_call_to_sales",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> -290,
              "y"=> 1210
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "13203318157",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "Greeting",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "gather_1",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "voice"=> "alice",
            "offset"=> [
              "x"=> 440,
              "y"=> 220
            ],
            "loop"=> 1,
            "say"=>"$welcomeText",
            "language"=> "en-US"
          ]
        ],
        [
          "name"=> "gather_1",
          "type"=> "gather-input-on-call",
          "transitions"=> [
            [
              "next"=> "press1",
              "event"=> "keypress"
            ],
            [
              "event"=> "speech"
            ],
            [
              "event"=> "timeout"
            ]
          ],
          "properties"=> [
            "voice"=> "alice",
            "number_of_digits"=> 1,
            "speech_timeout"=> "auto",
            "offset"=> [
              "x"=> 500,
              "y"=> 520
            ],
            "loop"=> 1,
            "finish_on_key"=> "",
            "say"=>"$menu_text",
            "language"=> "en-US",
            "stop_gather"=> true,
            "gather_language"=> "en",
            "profanity_filter"=> "true",
            "timeout"=> 3
          ]
        ],
        [
          "name"=> "press1",
          "type"=> "split-based-on",
          "transitions"=> [
            [
              "next"=> "wrong_input",
              "event"=> "noMatch"
            ],
            [
              "next"=> "wait_for_sales",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 1",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[0]"
                ]
              ]
            ],
            [
              "next"=> "wait_for_supports",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 2",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[1]"
                ]
              ]
            ],
            [
              "next"=> "response3",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 3",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[2]"
                ]
              ]
            ],
            [
              "next"=> "response4",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 4",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[3]"
                ]
              ]
            ],
            [
              "next"=> "response5",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 5",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[4]"
                ]
              ]
            ],
            [
              "next"=> "response6",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 6",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[5]"
                ]
              ]
            ],
            [
              "next"=> "response7",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 7",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[6]"
                ]
              ]
            ],
            [
              "next"=> "response8",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 8",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[7]"
                ]
              ]
            ],
            [
              "next"=> "response9",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 9",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[8]"
                ]
              ]
            ]
          ],
          "properties"=> [
            "input"=> "[[widgets.gather_1.Digits]]",
            "offset"=> [
              "x"=> 130,
              "y"=> 750
            ]
          ]
        ],
        [
          "name"=> "connect_to_support",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 80,
              "y"=> 1240
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[1]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "wait_for_sales",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect_call_to_sales",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> -300,
              "y"=> 980
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting.thank you."
          ]
        ],
        [
          "name"=> "wait_for_supports",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect_to_support",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 60,
              "y"=> 1010
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "wrong_input",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "gather_1",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> -240,
              "y"=> 500
            ],
            "loop"=> 1,
            "say"=> "Sorry Invalid Input key."
          ]
        ],
        [
          "name"=> "response3",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect3",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 410,
              "y"=> 1010
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "connect3",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 430,
              "y"=> 1240
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[2]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "response4",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect4",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 760,
              "y"=> 1010
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "connect4",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 780,
              "y"=> 1240
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[3]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "response5",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect5",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1110,
              "y"=> 1010
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "connect5",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1140,
              "y"=> 1280
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[4]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "response6",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect6",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1490,
              "y"=> 1000
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "connect6",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1490,
              "y"=> 1280
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[5]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "response7",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect7",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1830,
              "y"=> 980
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "connect7",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1840,
              "y"=> 1280
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[6]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "response8",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect8",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 2170,
              "y"=> 960
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "connect8",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 2190,
              "y"=> 1280
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[7]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "response9",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect9",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1460,
              "y"=> 520
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "connect9",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1740,
              "y"=> 740
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "13203318157",
            "timeout"=> 20
          ]
        ]
      ],
      "initial_state"=> "Trigger",
      "flags"=> [
        "allow_concurrent_calls"=> true
      ]
    ]
  );
  }else{
    $flow = $twilio->studio->v2->flows
    ->create("$IVRNAmeva", // friendlyName
     "draft", // status
     [
      "description"=> "IVR",
      "states"=> [
        [
          "name"=> "Trigger",
          "type"=> "trigger",
          "transitions"=> [
            [
              "event"=> "incomingMessage"
            ],
            [
              "next"=> "Greeting",
              "event"=> "incomingCall"
            ],
            [
              "event"=> "incomingConversationMessage"
            ],
            [
              "event"=> "incomingRequest"
            ],
            [
              "event"=> "incomingParent"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 250,
              "y"=> 50
            ]
          ]
        ],
        [
          "name"=> "connect_call_to_sales",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> -290,
              "y"=> 1210
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "13203318157",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "Greeting",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "gather_1",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "voice"=> "alice",
            "offset"=> [
              "x"=> 440,
              "y"=> 220
            ],
            "loop"=> 1,
            "say"=>"$welcomeText",
            "language"=> "en-US"
          ]
        ],
        [
          "name"=> "gather_1",
          "type"=> "gather-input-on-call",
          "transitions"=> [
            [
              "next"=> "press1",
              "event"=> "keypress"
            ],
            [
              "event"=> "speech"
            ],
            [
              "event"=> "timeout"
            ]
          ],
          "properties"=> [
            "voice"=> "alice",
            "number_of_digits"=> 1,
            "speech_timeout"=> "auto",
            "offset"=> [
              "x"=> 500,
              "y"=> 520
            ],
            "loop"=> 1,
            "finish_on_key"=> "",
            "say"=>"$menu_text",
            "language"=> "en-US",
            "stop_gather"=> true,
            "gather_language"=> "en",
            "profanity_filter"=> "true",
            "timeout"=> 3
          ]
        ],
        [
          "name"=> "press1",
          "type"=> "split-based-on",
          "transitions"=> [
            [
              "next"=> "wrong_input",
              "event"=> "noMatch"
            ],
            [
              "next"=> "wait_for_sales",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 1",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[0]"
                ]
              ]
            ],
            [
              "next"=> "wait_for_supports",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 2",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[1]"
                ]
              ]
            ],
            [
              "next"=> "response3",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 3",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[2]"
                ]
              ]
            ],
            [
              "next"=> "response4",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 4",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[3]"
                ]
              ]
            ],
            [
              "next"=> "response5",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 5",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[4]"
                ]
              ]
            ],
            [
              "next"=> "response6",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 6",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[5]"
                ]
              ]
            ],
            [
              "next"=> "response7",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 7",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[6]"
                ]
              ]
            ],
            [
              "next"=> "response8",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 8",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[7]"
                ]
              ]
            ],
            [
              "next"=> "response9",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 9",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[8]"
                ]
              ]
            ],
            [
              "next"=> "response10",
              "event"=> "match",
              "conditions"=> [
                [
                  "friendly_name"=> "If value equal_to 10",
                  "arguments"=> [
                    "[[widgets.gather_1.Digits]]"
                  ],
                  "type"=> "equal_to",
                  "value"=> "$press[9]"
                ]
              ]
            ]
          ],
          "properties"=> [
            "input"=> "[[widgets.gather_1.Digits]]",
            "offset"=> [
              "x"=> 130,
              "y"=> 750
            ]
          ]
        ],
        [
          "name"=> "connect_to_support",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 80,
              "y"=> 1240
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[1]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "wait_for_sales",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect_call_to_sales",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> -300,
              "y"=> 980
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting.thank you."
          ]
        ],
        [
          "name"=> "wait_for_supports",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect_to_support",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 60,
              "y"=> 1010
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "wrong_input",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "gather_1",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> -240,
              "y"=> 500
            ],
            "loop"=> 1,
            "say"=> "Sorry Invalid Input key."
          ]
        ],
        [
          "name"=> "response3",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect3",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 410,
              "y"=> 1010
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "connect3",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 430,
              "y"=> 1240
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[2]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "response4",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect4",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 760,
              "y"=> 1010
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "connect4",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 780,
              "y"=> 1240
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[3]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "response5",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect5",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1110,
              "y"=> 1010
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "connect5",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1140,
              "y"=> 1280
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[4]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "response6",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect6",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1490,
              "y"=> 1000
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "connect6",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1490,
              "y"=> 1280
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[5]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "response7",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect7",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1830,
              "y"=> 980
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "connect7",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1840,
              "y"=> 1280
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[6]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "response8",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect8",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 2170,
              "y"=> 960
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "connect8",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 2190,
              "y"=> 1280
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[7]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "response9",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "connect9",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1580,
              "y"=> 560
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "connect9",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1590,
              "y"=> 720
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[8]",
            "timeout"=> 20
          ]
        ],
        [
          "name"=> "response10",
          "type"=> "say-play",
          "transitions"=> [
            [
              "next"=> "Copy_of_connect9",
              "event"=> "audioComplete"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 1930,
              "y"=> 560
            ],
            "loop"=> 1,
            "say"=> "please wait while your call is connecting. thank you."
          ]
        ],
        [
          "name"=> "Copy_of_connect9",
          "type"=> "connect-call-to",
          "transitions"=> [
            [
              "event"=> "callCompleted"
            ]
          ],
          "properties"=> [
            "offset"=> [
              "x"=> 2040,
              "y"=> 740
            ],
            "caller_id"=> "[[contact.channel.address]]",
            "record"=> true,
            "noun"=> "number",
            "to"=> "$pressNumber[9]",
            "timeout"=> 20
          ]
        ]
      ],
      "initial_state"=> "Trigger",
      "flags"=> [
        "allow_concurrent_calls"=> true
      ]
    ]
  );
  }
   return response()->json([
    'status' => true,
    'message' => 'Menu Call Flow Created successfully'
]);
}elseif(empty($sim_numbers) && !empty($rubin_numbers) && empty($forword_number) && empty($menu_text)) {
  $rrNumbers = $rubin_numbers; // Array of destination numbers from the front end
  $numbersString = implode(',', $rrNumbers);
  $flow = $twilio->studio->v2->flows
  ->create("$IVRNAmeva", // friendlyName
"draft", // status
[
  "description"=> "A New Flow",
  "states"=> [
    [
      "name"=> "Trigger",
      "type"=> "trigger",
      "transitions"=> [
        [
          "event"=> "incomingMessage"
        ],
        [
          "event"=> "incomingCall"
        ],
        [
          "next"=> "say_play_1",
          "event"=> "incomingConversationMessage"
        ],
        [
          "event"=> "incomingRequest"
        ],
        [
          "event"=> "incomingParent"
        ]
      ],
      "properties"=> [
        "offset"=> [
          "x"=> 0,
          "y"=> 0
        ]
      ]
    ],
    [
      "name"=> "http_1",
      "type"=> "make-http-request",
      "transitions"=> [
        [
          "event"=> "success"
        ],
        [
          "event"=> "failed"
        ]
      ],
      "properties"=> [
        "offset"=> [
          "x"=> 220,
          "y"=> 470
        ],
        "method"=> "POST",
        "content_type"=> "application/json;charset=utf-8",
        "body"=> json_encode(['numbers' => $rubin_numbers]),
        "url"=> url('/round_rubin')
      ]
    ],
    [
      "name"=> "say_play_1",
      "type"=> "say-play",
      "transitions"=> [
        [
          "next"=> "http_1",       
          "event"=> "audioComplete"
        ]
      ],
      "properties"=> [
        "offset"=> [
          "x"=> 230,
          "y"=> 220
        ],
        "loop"=> 1,
        "say"=> "your call will be record for quality assurance."
      ]
    ]
  ],
  "initial_state"=> "Trigger",
  "flags"=> [
    "allow_concurrent_calls"=> true
  ]
]
);
  return response()->json([
      'status' => true,
      'message' => 'Round Robin Call Flow created successfully'
  ]);
}elseif(empty($sim_numbers) && empty($rubin_numbers) && empty($forword_number) && empty($menu_text)) {
  return response()->json([
    'status' => false,
    'message' => 'Failed To create Call Flow'
]);
}
    }
    public function processIVR(Request $request)
    {
        $response = new VoiceResponse();
        $digits = $request->input('Digits');

        switch ($digits) {
            case 1:
                $response->say("You selected sales. Please wait while we connect you to a sales representative.");
                $response->dial('+923330909274');
                break;
            case 2:
                $response->say("You selected support. Please wait while we connect you to a support agent.");
                $response->dial('+16205268979');
                break;
            case 3:
                $response->say("You selected billing. Please wait while we connect you to our billing department.");
                $response->dial('+16205268979');
                break;
            default:
                $response->redirect('/incoming-call');
                break;
        }

        return response($response)->header('Content-Type', 'text/xml');
    }
    public function handleFormSubmission(Request $request)
{
    $inputValue = $request->input('input_field');
    return view('createFlow', [
        'inputValue' => $inputValue,
    ]);
}
public function submitForm(Request $request)
    {
        $inputValue = $request->input('input_field');
        
        return view('createFlow')->with('inputValue', $inputValue);
    }
    public function callflow()
    {
      $sid = env("TWILIO_ACCOUNT_SID");
      $token = env("TWILIO_AUTH_TOKEN");
      $twilio = new Client($sid, $token);
      
      $flows = $twilio->studio->v1->flows->read();
      $array = [];
      foreach ($flows as $flow) {
        $flowSid = $flow->sid;
        $flowFriendlyName = $flow->friendlyName;
        $dateCreated = $flow->dateCreated->format('D, n/j/y, g:i:s A');
        $phoneNumbers = $twilio->incomingPhoneNumbers->read([
          'voiceApplicationSid' => $flowSid,
        ]);
        $phoneNumberCount = count($phoneNumbers);
        $array[] =  [
          'flowSid'=>$flowSid,
          'friendlyName'=>$flowFriendlyName,
          'dateCreated'=>$dateCreated,
          'numbers'=>$phoneNumberCount
      ];
      }
        // Return the flows or perform further actions
        return view('call-flow', [
          'data'=>$array
      ]);
    }
    public function deleteflow()
    {
        return view('deleteflow');
    }
    public function deleteflowPost(Request $request)
    {
      $id = $request->id;
      $sid = env("TWILIO_ACCOUNT_SID");
      $token = env("TWILIO_AUTH_TOKEN");
      $twilio = new Client($sid, $token);

      $twilio->studio->v1->flows("$id")
                   ->delete();
            return response()->json([
                'status' => true
            ]);
    }
    public function buynumber(Request $request)
    {
        $sid = env("TWILIO_ACCOUNT_SID");
        $token = env("TWILIO_AUTH_TOKEN");
        $twilio = new Client($sid, $token);
       // Process the submitted form data
       $criteria = $request->input('criteria');
       $code = $request->input('code');

      try {
  $phoneNumbers = [];
  $local = $twilio->availablePhoneNumbers("$criteria")->local->read(["areaCode" => $code], 100);
  foreach ($local as $record) {
    $phoneNumbers[] = [
      'phoneNumber' => $record->friendlyName,
      'locality' => $record->locality,
  ];
}
        return response()->json([
          'status' => true,
          'numbers'=> $phoneNumbers
      ]);
    } catch (TwilioException $e) {
      // Handle Twilio exceptions
      $errorCode = $e->getCode();
      $errorMessage = $e->getMessage();

      // Log or display the error information
      Log::error("Twilio API Exception: $errorCode - $errorMessage");

      // Return a custom error response if needed
      return response()->json([
        'status' => false,
        'message' => 'No number Available at this code',
    ]);
  } catch (\Exception $e) {
      // Handle other general exceptions
      $errorMessage = $e->getMessage();

      // Log or display the error information
      Log::error("General Exception: $errorMessage");

      // Return a custom error response if needed
      return response()->json([
        'message' => $errorMessage,
    ]);
  }

    }
    public function getAllCountry()
{
  try {
        $sid = env("TWILIO_ACCOUNT_SID");
        $token = env("TWILIO_AUTH_TOKEN");
        $twilio = new Client($sid, $token);
    $countries = $twilio->pricing->v1->voice->countries->read();

    $countryList = [];

    foreach ($countries as $country) {
        $countryList[] = [
          'country' => $country->country,
          'code' => $country->isoCountry
        ];
    }

    return view('buy-number', [
      'countries' => $countryList,
  ]);
    
} catch (TwilioException $e) {
    // Handle any Twilio exceptions
    return null;
}
}

public function buyit()
{
    return view('buyit');
}
public function buyitPost(Request $request)
{
        $numberid = $request->id;

        try {
          $sid = env("TWILIO_ACCOUNT_SID");
          $token = env("TWILIO_AUTH_TOKEN");
          $twilio = new Client($sid, $token);
          $incoming_phone_number = $twilio->incomingPhoneNumbers->create(["phoneNumber" => "$numberid"]);

  
      
        return response()->json([
          'status' => true,
          'message' =>'Number has been Successfully Purchased'
      ]);
  } catch (TwilioException $e) {
            // Handle Twilio exceptions
            $errorCode = $e->getCode();
            $errorMessage = $e->getMessage();
      
            // Log or display the error information
            Log::error("Twilio API Exception: $errorCode - $errorMessage");
      
            // Return a custom error response if needed
            return response()->json([
              'status' => false,
              'message' => 'Unable to purchase number, please upgrade your account.',
          ]);
  }
}
public function automationform(Request $request){
  $sid = env('TWILIO_ACCOUNT_SID');
  $token = env('TWILIO_AUTH_TOKEN');

  $client = new Client($sid, $token);

  $checktext = $request->input('checktext');
  $textmessage = $request->input('textmessage');
  if ($checktext == 'true') {
    
  }
  // return redirect()->back()->with('error', 'Please enter a message.');
}
public function dashboard(){



  
  return view('dashboard');
}
}
