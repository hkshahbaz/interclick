@extends('layouts.app')
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
    <title>Dashboard | Conversations</title>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://unpkg.com/simplebar@5.3.0/dist/simplebar.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}"/>
    <style>
        .tab-pane2 {
          display: none;
        }
    
        .tab-pane2.active {
          display: block;
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
                <a href="{{url('/dashboard')}}"><i class="fa-solid fa-qrcode"></i><span  class="mx-2">Dashboard</span></a>
            </div>
        </div>
        <div class="sidebar-item">
            <div class="inactive">
                <a href="{{url('/my-number')}}"><i class="fa fa-phone" aria-hidden="true"></i><span  class="mx-2">My Number</span></a>
            </div>
        </div>
        <div class="sidebar-item">
            <div class="inactive">
                <a href="#"><i class="fa fa-line-chart" aria-hidden="true"></i><span class="mx-2">Reports</span></a>
            </div>
        </div>
        <div class="sidebar-item">
            <div class="inactive">
                <a href="#"><i class="fa fa-cog" aria-hidden="true"></i><span style="background:#FFFFFF" class="mx-2">Integrations</span></a>
            </div>
        </div>
        <div class="heading mt-3"><div class="h6">Support</div></div>
        <div class="sidebar-item">
            <div class="inactive">
                <a href="{{url('/tags')}}"><i class="fa-solid fa-tags"></i><span class="mx-2">Tags</span></a>
            </div>
        </div>
        <div class="sidebar-item">
            <div class="active">
                <a href="#"><i class="fa fa-commenting" aria-hidden="true"></i><span style="background:#F5FAFF" class="mx-2">Conversations</span></a>
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
        <h5 class="navbar-brand">Messages</h5>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mx-5 mb-2 mb-lg-0">
                <li class="nav-item ">
                    <a class="nav-link abclink" href="/conversation"><img src="{{ url('images/Message.png') }}" alt=""></a>
                    </li>
                    <li class="nav-item dropdown-center">
                        <a class="nav-link notify" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="#"><img src="{{ url('images/Notification.png') }}" alt=""></a>
                        <ul class="dropdown-menu" style="margin-left:-50px; height:590px; width: 300px">
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
    <main class="wrapper" style="margin-top:-30px">
        <div class="wrapper-body" >
            <div id="alartID">
                @if (session('success'))
                <div class="alert alert-success">
                {{ session('success') }}
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger">
                {{ session('error') }}
                </div>
                @endif
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-3 col-lg-5 g-0">
                        <div class="card">
                            <div style="border-left:none; " class="card-body">
                                <!-- start searchbar -->
                                <div>
                                    <form class="chat-search">
                                        <div class="chat-search-box">                                                        
                                            <div class="input-group">
                                                <button class="btn input-group-text" type="submit">
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </button>
                                                <input type="search" class="form-control" placeholder="Search..." id="top-search">                                                            
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- End searchbar -->
                                <ul class="nav nav-underline mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                      <a style="/* All Conversations */
                                      font-style: normal;
                                      font-weight: 700;
                                      font-size: 12px;
                                      /* primary */
                                      color: #4C499F;
                                      flex: none;
                                      order: 0;
                                      flex-grow: 0;" class="nav-link active" aria-current="page" href="#all">Conversations</a>
                                    </li>
                                    <li class="nav-item">
                                      <a style="/* All Conversations */
                                      font-style: normal;
                                      font-weight: 700;
                                      font-size: 12px;
                                      /* primary */
                                      color: #4C499F;
                                      flex: none;
                                      order: 0;
                                      flex-grow: 0;" class="nav-link" href="#open">Open</a>
                                    </li>
                                    <li class="nav-item">
                                      <a style="/* All Conversations */
                                      font-style: normal;
                                      font-weight: 700;
                                      font-size: 12px;
                                      /* primary */
                                      color: #4C499F;
                                      flex: none;
                                      order: 0;
                                      flex-grow: 0;" class="nav-link" href="#pending">Pending</a>
                                    </li>
                                    <li class="nav-item">
                                      <a style="/* All Conversations */
                                      font-style: normal;
                                      font-weight: 700;
                                      font-size: 12px;
                                      /* primary */
                                      color: #4C499F;
                                      flex: none;
                                      order: 0;
                                      flex-grow: 0;" class="nav-link" href="#close">Closed</a>
                                    </li>
                                  </ul>
                                  <div>
                                    <div class="tab-pane2 active" id="all" data-simplebar style="max-height: 465px;height:465px; bottom:0;">
                                        @foreach ($data as $datas)
                                        @if ($datas["number"] != '+16073095142')
                                        <a href="{{ route('conversation.show', $datas["number"]) }}" class="text-body">
                                          <div class="d-flex align-items-start p-2">
                                              <div class="position-relative">
                                                @if ($datas["status"] == 'open' || $datas["status"] == '')
                                                <span class="user-status bg-success"></span> 
                                                @endif
                                                @if ($datas["status"] == 'pending')
                                                <span class="user-status bg-warning"></span> 
                                                @endif
                                                @if ($datas["status"] == 'close')
                                                <span class="user-status bg-danger"></span> 
                                                @endif
                                                  <img src="{{url('images/Avatar2.png')}}" class="me-2 rounded-circle" height="48" alt="Yarin C" />
                                              </div>
                                              <div class="w-100 overflow-hidden">
                                                  <h5 class="mt-0 mb-0 fs-14">
                                                      <span class="float-end text-muted fs-12">{{$datas["time"]}}</span>
                                                      {{ $datas["number"] }}
                                                  </h5>
                                                  <p class="mt-1 mb-0 text-muted fs-14">
                                                      <span class="w-75">{{$datas["lastmsg"]}}</span>
                                                  </p>
                                              </div>
                                          </div>
                                      </a>
                                        @endif
                                        @endforeach
                                    </div>
                                    <div class="tab-pane2" id="open" data-simplebar style="max-height: 465px; height:465px; bottom:0;"> 
                                        @foreach ($data as $datas)
                                        @if ($datas["status"] == 'open')
                                        <a href="{{ route('conversation.show', $datas["number"]) }}" class="text-body">
                                          <div class="d-flex align-items-start p-2">
                                              <div class="position-relative">
                                                @if ($datas["status"] == 'open' || $datas["status"] == '')
                                                <span class="user-status bg-success"></span> 
                                                @endif
                                                @if ($datas["status"] == 'pending')
                                                <span class="user-status bg-warning"></span> 
                                                @endif
                                                @if ($datas["status"] == 'close')
                                                <span class="user-status bg-danger"></span> 
                                                @endif
                                                  <img src="{{url('images/Avatar2.png')}}" class="me-2 rounded-circle" height="48" alt="Yarin C" />
                                              </div>
                                              <div class="w-100 overflow-hidden">
                                                    <h5 class="mt-0 mb-0 fs-14">
                                                        <span class="float-end text-muted fs-12">{{$datas["time"]}}</span>
                                                        {{ $datas["number"] }}
                                                    </h5>
                                                    <p class="mt-1 mb-0 text-muted fs-14">
                                                        <span class="w-75">{{$datas["lastmsg"]}}</span>
                                                    </p>
                                              </div>
                                          </div>
                                        </a>
                                        @endif
                                        @endforeach
                                    </div>
                                    <div class="tab-pane2" id="pending" data-simplebar style="max-height: 465px;height:465px; bottom:0;"> 
                                        @foreach ($data as $datas)
                                        @if ($datas["status"] == 'pending')
                                        <a href="{{ route('conversation.show', $datas["number"]) }}" class="text-body">
                                          <div class="d-flex align-items-start p-2">
                                              <div class="position-relative">
                                                @if ($datas["status"] == 'open' || $datas["status"] == '')
                                                <span class="user-status bg-success"></span> 
                                                @endif
                                                @if ($datas["status"] == 'pending')
                                                <span class="user-status bg-warning"></span> 
                                                @endif
                                                @if ($datas["status"] == 'close')
                                                <span class="user-status bg-danger"></span> 
                                                @endif
                                                  <img src="{{url('images/Avatar2.png')}}" class="me-2 rounded-circle" height="48" alt="Yarin C" />
                                              </div>
                                              <div class="w-100 overflow-hidden">
                                                <h5 class="mt-0 mb-0 fs-14">
                                                    <span class="float-end text-muted fs-12">{{$datas["time"]}}</span>
                                                    {{ $datas["number"] }}
                                                </h5>
                                                <p class="mt-1 mb-0 text-muted fs-14">
                                                    <span class="w-75">{{$datas["lastmsg"]}}</span>
                                                </p>
                                              </div>
                                          </div>
                                      </a>
                                        @endif
                                        @endforeach</div>
                                    <div class="tab-pane2" id="close" data-simplebar style="max-height: 465px;height:465px; bottom:0;"> 
                                        @foreach ($data as $datas)
                                        @if ($datas["status"] == 'close')
                                        <a href="{{ route('conversation.show', $datas["number"]) }}" class="text-body">
                                          <div class="d-flex align-items-start p-2">
                                              <div class="position-relative">
                                                @if ($datas["status"] == 'open' || $datas["status"] == '')
                                                <span class="user-status bg-success"></span> 
                                                @endif
                                                @if ($datas["status"] == 'pending')
                                                <span class="user-status bg-warning"></span> 
                                                @endif
                                                @if ($datas["status"] == 'close')
                                                <span class="user-status bg-danger"></span> 
                                                @endif
                                                  <img src="{{url('images/Avatar2.png')}}" class="me-2 rounded-circle" height="48" alt="Yarin C" />
                                              </div>
                                              <div class="w-100 overflow-hidden">
                                                    <h5 class="mt-0 mb-0 fs-14">
                                                        <span class="float-end text-muted fs-12">{{$datas["time"]}}</span>
                                                        {{ $datas["number"] }}
                                                    </h5>
                                                    <p class="mt-1 mb-0 text-muted fs-14">
                                                        <span class="w-75">{{$datas["lastmsg"]}}</span>
                                                    </p>
                                              </div>
                                          </div>
                                      </a>
                                        @endif
                                        @endforeach</div>
                                  </div>
                                 
                                <!-- End contact list -->
                            </div> <!-- End card-body -->
                        </div> <!-- End card -->                                             
                    </div> <!-- End col -->
                    <div class="col-xl-6 col-lg-6 g-0">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex pb-2 border-bottom align-items-center">
                                    <img src="{{url('images/Avatar2.png')}}" class="me-2 rounded-circle" height="48" alt="Brandon Smith"/>
                                    {{-- <i class="fa fa-phone me-2" aria-hidden="true"></i> --}}
                                    <div>
                                        <h5 style="
                                            * Jerome Bell */


font-family: 'Poppins';
font-style: normal;
font-weight: 600;
font-size: 14px;
line-height: 22px;
/* identical to box height, or 157% */


color: #000000;


/* Inside auto layout */

flex: none;
order: 0;
flex-grow: 0;" class="mt-0 mb-0 fs-14">Jerome Bell</h5>
                                        <p class="mb-0">{{$current["number"]}}</p>
                                    </div>
                                    <div class="flex-grow-1">
                                        <ul class="list-inline float-end mb-0">
                                            <li class="list-inline-item fs-18 dropdown">
                                                <button style="
            
            
            box-sizing: border-box;
            display: flex;
            flex-direction: row;
            align-items: center;
            padding: 6px 8px;
            gap: 6px;
            
            width: 110px;
            height: 24px;
            
            background: none;
            border: 1px solid #2A86FF;
            color: #1A1D1F;
            border-radius: 4px;
            
            /* Inside auto layout */
            
            flex: none;
            order: 1;
            flex-grow: 0;
                                                 " href="javascript: void(0);" class="dropdown-toggle btn btn-primary" data-bs-toggle="dropdown" aria-expanded="false">
                                                @if ($current["status"] == 'open' || $current["status"] == '')
                                                <span class="user-status2 bg-success"></span> Open
                                                @endif
                                                @if ($current["status"] == 'pending')
                                                <span class="user-status2 bg-warning"></span> Pending
                                                @endif
                                                @if ($current["status"] == 'close')
                                                <span class="user-status2 bg-danger"></span> Closed
                                                @endif
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a onclick="opening({{$current['number'] }})" class="dropdown-item" href="javascript: void(0);"><i class="bi bi-music-note-list fs-18 me-2"></i>Open</a>
                                                    <a onclick="pending({{$current['number'] }})" class="dropdown-item" href="javascript: void(0);"><i class="bi bi-search fs-18 me-2"></i>Pending</a>
                                                    <a onclick="closed({{$current['number'] }})" class="dropdown-item" href="javascript: void(0);"><i class="bi bi-image fs-18 me-2"></i>Closed</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <ul class="conversation-list px-0 h-100" data-simplebar style="max-height: 430px; bottom:0;">
                                        @foreach ($current["message"] as $message)
                                        @if ($message["to"] == $current["number"])
                                        <li class="clearfix odd">
                                            <div class="conversation-text ms-0">
                                                <div class="d-flex justify-content-end">
                                                    <div class="ctext-wrap">
                                                        <p>{{ $message["body"] }}</p>   
                                                    </div>  
                                                </div>                                                          
                                                <p class="text-muted fs-12 mb-0 mt-1">{{ $message['time'] }}<i class="fa fa-check ms-1 text-success" aria-hidden="true"></i></p>
                                            </div>
                                        </li>
                                        @endif
                                        @if ($message["from"] == $current["number"] )
                                        <li class="clearfix mb-1">
                                            <div class="conversation-text ms-0">
                                                <div class="d-flex">
                                                    <div class="ctext-wrap">
                                                        <p>{{ $message["body"] }}</p> 
                                                    </div>
                                                </div>
                                                <p class="text-muted fs-12 mb-0 mt-1">{{ $message['time'] }}</p>
                                            </div> 
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                    <div class="mt-2 bg-light p-3 rounded">
                                        <form class="needs-validation" novalidate="" name="chat-form"
                                            id="chat-form" action="{{ url('/send-sms') }}" method="post">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col mb-2 mb-sm-0">
                                                    <input type="hidden" name="to" value="{{$current["number"] }}">
                                                    <input type="text" name="message" class="form-control border-0" placeholder="Enter your text" required="">
                                                </div>
                                                <div class="col-sm-auto">
                                                    <form id="myForm2" action="/submit" method="POST" enctype="multipart/form-data">
                                                        <input type="file" id="fileInput" name="file" accept="image/*" class="file-input" style="display: none;">
                                                        <button type="submit" class="submit-button" style="display: none;">Submit</button>
                                                      </form>
                                                    <div class="btn-group">
                                                       {{-- <a href="#" class="btn btn-success chat-send" style="color: #2A86FF; padding: 10px 10px; border: none; background: #F5FAFF;"><i class="fa fa-microphone" aria-hidden="true"></i></a> --}}
                                                       {{-- <a href="#" class="btn btn-success chat-send" style="color: #2A86FF; padding: 10px 10px; border: none; background: #F5FAFF;"><i class="fa fa-paperclip" aria-hidden="true"></i></a> --}}
                                                       <a id="openFileButton" href="#" class="btn btn-success chat-send" style="color: #2A86FF; padding: 10px 10px; border: none; background: #F5FAFF;"><i class="fa fa-camera" aria-hidden="true"></i></a>
                                                       <button type="submit" class="btn btn-success chat-send" style="color: #2A86FF; padding: 10px 10px; border: none; background: #F5FAFF;"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                                                    </div>
                                                </div> 
                                            </div> 
                                        </form>
                                    </div> 
                                </div> 
                            </div> <!-- End card-body -->
                        </div> <!-- End card -->
                    </div> <!-- End col -->
                    <div class="col-xl-3 col-lg-5 g-0">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex pb-2 border-bottom align-items-center">
                                    <img src="{{url('images/Avatar2.png')}}" class="me-2 rounded-circle" height="48" alt="Brandon Smith"/>
                                    <div>
                                        <h5 class="mt-0 mb-0 fs-14">{{$current["number"] }}</h5>
                                        <h6 style="color:#2A86FF;" class="mb-0">${{$current["total_cost"]}}</h6>
                                    </div>
                                    @if ($current["attribute"]["campaign"] == 'campaign' && $current["attribute"]["source"] == 'source')
                                    <button type="button"  style="
                                    box-sizing: border-box;
                                    display: flex;
                                    flex-direction: row;
                                    align-items: center;
                                    padding: 6px 8px;
                                    gap: 6px;
                                    background: none;
                                    border: 1px solid #2A86FF;
                                    color: #2A86FF;
                                    border-radius: 4px;
                                    margin-left:20px;
                                    /* Inside auto layout */
                                    
                                    flex: none;
                                    order: 1;
                                    flex-grow: 0;
                                    " class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal2">
           <i class="fa fa-plus" aria-hidden="true"></i> Add tag
          </button>
          @else
          <button type="button"  style="
                                    box-sizing: border-box;
                                    display: flex;
                                    flex-direction: row;
                                    align-items: center;
                                    padding: 6px 8px;
                                    gap: 6px;
                                    background: none;
                                    border: 1px solid #2A86FF;
                                    color: #2A86FF;
                                    border-radius: 4px;
                                    margin-left:40px;
                                    /* Inside auto layout */
                                    
                                    flex: none;
                                    order: 1;
                                    flex-grow: 0;
                                    " class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal3">
           <i class="fa-solid fa-pen-to-square"></i> Edit
          </button>
                                    @endif
                                    
                                </div>
                                 <!-- start contact list -->
                                <div class="pe-2" style="height: 480px">
                                    <h5 class=" mt-3" style="
      font-style: normal;
      font-weight: 700;
      font-size: 12px;
      line-height: 16px;
      /* identical to box height, or 133% */
      
      letter-spacing: -0.01em;
      
      color: #111315;
      flex: none;
      order: 0;
      flex-grow: 0;
      ">Attribution Details</h5>

      <div class="row">
        <div class="col-12">
            <div style="/* Input */
flex-direction: row;
align-items: center;
padding: 12px;
gap: 10px;

flex: none;

/* Neutral/02 */
color: #9A9FA5;
background: #F4F4F4;
border-radius: 4px;

/* Inside auto layout */

flex: none;
order: 1;
flex-grow: 0;">@if(isset($current["attribute"]["campaign"])){{ $current["attribute"]["campaign"]}}@endif
@if($current["attribute"]["campaign"] == '')Campaign @endif
</div>
        </div>
      </div>
      <div class="row mt-2">
        <div class="col-12">
            <div style="/* Input */
flex-direction: row;
align-items: center;
padding: 12px;
gap: 10px;

flex: none;

/* Neutral/02 */
color: #9A9FA5;
background: #F4F4F4;
border-radius: 4px;

/* Inside auto layout */

flex: none;
order: 1;
flex-grow: 0;">@if(isset($current["attribute"])){{ $current["attribute"]["source"]}}@endif
@if( $current["attribute"]["source"] == '')Source @endif
            </div>
        </div>
      </div>
      @if(isset($current["tags"]))
        @foreach ($current["tags"] as $tag)
        <div class="row mt-2">
            <div class="col-auto">
                <div style="/* Input */
    padding: 12px;
    gap: 10px;
    flex: none;
    font-size:12px;
    color: #FFFFFF;
    background: #2A86FF;
    border-radius: 30px;
    
    flex-grow: 0;">@if(isset($tag["name"])){{ $tag["name"]}} | ${{$tag["cost"]}}@endif
                <button onclick="removetag({{$tag['cost']}},{{$current['number'] }})" style="background: none;border:none;color:#FFFFFF;margin-left:20px;"><i class="fa-solid fa-x"></i></button>
                </div>
            </div>
          </div>
        @endforeach
    @endif
    @if ($current["attribute"]["custom_note"] !='')
    <div class="row mt-2">
        <div class="col-12">
            <div style="/* Input */
flex-direction: row;
align-items: center;
padding: 12px;
gap: 10px;
height:100px;
flex: none;

/* Neutral/02 */
color: #9A9FA5;
background: #F4F4F4;
border-radius: 4px;

/* Inside auto layout */

flex: none;
order: 1;
flex-grow: 0;">@if(isset($current["attribute"])){{ $current["attribute"]["custom_note"] }}@endif
</div>
        </div>
      </div>
      @endif
                                      <div class="mt-3">
                                      <button type="button"  style="
                                      box-sizing: border-box;
                                      display: flex;
                                      flex-direction: row;
                                      align-items: center;
                                      padding: 6px 8px;
                                      gap: 6px;
                                      background: none;
                                      border: 1px solid #2A86FF;
                                      color: #2A86FF;
                                      border-radius: 4px;
                                      
                                      /* Inside auto layout */
                                      
                                      flex: none;
                                      order: 1;
                                      flex-grow: 0;
                                      " class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
             @if ($current["attribute"]["custom_note"] =='')
             <i class="fa fa-plus" aria-hidden="true"></i> Add Custom Note
                 
             @else
             <i class="fa-solid fa-pen-to-square"></i> Update Custom Note
             @endif
            </button>
            @if ($current["attribute"]["custom_note"] !='')
            <button type="button"  style="
            /* Auto layout */

flex-direction: row;
align-items: flex-start;
padding: 8px 20px;
gap: 8px;

width: 156px;
height: 40px;

/* danger-color */

background: #E74040;
border: 1px solid #E74040;

/* Inside auto layout */

flex: none;
order: 0;
flex-grow: 0;
            " class="btn btn-primary mt-2" onclick="deletecustom({{$current['number']}})">Delete</button>
            @endif
                                    </div>
                                </div> 
                                <!-- End contact list -->
                            </div> <!-- End card-body -->
                        </div> <!-- End card -->                                             
                    </div> <!-- End col -->
                </div> <!-- End row -->
            </div> <!-- End container -->
        </div>
    </main>
    
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Custom Note</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/costum-note" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <textarea name="note" rows="8" style="width: 100%; font-size: 16px;" name="content" id="content">{{$current["attribute"]["custom_note"]}}</textarea>
                    </div>
                    <input type="hidden" name="user_number" value="{{$current["number"]}}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
      </div>
    </div>
  </div>
    
<!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Add Tags</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/tag" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="exampleFormControlInput9" class="form-label">Campaign</label>
                            <input name="campaign" type="text" class="form-control" id="exampleFormControlInput9">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput9" class="form-label">Source</label>
                            <input name="source" type="text" class="form-control" id="exampleFormControlInput9">
                        </div>
                        @php
                            use App\Models\Tags;
                            $tagsAll = Tags::all();
                        @endphp
                        <div class="mb-3">
                            <select name="tags[]" id="choices-multiple-remove-button" placeholder="Select upto 5 tags" multiple>
                                @if (!@empty($tagsAll))
                                @foreach ($tagsAll as $index => $tag)
                                <option value="{{$tag["id"]}}">{{$tag["name"]}} | ${{$tag["cost"]}}</option>
                                @endforeach
                                @endif
                            </select>
                          </div>
                    </div>
                    <input type="hidden" name="user_number" value="{{$current["number"]}}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  
    
<!-- Modal -->
<div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Update Attribution Details</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/updatetag" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="exampleFormControlInput9" class="form-label">Campaign</label>
                            <input name="campaign" type="text" value="{{$current["attribute"]["campaign"]}}" class="form-control" id="exampleFormControlInput9">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput9" class="form-label">Source</label>
                            <input name="source" type="text" value="{{$current["attribute"]["source"]}}" class="form-control" id="exampleFormControlInput9">
                        </div>
                        <label for="exampleFormControlInput9" class="form-label">Tags</label>
                        <div class="mb-3">
                            <select name="tags[]" id="choices-multiple-remove-button" placeholder="Select up to 5 tags" multiple>
                                @if (!empty($tagsAll))
                                    @foreach ($tagsAll as $tag)
                                        @php
                                            $isSelected = false;
                                        @endphp
                            
                                        @foreach ($current["tags"] as $tag2)
                                            @if ($tag['id'] == $tag2['id'])
                                                @php
                                                    $isSelected = true;
                                                    break;
                                                @endphp
                                            @endif
                                        @endforeach
                            
                                        <option value="{{ $tag['id'] }}" @if ($isSelected) selected @endif>
                                            {{ $tag['name'] }} | ${{ $tag['cost'] }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            
                          </div>
                    </div>
                    <input type="hidden" name="user_number" value="{{$current["number"]}}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  
<script src="https://unpkg.com/simplebar@5.3.0/dist/simplebar.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('js/app.js')}}"></script>
<script>
    function opening(id){
        console.log(id);
        Swal.fire({
  title: 'Confirmation',
  text: "Are you sure want to change status",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Accept'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
       // Make an AJAX request to the server
       $.ajax({
        type:'POST',
           url:"{{ route('edit.post') }}",
           data:{id:id},
        success: function(response) {
            if (response.status) {
                console.log(response);
                window.location.href = "/conversation";
            }
        },
        error: function(error) {
            // Handle any errors that occurred during the request
            console.error(error);
        }
    });
  }
})
    }
</script>
<script>
    function pending(id){
        console.log(id);
        Swal.fire({
  title: 'Confirmation',
  text: "Are you sure want to change status",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Accept'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
       // Make an AJAX request to the server
       $.ajax({
        type:'POST',
           url:"{{ route('edit2.post') }}",
           data:{id:id},
        success: function(response) {
            if (response.status) {
                console.log(response);
                window.location.href = "/conversation";
            }
        },
        error: function(error) {
            // Handle any errors that occurred during the request
            console.error(error);
        }
    });
  }
})
    }
</script>
<script>
    function closed(id){
        console.log(id);
        Swal.fire({
  title: 'Confirmation',
  text: "Are you sure want to change status",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Accept'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
       // Make an AJAX request to the server
       $.ajax({
        type:'POST',
           url:"{{ route('edit3.post') }}",
           data:{id:id},
        success: function(response) {
            if (response.status) {
                console.log(response);
                window.location.href = "/conversation";
            }
        },
        error: function(error) {
            // Handle any errors that occurred during the request
            console.error(error);
        }
    });
  }
})
    }
</script>
<script>
    function deletecustom(id){
        console.log(id);
        Swal.fire({
  title: 'Confirmation',
  text: "Are you sure want to Delete Custom Note",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Accept'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
   
       // Make an AJAX request to the server
       $.ajax({
        type:'POST',
           url:"{{ route('customNote.post') }}",
           data:{id:id},
        success: function(response) {
            if (response.status) {
                console.log(response);
                window.location.href = "/conversation";
            }
        },
        error: function(error) {
            // Handle any errors that occurred during the request
            console.error(error);
        }
    });
  }
})
    }
</script>
<script>
    var myDiv = $("#alartID");
    setTimeout(function() {
  myDiv.html("");
}, 5000);
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
      // Get the navigation links
      const navLinks = document.querySelectorAll("#pills-tab .nav-link");

      // Get the tab panes
      const tabPanes = document.querySelectorAll(".tab-pane2");

      // Handle click event on navigation links
      navLinks.forEach(function(link) {
        link.addEventListener("click", function(event) {
          event.preventDefault();

          // Remove the 'active' class from all navigation links and tab panes
          navLinks.forEach(function(navLink) {
            navLink.classList.remove("active");
          });
          tabPanes.forEach(function(tabPane) {
            tabPane.classList.remove("active");
          });

          // Add the 'active' class to the clicked navigation link and corresponding tab pane
          this.classList.add("active");
          const targetPaneId = this.getAttribute("href").substring(1);
          const targetPane = document.getElementById(targetPaneId);
          targetPane.classList.add("active");
        });
      });
    });
  </script>
  <script>
// Get the button and file input elements
const openFileButton = document.getElementById('openFileButton');
const fileInput = document.getElementById('fileInput');

// Add event listener to open file input when the button is clicked
openFileButton.addEventListener('click', () => {
  fileInput.click();
});

// Add event listener to submit the form when a file is selected
fileInput.addEventListener('change', () => {
  const form = document.getElementById('myForm2');
  
  if (form) {
    form.submit();
  }else{
    console.log("error");
  }
});


  </script>
      <script>
        $(document).ready(function () {
            // Add row
            $('.add-row').click(function () {
                var row = '<div class="row mt-2 g-3 align-items-center">' +
                    '<div class="col-9">' +
                    '<input name="tags[]" type="text" class="form-control" id="exampleFormControlInput9">' +
                    '</div>' +
                    '<div class="col-3 text-end">' +
                    '<button type="button" class="btn btn-danger remove-row">Remove</button>' +
                    '</div>' +
                    '</div>';
                $('#row-container').append(row);
            });

            // Remove row
            $('#row-container').on('click', '.remove-row', function () {
                $(this).closest('.row').remove();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Add event listener to the "Remove" buttons
            $('.remove-button2').click(function() {
                // Remove the corresponding row
                $(this).closest('.mb-3').remove();
            });
        });
    </script>
    <script>
        $(document).ready(function(){
    
    var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
       removeItemButton: true,
     }); 
    
    
});
    </script>
    <script>
        function removetag(id,number){
            console.log(id);
            console.log(number);
            $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
       // Make an AJAX request to the server
       $.ajax({
        type:'POST',
           url:"{{ route('removeTag.post') }}",
           data:{id:id,
            number:number
        },
        success: function(response) {
            if (response.status) {
                console.log(response);
                window.location.href = "/conversation";
            }
        },
        error: function(error) {
            // Handle any errors that occurred during the request
            console.error(error);
        }
    });
        }
    </script>
</body>
</html>