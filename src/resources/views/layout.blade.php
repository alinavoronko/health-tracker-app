<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/css/main.css" />
    <script src="/js/scripts.js"></script>
    @yield('additional_script', '')
    <title>@yield('title')</title>
</head>
<body class="bg-light">

<div class="Body-Wrapper">
    <header class="Header">
      <nav class="Header-Navbar navbar navbar-expand-lg navbar-dark bg-oceanblue fixed-top">
        <div class="container">
          <a href="#" class="navbar-brand">Health Tracker App</a>
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
                <a href="#" class="nav-link active">Home</a>
              </li>
              @yield('optional', '')

            </ul>
            <form method="POST" action="{{ route('logout') }}" >
              @csrf

              <x-dropdown-link :href="route('logout')"
                      onclick="event.preventDefault();
                                  this.closest('form').submit();"  class="nav-link active text-white">
                  {{ __('Log out') }}
              </x-dropdown-link>
          </form>


            <div class="text-end">
              <button class="btn btn-warning" type="button">@yield('button-text')</button>
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
