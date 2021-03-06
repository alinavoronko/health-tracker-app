<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ __('Login') }}</title>
    <link rel="stylesheet" type="text/css" href="/css/main.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/0.8.2/css/flag-icon.min.css"/>
    <script src="/js/scripts.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"
      integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc"
      crossorigin="anonymous"
    ></script>
  </head>
  <body class="bg-light">


    <div class="Body-Wrapper">


      <main class="Main container bg-white px-4 d-flex justify-content-center align-items-center">

        <div class="Login h-100">
          <!--split the form into 2 parts:
            *logo and our moto on the left side,
            *input fields on the right side-->
          <div class="Form mx-auto my-auto border rounded py-4 px-5 text-center">
            <h3 class="my-2 ">{{__('Log in to your account')}}</h3>
            <div class="text-center my-2">

              <a href="{{route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['lang' => "en"]  ))}}">
              <i class="flag-icon flag-icon-us px-2"></i>
              </a>

              <a href="{{route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['lang' => "lv"]  ))}}">
              <i class="flag-icon flag-icon-lv px-2"></i>
              </a>

          </div>
            <x-auth-validation-errors class="mb-4 alert alert-danger" :errors="$errors"/>
              <form method="POST" action="{{ route('login.post', ['lang' => App::getLocale()]) }}">
                @csrf
              <div class="input-group mb-3">
                <span class="input-group-text" id="at-addon">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-at"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M13.106 7.222c0-2.967-2.249-5.032-5.482-5.032-3.35 0-5.646 2.318-5.646 5.702 0 3.493 2.235 5.708 5.762 5.708.862 0 1.689-.123 2.304-.335v-.862c-.43.199-1.354.328-2.29.328-2.926 0-4.813-1.88-4.813-4.798 0-2.844 1.921-4.881 4.594-4.881 2.735 0 4.608 1.688 4.608 4.156 0 1.682-.554 2.769-1.416 2.769-.492 0-.772-.28-.772-.76V5.206H8.923v.834h-.11c-.266-.595-.881-.964-1.6-.964-1.4 0-2.378 1.162-2.378 2.823 0 1.737.957 2.906 2.379 2.906.8 0 1.415-.39 1.709-1.087h.11c.081.67.703 1.148 1.503 1.148 1.572 0 2.57-1.415 2.57-3.643zm-7.177.704c0-1.197.54-1.907 1.456-1.907.93 0 1.524.738 1.524 1.907S8.308 9.84 7.371 9.84c-.895 0-1.442-.725-1.442-1.914z"
                    />
                  </svg>
                </span>
                <input
                  {{-- required --}}
                  type="email"
                  name="email"
                  id="email"
                  class="form-control"
                  placeholder="{{ __('user@example.com') }}"
                  aria-label="Email"
                  aria-describedby="at-addon"
                />
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text" id="key-addon">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-key-fill"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2zM2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"
                    />
                  </svg>
                </span>
                <input
                  {{-- required --}}
                  type="password"
                  name="password"
                  id="password"
                  class="form-control"
                  placeholder="{{ __('Password') }}"
                  aria-label="Password"
                  aria-describedby="key-addon"
                />
              </div>
              <div class="d-grid mt-3">
                <button type="submit" class="btn btn-primary mb-3">
                  {{__('Login')}}
                </button>
              </div>
              <div class="mt-2 text-center">
                <div>
                  <span>{{__("Don't have an account?")}} <a href="{{ route('register', ['lang' => App::getLocale()]) }}">{{__('Sign Up')}}</a></span>
                </div>
                {{-- <div>
                  <a href="{{ route('password.request', ['lang' => App::getLocale()]) }}">{{__('Forgot password?')}}</a>
                </div> --}}
              </div>
            </form>
          </div>
        </div>
      </main>
    </div>


  </body>
</html>
