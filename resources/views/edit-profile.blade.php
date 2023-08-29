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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <link rel="shortcut icon" href="{{url('images/favicon.png')}}">
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
            <div class="inactive">
                <a href="{{url('/dashboard')}}"><i class="fa-solid fa-qrcode"></i><span class="mx-2">Dashboard</span></a>
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
        <h5 class="navbar-brand">Profile</h5>
            {{-- <form class="d-flex search" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form> --}}
        <div class="collapse navbar-collapse show" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mx-5 mb-2 mb-lg-0">
                <li class="nav-item ">
                    <a class="nav-link abclink" href="/conversation"><img src="{{ url('images/Message.png') }}" alt=""></a>
                </li>
                <li class="nav-item">
                <a class="nav-link notify" href="#"><img src="{{ url('images/Notification.png') }}" alt=""></a>
                </li>
                <li class="nav-item dropdown-center">
                <a class="nav-link mesg" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="rounded-circle" style="width:40px;height:40px;" src="{{ asset('storage/' . $picture) }}" alt="Profile">
                </a>
                <ul class="dropdown-menu" style="height: 300px">
                    <li><a class="dropdown-item mx-3 mt-3" href="{{url('/profilePage')}}">Profile</a></li>
                    <li><a class="dropdown-item mx-3 active mt-3" href="#">Edit Profile</a></li>
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
            <div class="row d-flex justify-content-center ">
                <div class="col-lg-9 text-center">
                    <h4 style="/* H4 */

                    font-style: normal;
                    font-weight: 600;
                    font-size: 32px;
                    line-height: 40px;
                    /* identical to box height, or 125% */
                    
                    letter-spacing: -0.03em;
                    
                    color: #000000;" class="mb-3">Update Profile</h4>
                </div>
            </div>
          <div class="row d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" value="{{$name}}" id="exampleInputEmail1" aria-describedby="emailHelp">
                              </div>
                              <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Email</label>
                                <input type="email" disabled class="form-control" name="eamil" value="{{$email}}" id="exampleInputPassword1">
                              </div>
                              <div class="mb-3">
                                <label for="exampleInputPassword2" class="form-label">Account Number</label>
                                <input type="number" value="{{$number}}" class="form-control" name="number" id="exampleInputPassword2">
                              </div>
                              <div class="mb-3">
                                <label for="exampleInputPassword3" class="form-label">Account Number</label>
                                <input type="file" name="profile_picture" value="{{$number}}" class="form-control" id="exampleInputPassword3">
                              </div>
                              <button style="background: #2A85FF;
font-style: normal;
font-weight: 700;
font-size: 15px;
line-height: 24px;" type="submit" class="btn btn-primary">Edit Profile</button>
                        </form>
                    </div>
                </div>
            </div>
          </div>
          <div class="row mt-4 d-flex justify-content-center ">
            <div class="col-lg-9 text-center">
                <h4 style="/* H4 */

                font-style: normal;
                font-weight: 600;
                font-size: 32px;
                
                letter-spacing: -0.03em;
                
                color: #000000;" class="mb-3 mt-4">Update Password</h4>
            </div>
        </div>
          <div class="row d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('put')
                    
                            <div>
                                <x-input-label for="current_password" :value="__('Current Password')" />
                                <x-text-input class="form-control" id="current_password" name="current_password" type="password" autocomplete="current-password" />
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                            </div>
                    
                            <div>
                                <x-input-label for="password" :value="__('New Password')" />
                                <x-text-input class="form-control" id="password" name="password" type="password" autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                            </div>
                    
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                <x-text-input class="form-control" id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                            </div>
                    
                            <div class="flex items-center gap-4 mt-2">
                                <x-primary-button style="background: #2A85FF;
                                font-style: normal;
                                font-weight: 700;
                                font-size: 15px;
                                line-height: 24px;">{{ __('Save') }}</x-primary-button>
                    
                                @if (session('status') === 'password-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600"
                                    >{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </div>
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
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script src="{{('js/jquery.toast.min.js')}}"></script>

<script>
$(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
<script src="{{ asset('js/app.js')}}"></script>
</body>
</html>