<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Twilio\Rest\Client;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $user->name=$request->name;
        $user->number=$request->number;
        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $profilePicture = $request->file('profile_picture');
            $profilePicturePath = $profilePicture->store('images', 'public');
            // Delete the previous profile picture if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $user->profile_picture = $profilePicturePath;
        }
        $user->save();

        return redirect()->back()->with('success', 'Profile updated Successfully');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    public function editprofile(Request $request){
        // Retrieve the current user instance
        $user = Auth::user();
        $name = $user->name;
        $email = $user->email;
        $id = $user->id;
        $number = $user->number;
        $picture = $user->profile_picture;
        return view('edit-profile',[
            'email'=>$email,
            'id'=>$id,
            'name'=>$name,
            'number'=>$number,
            'picture'=>$picture
        ]);
    }
    public function password(Request $request)
    {
         // Get the authenticated user
         $user = Auth::user();

         // Validate the request data
        $password = $request->password;
        $newpassword = $request->newpassword;
 
         // Check if the current password matches
         if (!Hash::check($password, $user->password)) {
            return redirect()->back()->with('error', 'The current password is incorrect.');
         }else{
            // Update the user's password
            $user->password = Hash::make($newpassword);
            
            // Save the changes
            $user->save();
            return redirect()->back()->with('success', 'Password has been updated');
         }
    }
    public function profilePage(){


        // Create a Twilio client
        $client = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

        // Get the account phone numbers
        $numbers = $client->incomingPhoneNumbers->read();
        // Get the count of active numbers
        $activeNumbersCount = count($numbers);

        $perCamp = $activeNumbersCount/5*100;
        // All Min
         // Set the initial page size and total duration
         $pageSize = 1000;
         $totalDuration = 0;
 
         // Retrieve all call records using pagination
         $page = 1;
         do {
             // Retrieve a page of call records
             $calls = $client->calls->read([], $pageSize, $pageSize * ($page - 1));
 
             // Calculate the total call duration
             foreach ($calls as $call) {
                 $totalDuration += ceil($call->duration);
             }
 
             $page++;
         } while (count($calls) === $pageSize);
 
         // Convert the duration to minutes
         $totalDurationMinutes = ceil($totalDuration / 60);
         $minPer = $totalDurationMinutes/250*100;
        //  end min
        $user = Auth::user();
        $name = $user->name;
        $picture = $user->profile_picture;
        $email = $user->email;
        $id = $user->id;
        $number = $user->number;

        return view('profile',[
            'email'=>$email,
            'id'=>$id,
            'name'=>$name,
            'picture'=>$picture,
            'number'=>$number,
            'Percampaign'=>$perCamp,
            'countCamp'=>$activeNumbersCount,
            'totalMin'=>$totalDurationMinutes,
            'minPer'=>$minPer
        ]);
    }
}
