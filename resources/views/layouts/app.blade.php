<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <link href="https://cdn.bootcss.com/bulma/0.6.2/css/bulma.css" rel="stylesheet">
</head>
<style>
body{
    background-color:#e9eef3;
}
nav{
    box-shadow:0 2px 3px rgba(10, 10, 10, 0.1), 0 0 0 1px rgba(10, 10, 10, 0.1);
}
.container{
    padding:0 20px;
    height:100vh;
}
</style>
<body>
<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="https://bulma.io">
      <img src="/img/logo-s.png" alt="NotesRepo" width="112" height="28">
    </a>
    @guest
    <a class="navbar-item" href="{{ route('login') }}">登陆</a>
    <a class="navbar-item" href="{{ route('register') }}">注册</a>
    @else
    <a class="navbar-item" href="{{ route('logout') }}"
        onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
        Logout
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
    @endguest
  </div>
</nav>
<div class="container">
    @yield('content')
</div>
    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}"></script> -->
</body>
</html>
