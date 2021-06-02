<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/css/main.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/0.8.2/css/flag-icon.min.css"/>
    <script src="/js/scripts.js"></script>
    @yield('additional_script', '')
    <title>@yield('title')</title>
</head>
<body class="bg-light">

<div class="Body-Wrapper">
    <header class="Header">
      <nav class="Header-Navbar navbar navbar-expand-lg navbar-dark bg-oceanblue fixed-top">
        <div class="container">
          <a href="#" class="navbar-brand">{{ __('Health Tracker App') }}</a>
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarToggler"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a href="{{ route('dashboard', ['lang' => App::getLocale()]) }}" class="nav-link active">{{ __('Home') }}</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('marathons.index', ['lang' => App::getLocale()]) }}" class="nav-link">{{ __('Marathons') }}</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('stats', ['lang' => App::getLocale()]) }}" class="nav-link">{{ __('Stats') }}</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('friends.index', ['lang' => App::getLocale()]) }}" class="nav-link">{{ __('Friends') }}</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('settings.index', ['lang' => App::getLocale()]) }}" class="nav-link"> {{ __('Settings') }}</a>
              </li>

            </ul>
            <div class="nav-item mx-2">
              <a href="{{route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['lang' => "en"]  ))}}">
              <i class="flag-icon flag-icon-us"></i>
              </a>
            </div>
            <div class="nav-item mx-2">
              <a href="{{route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['lang' => "lv"]  ))}}">
              <i class="flag-icon flag-icon-lv"></i>
              </a>
            </div>

            <form method="POST" action="{{ route('logout', ['lang' => App::getLocale()]) }}" >
              @csrf

              <x-dropdown-link :href="route('logout', ['lang' => App::getLocale()])"
                      onclick="event.preventDefault();
                                  this.closest('form').submit();"  class="nav-link active text-white">
                  {{ __('Log out') }}
              </x-dropdown-link>
          </form>


            <div class="text-left text-lg-end">
              @yield('button')


            </div>
          </div>
        </div>
      </nav>
    </header>


    @yield('content')
</div>
<footer class="Body-Footer bg-light">
    <div class="container my-3 text-end text-secondary">
      <span>&copy; 2021 Artjoms Travkovs & Alina Voronko</span>
    </div>
  </footer>
</body>
</html>
