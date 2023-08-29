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
    <title>Dashboard | Call Flow</title>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" /> 
    <link rel="shortcut icon" href="{{url('images/favicon.png')}}">
    <link rel="stylesheet" href="{{ asset('css/data-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>

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
                <a href="#"><i class="fa fa-phone" aria-hidden="true"></i><span style="background:#F5FAFF" class="mx-2">My Number</span></a>
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
            <div class="row d-flex justify-content-center">
                <div class="col-lg-9 text-center">
                    <h4>Start Call Flow</h4>
                </div>
                <div class="col-lg-6 text-center">
                    <p>Build a new call flow below, or <span style="text-decoration-line: underline;">Duplicate steps from an existing call flow</span></p>
                </div>
            </div>
            <form action="{{ route('pageB') }}" method="POST">
            @csrf
            <div class="row d-flex justify-content-center">
                <div class="col-lg-4">
                        <label style="font-weight: 600;
                        font-size: 15px;
                        line-height: 24px;
                        letter-spacing: -0.01em;
                        color: #000000;" for="flowname" class="form-label">Call Flow Name</label>
                        <input name="input_field" type="text" class="form-control" id="flowname">
                        <div class="row d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary text-center mt-3" style="/* Frame 1000003992 */
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
                            background:#2A86FF;
                            color:#FFFFFF;
                            font-weight: 500;
                            font-size: 15px;
                            /* Inside auto layout */
                            
                            flex: none;
                            order: 2;
                            flex-grow: 0;"><i class="fa-solid fa-plus"></i> Create</button>
                        </div>
                </div>
            </div>
            </form>
            {{-- <div class="card mt-5">
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-lg-12 text-center">
                            <h4 >What would you like to happen?</h4>
                        </div>
                    </div>
                    <div class="row flowss g-2 mb-3">
                        <a href="/createFlow" class="col-lg-2 mt-3">
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
                        <a href="/createFlow" class="col-lg-2 mt-3">
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
                        <a href="createFlow" class="col-lg-2 mt-3">
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
                        <a href="createFlow" class="col-lg-2 mt-3">
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
                        <a href="createFlow" class="col-lg-2 mt-3">
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
                        <a href="createFlow" class="col-lg-2 mt-3">
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
            </div> --}}
           
            
        </div>
    </main>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script
  src="https://code.jquery.com/jquery-3.6.4.js"
  integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
  crossorigin="anonymous"></script>
<script src="{{ asset('js/app.js')}}"></script>
</body>
</html>