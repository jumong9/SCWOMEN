<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title','welcome to kium system')</title>
        <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
    </head>
    <body>

        <!-- component -->
    <!-- This is an example component -->
    <div class="h-screen font-sans login bg-cover">
        <div class="container mx-auto h-full flex flex-1 justify-center items-center">
            <div class="w-full max-w-lg">
            <div class="leading-loose">
            <form class="max-w-sm m-4 p-10 bg-white bg-opacity-25 rounded shadow-xl" method="POST" action="{{ route('auth.store') }}">
                    @csrf
                    <p class="text-white font-medium text-center text-lg font-bold">LOGIN</p>
                    <div class="">
                        <label class="block text-sm text-white" for="userid">EMAIL</label>
                        <input class="w-full px-5 py-1 text-gray-700 bg-gray-300 rounded focus:outline-none focus:bg-white" type="text" name="email" id="email"  value="{{ old('email') }}" placeholder="input email address" aria-label="userid" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mt-2">
                        <label class="block  text-sm text-white">PASSWORD</label>
                        <input class="w-full px-5 py-1 text-gray-700 bg-gray-300 rounded focus:outline-none focus:bg-white"
                        type="password" id="password" name="password" placeholder="" arial-label="password" required>
                    </div>

                    <div class="mt-4 items-center flex justify-between">
                        <button class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 hover:bg-gray-800 rounded"
                        type="submit">Enter</button>
                        <a class="inline-block right-0 align-baseline font-bold text-sm text-500 text-white hover:text-red-400"
                        href="#">ID, Password 찾기</a>
                    </div>
                    <div class="text-center">
                        <a class="inline-block right-0 align-baseline font-light text-sm text-500 hover:text-red-400">
                            서초여성 키움교육 센터
                        </a>
                    </div>

                </form>

            </div>
            </div>
        </div>
    </div>
    <style>
      .login{
      /*
        background: url('https://tailwindadmin.netlify.app/dist/images/login-new.jpeg');
      */
      background: url('http://bit.ly/2gPLxZ4');
      background-repeat: no-repeat;
      background-size: cover;
    }
    </style>

    </body>
</html>
