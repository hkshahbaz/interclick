@php
    use Illuminate\Support\Facades\Auth;
    // Get the authenticated user
    $user = Auth::user();
    if (!empty($user->profile_picture)) {
        $picture = $user->profile_picture;
    }else{
        $picture = "";
        header("Location: /");
        exit();
    }
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard | Call Flow</title>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" /> 
    <link href="{{ asset('css/jquery.toast.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="{{url('images/favicon.png')}}">
    <link rel="stylesheet" href="{{ asset('css/data-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <button id="sidebar-toggle" class="collapse-btn"><i class="fa-solid fa-bars"></i></button>
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <a class="navbar-brand" href="{{url('/dashboard')}}"><img src="{{url('images/logo.png')}}" alt=""></a>
        </div>
        <div class="sidebar-item mt-5">
            <div class="dropdown">
                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    All Companies
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
            </div>
        </div>
        <div class="heading mt-3"><div class="h6">Navigation</div></div>
        <div class="sidebar-item">
            <div class="inactive">
                <a href="{{url('/dashboard')}}"><i class="fa-solid fa-qrcode"></i><span class="mx-2">Dashboard</span></a>
            </div>
        </div>
        <div class="sidebar-item">
            <div class="active">
                <a href="{{url('/my-number')}}"><i class="fa fa-phone" aria-hidden="true"></i><span style="background:#F5FAFF" class="mx-2">My Number</span></a>
            </div>
            
        </div>
        <div class="sidebar-item">
            <div class="inactive">
                <a href="#"><i class="fa fa-line-chart" aria-hidden="true"></i><span class="mx-2">Reports</span></a>
            </div>
        </div>
        <div class="sidebar-item">
            <div class="inactive">
                <a href="#"><i class="fa fa-cog" aria-hidden="true"></i><span class="mx-2">Integrations</span></a>
            </div>
        </div>
        <div class="heading mt-3"><div class="h6">Support</div></div>
        <div class="sidebar-item">
            <div class="inactive">
                <a href="{{url('/tags')}}"><i class="fa-solid fa-tags"></i><span class="mx-2">Tags</span></a>
            </div>
        </div>
        <div class="sidebar-item">
            <div class="inactive">
                <a href="{{url('/conversation')}}"><i class="fa fa-commenting" aria-hidden="true"></i><span class="mx-2">Conversations</span></a>
            </div>
        </div>
        <div class="sidebar-item">
            <div class="inactive">
                <a href="#"><i class="fa fa-question-circle" aria-hidden="true"></i><span class="mx-2">Help</span></a>
            </div>
        </div>
    </div>
</div>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <h5 class="navbar-brand">My Numbers</h5>
        
            {{-- <form class="d-flex search" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form> --}}
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mx-5 mb-2 mb-lg-0">
                <li class="nav-item ">
                <a class="nav-link abclink" href="/conversation"><img src="{{ url('images/Message.png') }}" alt=""></a>
                </li>
                 <li class="nav-item dropdown-center">
                    <a class="nav-link notify" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="#"><img src="{{ url('images/Notification.png') }}" alt=""></a>
                    <ul class="dropdown-menu" style="margin-left:-50px; width: 300px">
                        <li>
                            <a href="#">
                                <div class="card">
                                    <div class="card-body">
                                        <img class="rounded-circle" style="position:absolute; margin-top:25px; width:40px;height:40px;" src="{{ asset('storage/' . $picture) }}" alt="">
                                        <div class="user_notify">
                                            <div class="row">
                                                <div class="col-lg-6 col-sm-6 col-md-6">
                                                    <h6>Jerome Bell</h6>
                                                </div>
                                                <div class="col-lg-6 col-sm-6 col-md-6">
                                                    <div class="notify-time">
                                                        <p>Yesterday</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="notification_msg">
                                            <p>
                                                Amet minim mollit non deserunt...
                                            </p>
                                        </div>
                                        <div class="notification_number">
                                            <p>
                                                +1-344-543-4578
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="card">
                                    <div class="card-body">
                                        <img class="rounded-circle" style="position:absolute; margin-top:25px; width:40px;height:40px;" src="{{ asset('storage/' . $picture) }}" alt="">
                                        <div class="user_notify">
                                            <div class="row">
                                                <div class="col-lg-6 col-sm-6 col-md-6">
                                                    <h6>Jerome Bell</h6>
                                                </div>
                                                <div class="col-lg-6 col-sm-6 col-md-6">
                                                    <div class="notify-time">
                                                        <p>Yesterday</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="notification_msg">
                                            <p>
                                                Amet minim mollit non deserunt...
                                            </p>
                                        </div>
                                        <div class="notification_number">
                                            <p>
                                                +1-344-543-4578
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="card">
                                    <div class="card-body">
                                        <img class="rounded-circle" style="position:absolute; margin-top:25px; width:40px;height:40px;" src="{{ asset('storage/' . $picture) }}" alt="">
                                        <div class="user_notify">
                                            <div class="row">
                                                <div class="col-lg-6 col-sm-6 col-md-6">
                                                    <h6>Jerome Bell</h6>
                                                </div>
                                                <div class="col-lg-6 col-sm-6 col-md-6">
                                                    <div class="notify-time">
                                                        <p>Yesterday</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="notification_msg">
                                            <p>
                                                Amet minim mollit non deserunt...
                                            </p>
                                        </div>
                                        <div class="notification_number">
                                            <p>
                                                +1-344-543-4578
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="card">
                                    <div class="card-body">
                                        <img class="rounded-circle" style="position:absolute; margin-top:25px; width:40px;height:40px;" src="{{ asset('storage/' . $picture) }}" alt="">
                                        <div class="user_notify">
                                            <div class="row">
                                                <div class="col-lg-6 col-sm-6 col-md-6">
                                                    <h6>Jerome Bell</h6>
                                                </div>
                                                <div class="col-lg-6 col-sm-6 col-md-6">
                                                    <div class="notify-time">
                                                        <p>Yesterday</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="notification_msg">
                                            <p>
                                                Amet minim mollit non deserunt...
                                            </p>
                                        </div>
                                        <div class="notification_number">
                                            <p>
                                                +1-344-543-4578
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown-center">
                <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="rounded-circle" style="width:40px;height:40px;" src="{{ asset('storage/' . $picture) }}" alt="Profile">
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item mx-3 mt-3" href="{{url('/profilePage')}}">Profile</a></li>
                    <li><a class="dropdown-item mx-3 mt-3" href="{{url('/edit-profile')}}">Edit Profile</a></li>
                    <li><hr class="dropdown-divider mt-3 mx-2"></li>
                    <li><a class="dropdown-item mx-3 mt-3" href="#">Upgrade Plan</a></li>
                    <li><hr class="dropdown-divider mt-3 mx-2"></li>
                    <li><a class="dropdown-item mx-3 mt-3" href="#">Account settings</a></li>
                    @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <li><button type="submit" class="dropdown-item mx-3 mt-3" href="{{ __('logout') }}">Log out</button></li>
                    </form>
                @endauth
                </ul>
                </li>
            </ul>
        </div>
    </div>
    </nav>
                
    <main class="wrapper">
        <div class="wrapper-body">
            <div class="row d-flex justify-content-center ">
                <div class="col-lg-9 text-center">
                    <h4 style="/* H4 */

                    font-style: normal;
                    font-weight: 600;
                    font-size: 32px;
                    line-height: 40px;
                    /* identical to box height, or 125% */
                    
                    letter-spacing: -0.03em;
                    
                    color: #000000;" class="mb-5">Happy Customer</h4>
                </div>
            </div>
        <form id="wizardForm" method="POST">
            <fieldset>
            <div class="row mt-5 d-flex justify-content-center">
                <div class="col-lg-9">
                    <div class="card p-3">
                        <div class="card-body">
                            <div class="row">
                                <h5 style="/* H5 */
                                font-style: normal;
                                font-weight: 600;
                                font-size: 24px;
                                line-height: 32px;
                                letter-spacing: -0.02em;
                                color: #000000;
                                ">Greeting</h5>
                            </div>
                            <div class="row">
                                <p>Play a message to the caller. Frequently used to notify the caller about call recording.</p>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <a onclick="textMessage()" id="readbtn" class="btn btn-primary active-btn prevent-scroll" href="#">Read Message</a>      
                                    <a onclick="sayMessage()" id="saybtn" class="btn btn-primary inactive-btn prevent-scroll" href="#">Play Recording</a>      
                                  </div>
                            </div>
                            @php
                                if (!isset($inputValue))
                                {$inputValue = "New IVR";
                                }
                            @endphp
                            <input type="hidden" name="IVRNAme" value="{{$inputValue}}">
                            <div id="textdiv" class="row mt-3">
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">Read the following text to the caller with a robot-like voice:</label>
                                    <textarea name="welcomeText" style="padding: 18px;
                                    resize:none;
                                    box-shadow:none;
                                    border: 1px solid #6F767E;" class="form-control" id="exampleFormControlTextarea1" rows="3">This call will be recorded for quality assurance.</textarea>
                                </div>
                            </div>
                            <div id="saydiv" class="row mt-3 hidden">
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">Provide voice url to say when call is connect:</label>
                                    <input class="form-control mt-2" type="text" placeholder="https://wa.me/1234567890?voice=myvoice.mp3" name="voiceurl">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex mt-5 justify-content-center">
                <div class="col-lg-3">
                    <button id="stepgreeting" type="button" onclick="nextStep(1)" class="btn btn-danger" style="/* Frame 1000003992 */
                    box-sizing: border-box;
                    
                    /* Auto layout */
                    
                    flex-direction: row;
                    align-items: center;
                    padding: 6px 8px;
                    gap: 6px;
                    
                    /* Primary/500
                    
                    Primary/500
                    */
                    border: 1px solid #2A86FF;
                    border-radius: 20px;
                    background:#FFFFFF;
                    color:#2A86FF;
                    font-weight: 500;
                    font-size: 15px;
                    /* Inside auto layout */
                    
                    flex: none;
                    order: 2;
                    flex-grow: 0;"><i class="fa-solid fa-plus"></i> Insert step here</button>
                </div>
            </div>
        </fieldset>
        <fieldset class="hidden">
            <div class="row mt-5 d-flex justify-content-center">
                <div class="col-lg-9">
                    <div class="card p-3">
                        <div class="card-body">
                            <div class="row">
                                <h5 style="/* H5 */
                                font-style: normal;
                                font-weight: 600;
                                font-size: 24px;
                                line-height: 32px;
                                
                                letter-spacing: -0.02em;
                                
                                color: #000000;
                                ">Forward the Call</h5>
                            </div>
                            <div class="row">
                                <p>This is where the phone will ring when customers dial your tracking number.</p>
                            </div>
                            <div class="row mt-1 g-3 align-items-center">
                                <div class="col-3">
                                    <select  class="form-select" aria-label="Default select example">
                                        <option selected>Number</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                  <input name="forword_number" type="number" placeholder="15555555678" id="input" class="form-control">
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-check mt-3">
                                        <input name="forword_check" class="form-check-input" type="checkbox" value="true" id="flexCheckChecked" checked>
                                        <label class="form-check-label" for="flexCheckChecked">
                                            Prevent voicemails and automated systems from answering a call.
                                        </label>
                                    </div>
                                </div>
                              </div>
                              <div class="row g-0">
                                <div class="col-auto mt-2">
                                    <span style="margin-right:10px;
                                    font-style: normal;
                                    font-weight: 400;
                                    font-size: 18px;
                                    line-height: 28px;
                                    /* identical to box height, or 156% */
                                    
                                    
                                    /* Neutral/04 */
                                    
                                    color: #6F767E;">If the destination does not answer within</span>
                                </div>
                                <div class="col-auto mt-1">
                                    <select name="forword_duration" class="form-select" aria-label="Default select example">
                                        <option selected value="10">10 seconds</option>
                                        <option value="20">20 seconds</option>
                                        <option value="30">30 seconds</option>
                                        <option value="40">40 seconds</option>
                                    </select>
                                </div>
                                <div class="col-auto mt-2">
                                    <span style="margin-left:10px;
                                    font-style: normal;
                                    font-weight: 400;
                                    font-size: 18px;
                                    line-height: 28px;
                                    /* identical to box height, or 156% */
                                    
                                    
                                    /* Neutral/04 */
                                    
                                    color: #6F767E;">then go to the next step.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex mt-5 justify-content-center">
                <div class="col-lg-3">
                    <button id="cancelfor" onclick="cancelforfunc()" type="button" class="btn btn-danger hidden" style="/* Frame 1000003992 */


                    box-sizing: border-box;
                    
                    /* Auto layout */
                    
                    flex-direction: row;
                    align-items: center;
                    padding: 6px 8px;
                    gap: 6px;
                    
                    
                    /* Primary/500
                    
                    Primary/500
                    */
                    border: 1px solid #2A86FF;
                    border-radius: 20px;
                    background:#FFFFFF;
                    color:#2A86FF;
                    font-weight: 500;
                    font-size: 15px;
                    /* Inside auto layout */
                    
                    flex: none;
                    order: 2;
                    flex-grow: 0;"><i class="fa-solid fa-minus"></i> Cancel</button>
                    <button type="button" id="stepfor" onclick="nextStep(2)" class="btn btn-danger" style="/* Frame 1000003992 */


                    box-sizing: border-box;
                    
                    /* Auto layout */
                    
                    flex-direction: row;
                    align-items: center;
                    padding: 6px 8px;
                    gap: 6px;
                    
                    
                    /* Primary/500
                    
                    Primary/500
                    */
                    border: 1px solid #2A86FF;
                    border-radius: 20px;
                    background:#FFFFFF;
                    color:#2A86FF;
                    font-weight: 500;
                    font-size: 15px;
                    /* Inside auto layout */
                    
                    flex: none;
                    order: 2;
                    flex-grow: 0;"><i class="fa-solid fa-plus"></i> Insert step here</button>
                        <button id="createBtn2" type="submit" class="btn btn-danger" style="/* Frame 1000003992 */
                        box-sizing: border-box;
                        
                        /* Auto layout */
                        
                        flex-direction: row;
                        align-items: center;
                        padding: 6px 8px;
                        gap: 6px;
                        
                        
                        /* Primary/500
                        
                        Primary/500
                        */
                        border: 1px solid #2A86FF;
                        border-radius: 20px;
                        background:#FFFFFF;
                        color:#2A86FF;
                        font-weight: 500;
                        font-size: 15px;
                        /* Inside auto layout */
                        
                        flex: none;
                        order: 2;
                        flex-grow: 0;"><i class="fa-solid fa-plus"></i> Create</button>
                </div>
            </div>
        </fieldset>
        <fieldset class="hidden">
            <div class="row mt-5 d-flex justify-content-center">
                <div class="col-lg-9">
                    <div class="card p-3">
                        <div class="card-body">
                            <div class="row">
                                <h5 style="/* H5 */

                                font-style: normal;
                                font-weight: 600;
                                font-size: 24px;
                                line-height: 32px;
                                
                                letter-spacing: -0.02em;
                                
                                color: #000000;
                                ">Simultaneous Ring</h5>
                            </div>
                            <div class="row">
                                <p>We'll dial all numbers in the Simulcall at the same time. The first person to answer will be connected to the caller.</p>
                            </div>
                            <div id="targetElement"></div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="button" id="appendButton" class="btn btn-primary mt-2" style="border: none;background:none;color:#2A86FF"><i class="fa-solid fa-plus"></i> Add Number</button>
                                </div>
                            </div>
                              <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-check mt-3">
                                        <input name="sim_check1" class="form-check-input" type="checkbox" value="true" id="flexCheckChecked2" checked>
                                        <label class="form-check-label" for="flexCheckChecked2">
                                            Prevent voicemails and automated systems from answering a call.
                                        </label>
                                    </div>
                                </div>
                              </div>
                              <div class="row g-0">
                                <div class="col-auto mt-2">
                                    <span style="margin-right:10px;
                                    font-style: normal;
                                    font-weight: 400;
                                    font-size: 18px;
                                    line-height: 28px;
                                    /* identical to box height, or 156% */
                                    
                                    /* Neutral/04 */
                                    
                                    color: #6F767E;">If the destination does not answer within</span>
                                </div>
                                <div class="col-auto mt-1">
                                    <select name="sim_duration" class="form-select" aria-label="Default select example">
                                        <option selected value="10">10 seconds</option>
                                        <option value="20">20 seconds</option>
                                        <option value="30">30 seconds</option>
                                        <option value="40">40 seconds</option>
                                    </select>
                                </div>
                                <div class="col-auto mt-2">
                                    <span style="margin-left:10px;
                                    font-style: normal;
                                    font-weight: 400;
                                    font-size: 18px;
                                    line-height: 28px;
                                    color: #6F767E;">then go to the next step.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex mt-5 justify-content-center">
                <div class="col-lg-3">
                    <button onclick="cancelsimfunction()" type="button" id="cancelsim" class="btn btn-danger hidden" style="/* Frame 1000003992 */
                    box-sizing: border-box;
                    /* Auto layout */
                    flex-direction: row;
                    align-items: center;
                    padding: 6px 8px;
                    gap: 6px;
                    
                    
                    /* Primary/500
                    
                    Primary/500
                    */
                    border: 1px solid #2A86FF;
                    border-radius: 20px;
                    background:#FFFFFF;
                    color:#2A86FF;
                    font-weight: 500;
                    font-size: 15px;
                    /* Inside auto layout */
                    
                    flex: none;
                    order: 2;
                    flex-grow: 0;"><i class="fa-solid fa-minus"></i> Cancel</button>
                    <button id="stepsim" type="button" onclick="nextStep(3)" class="btn btn-danger" style="/* Frame 1000003992 */
                    box-sizing: border-box;
                    /* Auto layout */
                    flex-direction: row;
                    align-items: center;
                    padding: 6px 8px;
                    gap: 6px;
                    
                    
                    /* Primary/500
                    
                    Primary/500
                    */
                    border: 1px solid #2A86FF;
                    border-radius: 20px;
                    background:#FFFFFF;
                    color:#2A86FF;
                    font-weight: 500;
                    font-size: 15px;
                    /* Inside auto layout */
                    
                    flex: none;
                    order: 2;
                    flex-grow: 0;"><i class="fa-solid fa-plus"></i> Insert step here</button>
                        <button id="createBtn3" type="submit" class="btn btn-danger hidden" style="/* Frame 1000003992 */
                        box-sizing: border-box;
                        
                        /* Auto layout */
                        
                        flex-direction: row;
                        align-items: center;
                        padding: 6px 8px;
                        gap: 6px;
                        
                        
                        /* Primary/500
                        
                        Primary/500
                        */
                        border: 1px solid #2A86FF;
                        border-radius: 20px;
                        background:#FFFFFF;
                        color:#2A86FF;
                        font-weight: 500;
                        font-size: 15px;
                        /* Inside auto layout */
                        
                        flex: none;
                        order: 2;
                        flex-grow: 0;"><i class="fa-solid fa-plus"></i> Create</button>
                </div>
            </div>
        </fieldset>
        <fieldset class="hidden">
            <div class="row mt-5 d-flex justify-content-center">
                <div class="col-lg-9">
                    <div class="card p-3">
                        <div class="card-body">
                            <div class="row">
                                <h5 style="/* H5 */

                                font-style: normal;
                                font-weight: 600;
                                font-size: 24px;
                                line-height: 32px;
                                
                                letter-spacing: -0.02em;
                                
                                color: #000000;
                                ">Menu</h5>
                            </div>
                            <div class="row">
                                <p>Prompt the caller to select from a menu of options using the keypad on their phone.</p>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <a type="button" id="readbtn2" onclick="readMessage2()" class="btn btn-primary active-btn prevent-scroll" href="#">Read Message</a>      
                                    <a type="button" id="saybtn2" onclick="sayMessage2()"  class="btn btn-primary inactive-btn prevent-scroll" href="#">Play Recording</a>      
                                  </div>
                            </div>
                            <div id="textdiv2" class="row mt-3">
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">Read the following text to the caller with a robot-like voice:</label>
                                    <textarea name="menu_text" style="padding: 18px;
                                    resize:none;
                                    box-shadow:none;
                                    border: 1px solid #6F767E;" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                            </div>
                            <div id="saydiv2" class="row mt-3 hidden">
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">Provide voice url to say when call is connect:</label>
                                    <input type="text" class="form-control" placeholder="https://wa.me/1234567890?voice=myvoice.mp3" name="menuvoiceurl"> 
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-lg-12">
                                    <label for="qwwe" class="form-label">If the caller</label>
                                </div>
                            </div>
                            <div class="row g-3 align-items-center">
                                <div class="col-3">
                                    <select name="press[]" class="form-select" aria-label="Default select example">
                                        <option>Select Key</option>
                                        <option value="1">Presses 1</option>
                                        <option value="2">Presses 2</option>
                                        <option value="3">Presses 3</option>
                                        <option value="4">Presses 4</option>
                                        <option value="5">Presses 5</option>
                                        <option value="6">Presses 6</option>
                                        <option value="7">Presses 7</option>
                                        <option value="8">Presses 8</option>
                                        <option value="9">Presses 9</option>
                                        <option value="0">Presses 0</option>
                                      </select>
                                </div>
                                <div class="col-6">
                                  <input name="pressNumber[]" type="number" id="input" placeholder="15555555678" class="form-control">
                                </div>
                                <div class="col-auto">
                                    <button disabled class="btn btn-danger" style="background: none;color:#2A86FF;border:none"><i class="fa-solid fa-x"></i></button>
                                </div>
                            </div>
                            <div class="row mt-2 g-3 align-items-center">
                                <div class="col-3">
                                    <select name="press[]" class="form-select" aria-label="Default select example">
                                        <option>Select Key</option>
                                        <option value="1">Presses 1</option>
                                        <option value="2">Presses 2</option>
                                        <option value="3">Presses 3</option>
                                        <option value="4">Presses 4</option>
                                        <option value="5">Presses 5</option>
                                        <option value="6">Presses 6</option>
                                        <option value="7">Presses 7</option>
                                        <option value="8">Presses 8</option>
                                        <option value="9">Presses 9</option>
                                        <option value="0">Presses 0</option>
                                      </select>
                                </div>
                                <div class="col-6">
                                  <input name="pressNumber[]" type="number" id="input" placeholder="15555555678" class="form-control">
                                </div>
                                <div class="col-auto">
                                    <button disabled class="btn btn-danger" style="background: none;color:#2A86FF;border:none"><i class="fa-solid fa-x"></i></button>
                                </div>
                            </div>
                            <div id="targetElement9"></div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="button" id="appendButton9" class="btn btn-primary mt-2" style="border: none;background:none;color:#2A86FF"><i class="fa-solid fa-plus"></i> Add Number</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex mt-5 justify-content-center">
                <div class="col-lg-3">
                    <button type="button" onclick="clickmenu()" id="cancelmenu" class="btn btn-danger hidden" style="/* Frame 1000003992 */
                    box-sizing: border-box;
                    /* Auto layout */
                    flex-direction: row;
                    align-items: center;
                    padding: 6px 8px;
                    gap: 6px;
                    /* Primary/500
                    Primary/500
                    */
                    border: 1px solid #2A86FF;
                    border-radius: 20px;
                    background:#FFFFFF;
                    color:#2A86FF;
                    font-weight: 500;
                    font-size: 15px;
                    /* Inside auto layout */
                    flex: none;
                    order: 2;
                    flex-grow: 0;"><i class="fa-solid fa-minus"></i>Cancel</button>
                    <button id="stepmenu" type="button" onclick="nextStep(4)" class="btn btn-danger" style="/* Frame 1000003992 */
                    box-sizing: border-box;
                    
                    /* Auto layout */
                    
                    flex-direction: row;
                    align-items: center;
                    padding: 6px 8px;
                    gap: 6px;
                    
                    
                    /* Primary/500
                    
                    Primary/500
                    */
                    border: 1px solid #2A86FF;
                    border-radius: 20px;
                    background:#FFFFFF;
                    color:#2A86FF;
                    font-weight: 500;
                    font-size: 15px;
                    /* Inside auto layout */
                    
                    flex: none;
                    order: 2;
                    flex-grow: 0;"><i class="fa-solid fa-plus"></i> Insert step here</button>
                     
                        <button type="submit" id="createBtn4" class="btn btn-danger hidden" style="/* Frame 1000003992 */
                        box-sizing: border-box;
                        
                        /* Auto layout */
                        
                        flex-direction: row;
                        align-items: center;
                        padding: 6px 8px;
                        gap: 6px;
                        
                        
                        /* Primary/500
                        
                        Primary/500
                        */
                        border: 1px solid #2A86FF;
                        border-radius: 20px;
                        background:#FFFFFF;
                        color:#2A86FF;
                        font-weight: 500;
                        font-size: 15px;
                        /* Inside auto layout */
                        
                        flex: none;
                        order: 2;
                        flex-grow: 0;"><i class="fa-solid fa-plus"></i> Create</button>
                </div>
            </div>
        </fieldset>
        <fieldset class="hidden">
            <div class="row mt-5 d-flex justify-content-center">
                <div class="col-lg-9">
                    <div class="card p-3">
                        <div class="card-body">
                            <div class="row">
                                <h5 style="/* H5 */

                                font-style: normal;
                                font-weight: 600;
                                font-size: 24px;
                                line-height: 32px;
                                
                                letter-spacing: -0.02em;
                                
                                color: #000000;
                                ">Round Robin</h5>
                            </div>
                            <div class="row">
                                <p>Rotate calls evenly among a group of people. Repeat callers can be routed to the destination number that took the same caller's initial call.</p>
                            </div>
                            <div class="row mt-1">
                                <div class="col-lg-12">
                                    <label for="qwwe" class="form-label">If the caller</label>
                                </div>
                            </div>
                            <div id="targetElement2"></div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="button" id="appendButton2" class="btn btn-primary mt-2" style="border: none;background:none;color:#2A86FF"><i class="fa-solid fa-plus"></i> Add Number</button>
                                </div>
                            </div>
                            <div class="row g-0">
                                <div class="col-auto mt-2">
                                    <span style="margin-right:10px;
                                    font-style: normal;
                                    font-weight: 400;
                                    font-size: 18px;
                                    line-height: 28px;
                                    /* identical to box height, or 156% */
                                    
                                    
                                    /* Neutral/04 */
                                    
                                    color: #6F767E;">Allow the call to ring for</span>
                                </div>
                                <div class="col-auto mt-1">
                                    <select name="rubin_duration" class="form-select" aria-label="Default select example">
                                        <option selected>10 seconds</option>
                                        <option value="1">20 seconds</option>
                                        <option value="2">30 seconds</option>
                                        <option value="3">40 seconds</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                        <label class="form-check-label" for="flexCheckChecked">
                                            Prevent voicemails and automated systems from answering a call.
                                        </label>
                                    </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                        <label class="form-check-label" for="flexCheckChecked">
                                            Route calls using a weighted distribution. 
                                        </label>
                                    </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                        <label class="form-check-label" for="flexCheckChecked">
                                            Route previous callers to the number that answered last time they called.
                                        </label>
                                    </div>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex mt-5 justify-content-center">
                <div class="col-lg-3">
                    <button onclick="cancelrobin()" type="button" id="cancelrubin" class="btn btn-primary mb-5 hidden" style="/* Frame 1000003992 */
                    box-sizing: border-box;
                    
                    /* Auto layout */
                    
                    flex-direction: row;
                    align-items: center;
                    padding: 6px 8px;
                    gap: 6px;
                    
                    width:100px;
                    /* Primary/500
                    
                    Primary/500
                    */
                    border: 1px solid #2A86FF;
                    border-radius: 20px;
                    background:#FFFFFF;
                    color:#2A86FF;
                    font-weight: 500;
                    font-size: 15px;
                    /* Inside auto layout */
                    
                    flex: none;
                    order: 2;
                    flex-grow: 0;" id="submitButton"><i class="fa-solid fa-minus"></i> Cancel</button>
                    <button type="submit" class="btn btn-primary mb-5" style="/* Frame 1000003992 */
                    box-sizing: border-box;
                    
                    /* Auto layout */
                    
                    flex-direction: row;
                    align-items: center;
                    padding: 6px 8px;
                    gap: 6px;
                    
                    width:100px;
                    /* Primary/500
                    
                    Primary/500
                    */
                    border: 1px solid #2A86FF;
                    border-radius: 20px;
                    background:#FFFFFF;
                    color:#2A86FF;
                    font-weight: 500;
                    font-size: 15px;
                    /* Inside auto layout */
                    
                    flex: none;
                    order: 2;
                    flex-grow: 0;" id="submitButton"><i class="fa-solid fa-plus"></i> Create</button>
                </div>
            </div>
        </fieldset>
    </form>
    <div id="show"></div>
            <div class="card mt-5" id="happen">
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-lg-12 text-center">
                            <h4 >What would you like to happen?</h4>
                        </div>
                    </div>
                    <div class="row flowss g-2 mb-3">
                        <a id="grebtn" href="#" class="col-lg-2 mt-3 prevent-scroll" disabled>
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="flow-icon mt-2">
                                        <img style="height: 19.5px;" src="{{url(('images/Vector (3).png'))}}" alt="">
                                    </div>
                                    <div class="flow-header mt-2">
                                        <h6>Greetings</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a id="forbtn" href="#" class="col-lg-2 mt-3 prevent-scroll" onclick="callForwording()">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="flow-icon mt-2">
                                        <img style="height: 19.5px;" src="{{url(('images/Vector (2).png'))}}" alt="">
                                    </div>
                                    <div class="flow-header mt-2">
                                        <h6>Forward Call</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a id="seqbtn" href="#" class="col-lg-2 mt-3 prevent-scroll" onclick="Sequential()">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="flow-icon mt-2">
                                        <img style="height: 19.5px;" src="{{url(('images/Vector (4).png'))}}" alt="">
                                    </div>
                                    <div class="flow-header mt-2">
                                        <h6>Sequential Flow</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a id="simbtn" href="#" class="col-lg-2 mt-3 prevent-scroll" onclick="Simultaneous()">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="flow-icon mt-2">
                                        <img style="height: 19.5px;" src="{{url(('images/vector.png'))}}" alt="">
                                    </div>
                                    <div class="flow-header mt-2">
                                        <h6>Simultaneous Ring</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a id="menubtn" href="#" class="col-lg-2 mt-3 prevent-scroll" onclick="menu()">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="flow-icon mt-2">
                                        <img style="height: 19.5px;" src="{{url(('images/Vector8.png'))}}" alt="">
                                    </div>
                                    <div class="flow-header mt-2">
                                        <h6>IVR (menu)</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a id="robinbtn" href="#" class="col-lg-2 mt-3 prevent-scroll" onclick="Robin()">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="flow-icon mt-2">
                                        <img style="height: 19.5px;" src="{{url(('images/vector (1).png'))}}" alt="">
                                    </div>
                                    <div class="flow-header mt-2">
                                        <h6>Round Robin</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 d-flex justify-content-center">
                        <div><img style="position: absolute;margin-top:-25px" src="{{url(('images/icon.png'))}}" alt=""></div>
                    </div>
                </div>
            </div>
           
            
        </div>
    </main>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script
  src="https://code.jquery.com/jquery-3.6.4.js"
  integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
  crossorigin="anonymous"></script>
  <script src="{{('js/jquery.toast.min.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#appendButton').click(function() {var html = '<div class="row mt-1 g-3 align-items-center"><div class="col-3"><select class="form-select" aria-label="Default select example">           <option selected>Number</option></select></div><div class="col-6"><input name="sim_numbers[]" type="number" placeholder="15555555678" id="input" class="form-control"></div><div class="col-auto"><button type="button" class="btn btn-danger remove-btn" style="background: none;color:#2A86FF;border:none"><i class="fa-solid fa-x"></i></button></div></div>'; 
            $('#targetElement').append(html);
        });
        // Remove the corresponding element when the "Remove" button is clicked
        $(document).on('click', '.remove-btn', function() {
            $(this).closest('.row').remove();
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#appendButton9').click(function() {var html = '<div class="row mt-1 g-3 align-items-center"><div class="col-3"><select name="press[]" class="form-select" aria-label="Default select example">           <option>Select Key</option><option value="1">Presses 1</option><option value="2">Presses 2</option><option value="3">Presses 3</option><option value="4">Presses 4</option><option value="5">Presses 5</option><option value="6">Presses 6</option><option value="7">Presses 7</option><option value="8">Presses 8</option><option value="9">Presses 9</option><option value="0">Presses 0</option></select></div><div class="col-6"><input name="pressNumber[]" type="number" placeholder="15555555678" id="input" class="form-control"></div><div class="col-auto"><button type="button" class="btn btn-danger remove-btn" style="background: none;color:#2A86FF;border:none"><i class="fa-solid fa-x"></i></button></div></div>'; 
            $('#targetElement9').append(html);
        });
        // Remove the corresponding element when the "Remove" button is clicked
        $(document).on('click', '.remove-btn', function() {
            $(this).closest('.row').remove();
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#appendButton2').click(function() {var html = '<div class="row mt-1 g-3 align-items-center"><div class="col-3"><select class="form-select" aria-label="Default select example">           <option selected>Number</option></select></div><div class="col-6"><input name="rubin_numbers[]" type="number" placeholder="15555555678" id="input" class="form-control"></div><div class="col-auto"><button type="button" class="btn btn-danger remove-btn2" style="background: none;color:#2A86FF;border:none"><i class="fa-solid fa-x"></i></button></div></div>'; 
            $('#targetElement2').append(html);
        });
        // Remove the corresponding element when the "Remove" button is clicked
        $(document).on('click', '.remove-btn2', function() {
            $(this).closest('.row').remove();
        });
    });
</script>
<script>
    function cancelforfunc(){
        var nextStep = document.querySelector('fieldset:nth-child(' + (2) + ')');
        nextStep.classList.add('hidden');
        var cancelfor = document.getElementById('cancelfor');
        cancelfor.classList.add('hidden');
        var show = document.getElementById('happen');
        show.classList.remove('hidden');
        var stepfor = document.getElementById('stepfor');
        stepfor.classList.remove('hidden');
        var show = document.getElementById('happen');
        show.classList.remove('hidden');
        var bn8 = document.getElementById('stepgreeting');
        bn8.disabled = false;
    }
</script>
<script>
    function callForwording(){
        var nextStep = document.querySelector('fieldset:nth-child(' + (2) + ')');
        nextStep.classList.remove('hidden');
        var cancelfor = document.getElementById('cancelfor');
        cancelfor.classList.remove('hidden');
        var show = document.getElementById('happen');
        show.classList.add('hidden');
        var stepfor = document.getElementById('stepfor');
        stepfor.classList.add('hidden');
        var show = document.getElementById('happen');
        show.classList.add('hidden');
        var bn8 = document.getElementById('stepgreeting');
        bn8.disabled = true;
    }
</script>
<script>
    function cancelsimfunction(){
        var nextStep = document.querySelector('fieldset:nth-child(' + (3) + ')');
        nextStep.classList.add('hidden');
        var bn2 = document.getElementById('createBtn3');
        bn2.classList.add('hidden');
        var bn8 = document.getElementById('stepgreeting');
        bn8.disabled = false;
        var stepfor = document.getElementById('stepsim');
        stepfor.classList.remove('hidden');
        var cancelfor = document.getElementById('cancelsim');
        cancelfor.classList.add('hidden');
        var show = document.getElementById('happen');
        show.classList.remove('hidden');
    }
</script>
<script>
    function Simultaneous(){
        var nextStep = document.querySelector('fieldset:nth-child(' + (3) + ')');
        nextStep.classList.remove('hidden');
        var bn2 = document.getElementById('createBtn3');
        bn2.classList.remove('hidden');
        var bn8 = document.getElementById('stepgreeting');
        bn8.disabled = true;
        var stepfor = document.getElementById('stepsim');
        stepfor.classList.add('hidden');
        var cancelfor = document.getElementById('cancelsim');
        cancelfor.classList.remove('hidden');
        var show = document.getElementById('happen');
        show.classList.add('hidden');
    }
</script>
<script>
    function clickmenu(){
        var nextStep = document.querySelector('fieldset:nth-child(' + (4) + ')');
        nextStep.classList.add('hidden');
        var bn8 = document.getElementById('stepgreeting');
        bn8.disabled = false;
        var bn2 = document.getElementById('createBtn4');
        bn2.classList.add('hidden');
        var bn6 = document.getElementById('cancelmenu');
        bn6.classList.add('hidden');
        var bn7 = document.getElementById('stepmenu');
        bn7.classList.add('hidden');
        var show = document.getElementById('happen');
        show.classList.remove('hidden');
    }
</script>
<script>
    function menu(){
        var nextStep = document.querySelector('fieldset:nth-child(' + (4) + ')');
        nextStep.classList.remove('hidden');
        var bn8 = document.getElementById('stepgreeting');
        bn8.disabled = true;
        var bn2 = document.getElementById('createBtn4');
        bn2.classList.remove('hidden');
        var bn6 = document.getElementById('cancelmenu');
        bn6.classList.remove('hidden');
        var bn7 = document.getElementById('stepmenu');
        bn7.classList.add('hidden');
        var show = document.getElementById('happen');
        show.classList.add('hidden');
    }
</script>
<script>
    function cancelrobin(){
        var nextStep = document.querySelector('fieldset:nth-child(' + (5) + ')');
        nextStep.classList.add('hidden');
        var show = document.getElementById('happen');
        show.classList.remove('hidden');
        var cancelrubin = document.getElementById('cancelrubin');
        cancelrubin.classList.add('hidden');
        var bn8 = document.getElementById('stepgreeting');
        bn8.disabled = false;
    }
</script>
<script>
    function Robin(){
        var nextStep = document.querySelector('fieldset:nth-child(' + (5) + ')');
        nextStep.classList.remove('hidden');
        var show = document.getElementById('happen');
        show.classList.add('hidden');
        var cancelrubin = document.getElementById('cancelrubin');
        cancelrubin.classList.remove('hidden');
        var bn8 = document.getElementById('stepgreeting');
        bn8.disabled = true;
    }
</script>
<script>
    function nextStep(step) {
        var currentStep = document.querySelector('fieldset:nth-child(' + step + ')');
        var nextStep = document.querySelector('fieldset:nth-child(' + (step + 1) + ')');
        nextStep.classList.remove('hidden');
        if (step == 4) {
                var happen = document.getElementById('happen');
                happen.classList.add('hidden');
        }
        if (step == 1) {
                var bn2 = document.getElementById('createBtn2');
                bn2.classList.remove('hidden');
        }
        if (step == 2) {
                var bn2 = document.getElementById('createBtn2');
                var bn3 = document.getElementById('createBtn3');
                bn3.classList.remove('hidden');
                bn2.classList.add('hidden');
        }
        if (step == 3) {
                var bn3 = document.getElementById('createBtn3');
                bn3.classList.add('hidden');
                var bn4 = document.getElementById('createBtn4');
                bn4.classList.remove('hidden');
        }
        if (step == 4) {
                var bn4 = document.getElementById('createBtn4');
                bn4.classList.add('hidden');
        }
    }
</script>
<script>
    function textMessage()
    {
    var readbtn = document.getElementById('readbtn');
    readbtn.classList.remove('inactive-btn');
    readbtn.classList.add('active-btn');
    var saybtn = document.getElementById('saybtn');
    saybtn.classList.remove('active-btn');
    saybtn.classList.add('inactive-btn');
    var saydiv = document.getElementById('saydiv');
    saydiv.classList.add('hidden');
    var textdiv = document.getElementById('textdiv');
    textdiv.classList.remove('hidden');
    }
</script>
<script>
    function sayMessage()
    {
    var readbtn = document.getElementById('readbtn');
    readbtn.classList.add('inactive-btn');
    readbtn.classList.remove('active-btn');
    var saybtn = document.getElementById('saybtn');
    saybtn.classList.add('active-btn');
    saybtn.classList.remove('inactive-btn');
    var saydiv = document.getElementById('saydiv');
    saydiv.classList.remove('hidden');
    var textdiv = document.getElementById('textdiv');
    textdiv.classList.add('hidden');
    }
</script>
<script>
    function readMessage2()
    {
    var readbtn = document.getElementById('readbtn2');
    readbtn.classList.remove('inactive-btn');
    readbtn.classList.add('active-btn');
    var saybtn = document.getElementById('saybtn2');
    saybtn.classList.remove('active-btn');
    saybtn.classList.add('inactive-btn');
    var saydiv = document.getElementById('saydiv2');
    saydiv.classList.add('hidden');
    var textdiv = document.getElementById('textdiv2');
    textdiv.classList.remove('hidden');
    }
</script>
<script>
    function sayMessage2()
    {
    var readbtn = document.getElementById('readbtn2');
    readbtn.classList.add('inactive-btn');
    readbtn.classList.remove('active-btn');
    var saybtn = document.getElementById('saybtn2');
    saybtn.classList.add('active-btn');
    saybtn.classList.remove('inactive-btn');
    var saydiv = document.getElementById('saydiv2');
    saydiv.classList.remove('hidden');
    var textdiv = document.getElementById('textdiv2');
    textdiv.classList.add('hidden');
    }
</script>
<script>
    $(document).ready(function() {
        $('#wizardForm').submit(function(e) {
            e.preventDefault(); // Prevent the form from submitting normally

            // Get the form data
            var formData = $(this).serialize();
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // Send an AJAX request
            $.ajax({
                url:"{{ route('makeflow.post') }}",
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response);
                    if (response.status) {
                        $.toast({
                            heading: 'Success!',
                            text: response.message,
                            position: 'top-right',
                            loaderBg:'#878787',
                            icon: 'success',
                            hideAfter: 3500, 
                            stack: 6
                        });
                    }else{
                        $.toast({
                            heading: 'Opps! somthing wents wrong',
                            text: response.message,
                            position: 'top-right',
                            loaderBg:'#ff2a00',
                            icon: 'error',
                            hideAfter: 3500
                        });
                    }
                    console.log(response.message);
                },
                error: function(xhr) {
                    // Handle any errors
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
<script>
    $('.prevent-scroll').on('click', function(e) {
  e.preventDefault(); // Prevent the default behavior
});
</script>
<script src="{{ asset('js/app.js')}}"></script>
</body>
</html>