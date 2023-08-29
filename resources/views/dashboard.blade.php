{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}
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
    <title>Dashboard</title>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/datatable.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
    <link rel="shortcut icon" href="{{url('images/favicon.png')}}">
    <!-- Morris Charts CSS -->
    <link href="{{asset('css/morris.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<div class="container-fluid">
    <button id="sidebar-toggle" class="collapse-btn"><i class="fa-solid fa-bars"></i></button>
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <a class="navbar-brand" href="#"><img src="{{url('images/logo.png')}}" alt=""></a>
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
            <div class="active">
                <a href="#"><i class="fa-solid fa-qrcode"></i><span style="background:#F5FAFF" class="mx-2">Dashboard</span></a>
            </div>
        </div>
        <div class="sidebar-item">
            <div class="inactive">
                <a href="{{url('/my-number')}}"><i class="fa fa-phone" aria-hidden="true"></i><span class="mx-2">My Number</span></a>
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
        <h5 class="navbar-brand">Dashboard</h5>
            {{-- <form class="d-flex search" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form> --}}
        <div class="collapse navbar-collapse show" id="navbarSupportedContent">
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
                <a class="nav-link mesg" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
            <div class="row">
                <div class="design bg-design-pink"></div>
                <div class="breadcrumb ms-2">
                    <li>Overview</li>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-lg-6">
                    <div class="dispay-card">
                        <div class="card-body">
                            <div class="call-count">
                                81
                            </div>
                            <div class="analytic">
                                <i class="fa fa-caret-up" aria-hidden="true"></i>
                                <span class="mx-2">19.9%</span>
                            </div>
                            <div class="detail-count">
                                <span class="mx-2">Total Calls</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="dispay-card">
                        <div class="card-body">
                            <div class="call-count">
                                43
                            </div>
                            <div class="analytic">
                                <i class="fa fa-caret-up" aria-hidden="true"></i>
                                <span class="mx-2">19.9%</span>
                            </div>
                            <div class="detail-count">
                                <span class="mx-2">Total First Time Callers</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-12 col-xl-12 col-sm-12 col-md-12">
                     <div class="card">
                        <div class="card-body">
                            <div id="morris_extra_line_chart" class="morris-chart"></div>
                        </div>
                     </div>
                 </div>
            </div>
            <div class="row mt-5">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-wrap">
                                <div class="table-responsive">
                                    <table id="datable_1" class="table table-hover display pb-5" >
                                        <thead>
                                            <tr>
                                                <tr>
                                                    <th>Campaign</th>
                                                    <th>Caller</th>
                                                    <th>Status</th>
                                                    <th>Dialed</th>
                                                    <th>Duration</th>
                                                    <th>Time</th>
                                                    <th>Type</th>
                                                    {{-- <th>Source</th> --}}
                                                </tr>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>New Sign Up</td>
                                                <td>(270) 555-0117</td>
                                                <td><span class="badge text-bg-success">Outbound Text</span></td>
                                                <td>(252) 555-0126</td>
                                                <td>10:11:34</td>
                                                <td>1/18 - 11:59pm</td>
                                                <td><i class="fa-regular fa-message"></i></td>
                                                {{-- <td><i class="fa-solid fa-phone"></i></td> --}}
                                                {{-- <td>{{$Data["source"]}}</td> --}}
                                            </tr>
                                            <tr>
                                                <td>New Sign Up</td>
                                                <td>(270) 555-0117</td>
                                                <td><span class="badge text-bg-success">Outbound Text</span></td>
                                                <td>(252) 555-0126</td>
                                                <td>10:11:34</td>
                                                <td>1/18 - 11:59pm</td>
                                                <td><i class="fa-regular fa-message"></i></td>
                                                {{-- <td><i class="fa-solid fa-phone"></i></td> --}}
                                                {{-- <td>{{$Data["source"]}}</td> --}}
                                            </tr>
                                            <tr>
                                                <td>New Sign Up</td>
                                                <td>(270) 555-0117</td>
                                                <td><span class="badge text-bg-success">Outbound Text</span></td>
                                                <td>(252) 555-0126</td>
                                                <td></td>
                                                <td>1/18 - 11:59pm</td>
                                                <td><i class="fa-regular fa-message"></i></td>
                                                {{-- <td><i class="fa-solid fa-phone"></i></td> --}}
                                                {{-- <td>{{$Data["source"]}}</td> --}}
                                            </tr>
                                            <tr>
                                                <td>PPC Landing Page</td>
                                                <td>(270) 555-0117</td>
                                                <td><span class="badge text-bg-primary">Fist Time Caller</span></td>
                                                <td>(252) 555-0126</td>
                                                <td>10:11:34</td>
                                                <td>1/18 - 11:59pm</td>
                                                {{-- <td><i class="fa-regular fa-message"></i></td> --}}
                                                <td><i class="fa-solid fa-phone"></i></td>
                                                {{-- <td>{{$Data["source"]}}</td> --}}
                                            </tr>
                                            <tr>
                                                <td>New Sign Up</td>
                                                <td>(270) 555-0117</td>
                                                <td><span class="badge text-bg-success">Outbound Text</span></td>
                                                <td>(252) 555-0126</td>
                                                <td>10:11:34</td>
                                                <td>1/18 - 11:59pm</td>
                                                <td><i class="fa-regular fa-message"></i></td>
                                                {{-- <td><i class="fa-solid fa-phone"></i></td> --}}
                                                {{-- <td>{{$Data["source"]}}</td> --}}
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>	
                </div>
            </div>
            <!-- /Row -->
        </div>
    </main>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/datatable.min.js')}}"></script>
<script src="{{asset('js/datatable.js')}}"></script>
<script src="{{asset('js/raphael.min.js')}}"></script>
<script src="{{asset('js/morris.min.js')}}"></script>
<script src="{{asset('js/morris-data.js')}}"></script>
<script src="{{ asset('js/app.js')}}"></script>
</body>
</html>