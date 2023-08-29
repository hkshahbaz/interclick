<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TwilioController;
use App\Http\Controllers\CallFlowController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('/auth/login');
});
Route::get('/register', function () {
    return view('/auth/register');
});
Route::get('/forgot-password', function () {
    return view('/auth/forgot-password');
});
Route::get('/dashboard', [TwilioController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profilePage', [ProfileController::class, 'profilePage'])->name('profilePage');
    Route::get('/edit-profile', [ProfileController::class, 'editprofile'])->name('editprofile');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/updatePassword', [ProfileController::class, 'password'])->name('password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/conversation', function () {
    return view('conversation');
});
Route::get('/conversation', [TwilioController::class, 'getConversations'])->name('conversation');
Route::get('/conversation/{phone_number}',[TwilioController::class, 'show'])->name('show');
Route::get('/conversation/{phone_number?}', 'TwilioController@getMessages')->name('conversation.show');
Route::post('/send-sms', [TwilioController::class, 'sendSms'])->name('sendSms');

Route::get('/my-number', function () {
    return view('my-number');
});
// attributes
Route::post('/conversation', [App\Http\Controllers\AttributeController::class, 'store'])->name('conversation.store');
Route::put('/conversation/{attribute}', [App\Http\Controllers\AttributeController::class, 'update'])->name('conversation.update');
// tracking
Route::get('/my-number', [TwilioController::class, 'getTrackingNumbers'])->name('my-number');

Route::get('/PPC-landing-page', function () {
    return view('PPC-landing-page');
});
Route::get('/PPC-landing-page/{sid}',[TwilioController::class, 'PPC'])->name('PPC');
Route::get('/real-time/{sid}', [TwilioController::class, 'realtime'])->name('realtime');
Route::get('deleteevent', [TwilioController::class, 'deleteevent']);
Route::post('deleteevent', [TwilioController::class, 'deleteevent2'])->name('deleteevent2.post');
Route::get('/automation/{sid}', [TwilioController::class, 'automation'])->name('automation');
Route::post('/automationform', [TwilioController::class, 'automationform'])->name('automationform');
Route::get('/call-config/{sid}', [TwilioController::class, 'callconfig'])->name('callconfig');
Route::post('/configsystem', [TwilioController::class, 'configsystem'])->name('configsystem');
Route::get('/start-flow', function () {
    return view('start-flow');
});
Route::get('/createFlow', function () {
    return view('createFlow');
});

Route::get('/tags', function () {
    return view('tags');
});
Route::get('/buy-number', function () {
    return view('buy-number');
});
Route::get('/buy-number', [TwilioController::class, 'getAllCountry'])->name('getAllCountry');
// Route::get('/conversation/{id}/edit', [TwilioController::class, 'edit'])->name('conversation.edit');
// open
Route::get('/call-flow', [TwilioController::class, 'callflow'])->name('callflow');

Route::get('edit', [TwilioController::class, 'edit']);
Route::post('edit', [TwilioController::class, 'editPost'])->name('edit.post');
// pending
Route::get('edit2', [TwilioController::class, 'edit2']);
Route::post('edit2', [TwilioController::class, 'editPost2'])->name('edit2.post');
// close
Route::get('edit3', [TwilioController::class, 'edit3']);
Route::post('edit3', [TwilioController::class, 'editPost3'])->name('edit3.post');

Route::get('/conversation/{id}/edit3', [TwilioController::class, 'edit3'])->name('conversation.edit3');
Route::post('/costum-note', [App\Http\Controllers\AttributeController::class, 'update2'])->name('submit.form');
Route::post('/tag', [App\Http\Controllers\AttributeController::class, 'addtags'])->name('addtags.form');
Route::post('/updatetag', [App\Http\Controllers\AttributeController::class, 'updatetag'])->name('updatetag.form');
  
Route::get('customNote', [TwilioController::class, 'customNote']);
Route::post('customNote', [TwilioController::class, 'customNotePost'])->name('customNote.post');
Route::post('/createFlow', [TwilioController::class, 'submitForm'])->name('pageB');

// tags crud
Route::post('/createTags', [TagController::class, 'create'])->name('createTag.form');
Route::post('/updateTags', [TagController::class, 'update'])->name('updateTag.form');
Route::get('/tags', [TagController::class, 'index'])->name('tags');
Route::get('/tags/{id}', [TagController::class, 'getTagById'])->name('tags.show');

Route::get('deleteTag', [TagController::class, 'deleteTag']);
Route::post('deleteTag', [TagController::class, 'deleteTagPost'])->name('deleteTag.post');

Route::get('removeTag', [TagController::class, 'removeTag']);
Route::post('removeTag', [TagController::class, 'removeTagPost'])->name('removeTag.post');

// call flow
// Route::post('/make-flow', [TwilioController::class, 'makeflow'])->name('makeflow');
Route::get('makeflow', [TwilioController::class, 'makeflow']);
Route::post('makeflow', [TwilioController::class, 'makeflowPost'])->name('makeflow.post');
Route::post('/process-ivr', [TwilioController::class, 'processIVR']);

Route::get('deleteflow', [TwilioController::class, 'deleteflow']);
Route::post('deleteflow', [TwilioController::class, 'deleteflowPost'])->name('deleteflow.post');
// buy number
Route::post('/buy-form', [TwilioController::class, 'buynumber'])->name('buy-form');

Route::get('buy-it', [TwilioController::class, 'buyit']);
Route::post('buy-it', [TwilioController::class, 'buyitPost'])->name('buyit.post');



// Route::post('/round-rubin', 'CallFlowController@handleIncomingCall');
// Route::post('/round-rubin', [CallFlowController::class, 'handleIncomingCall'])->name('handleIncomingCall');

Route::middleware('web')->group(function () {
    // Route to handle the POST request
    Route::post('/round-rubin', [CallFlowController::class, 'handleIncomingCall']);
});




require __DIR__.'/auth.php';
