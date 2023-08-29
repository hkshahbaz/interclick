{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ml-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="wripper">
        <!-- As a link -->
        <header class="navbar">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><img src="{{ url('images/logo.png') }}" alt=""></a>
            </div>
        </header>
        <div class="container">
            <div class="row mt-2 d-flex justify-content-center">
                <div class="col-lg-12 mt-5 text-center h-text">
                    <h2>Log In</h2>
                </div>
                <div class="col-lg-12 mt-2 text-center p-text">
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing.</p>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-lg-4 mt-2 log-form">
                    <x-auth-session-status class="mb-4" :status="session('status')" />
                    <form  method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-2">
                          <label for="exampleInputEmail1" class="form-label" >Email address</label>
                          <input type="email" id="email" name="email" :value="old('email')" required autofocus autocomplete="username"  class="form-control" aria-describedby="emailHelp">
                          <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div class="mb-2">
                          <label for="exampleInputPassword1" class="form-label">Password</label>
                          <input type="password" class="form-control" type="password" name="password" required autocomplete="current-password" id="password">
                          <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                        <a href="#" class="btn btn-secondery mt-3"><img src="{{url('images/Google.png') }}" alt=""> Login with Google</a>
                        <div class="forget-text text-center mt-3">
                            <a href="{{url('/forgot-password')}}">Forget Password</a>
                          </div>
                        <div class="forget-text text-center mt-3">
                            <a href="{{url('/register')}}">Register</a>
                        </div>
                      </form>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
<script src="public/js/app.js"></script>
</body>
</html>
