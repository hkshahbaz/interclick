{{-- <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
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
    <title>Register</title>
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
                    <h2>Register</h2>
                </div>
                <div class="col-lg-12 mt-2 text-center p-text">
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing.</p>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-lg-4 mt-2 log-form">
                    <x-auth-session-status class="mb-4" :status="session('status')" />
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-2">
                          <label for="exampleInputEmail1" class="form-label" >Name</label>
                          <input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" >
                          <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="mb-2">
                          <label for="exampleInputEmail1" class="form-label" >Email address</label>
                          <input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" >
                          <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div class="mb-2">
                          <label for="password" :value="__('Password')" class="form-label">Password</label>
                          <input type="password" class="form-control" type="password" name="password" required autocomplete="new-password">
                          <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="mb-2">
                          <label for="password" :value="__('Password')" class="form-label">Conform Password</label>
                          <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password">
                          <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                        <div class="forget-text text-center mt-3">
                            <a href="{{url('/')}}">Already Register? Back to login</a>
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