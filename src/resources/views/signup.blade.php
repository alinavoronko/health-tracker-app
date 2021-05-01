
@extends('layout')
@section('title', 'Singup')
@section('additional_script')
<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"
integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc"
crossorigin="anonymous"
></script>
@endsection
@section('button-text', 'Sign in')
@section('content')
<!--make the signup form fit to page-->
      <main role="main" class="Main container bg-white px-4">
        <div class="SignUp">
          <div class="Form Form__wide mx-auto border rounded py-4 px-5">
            <h3 class="mb-3">Sign up</h3>
            <form class="row" action="#" method="post">
              <div class="col-md-6 mb-3">
                <label for="inputName" class="form-label">Name</label>
                <input
                  required
                  type="text"
                  name="name"
                  id="inputName"
                  class="form-control"
                  placeholder="Name"
                />
              </div>
              <div class="col-md-6 mb-3">
                <label for="inputSurname" class="form-label">Surname</label>
                <input
                  required
                  type="text"
                  name="surname"
                  id="inputSurname"
                  class="form-control"
                  placeholder="Surname"
                />
              </div>
              <div class="col-md-12 mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
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
                    required
                    type="email"
                    name="email"
                    id="email"
                    class="form-control"
                    placeholder="user@example.com"
                    aria-label="Email"
                    aria-describedby="at-addon"
                  />
                </div>
              </div>
              <div class="col-md-12 mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
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
                    required
                    type="password"
                    name="password"
                    id="password"
                    class="form-control"
                    placeholder="Password"
                    aria-label="Password"
                    aria-describedby="key-addon"
                  />
                </div>
              </div>
              <div class="col-md-12 mb-3">
                <label for="confirmPassword" class="form-label"
                  >Confirm Password</label
                >
                <div class="input-group">
                  <span class="input-group-text" id="key-addon2">
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
                    required
                    type="password"
                    name="confirmPassword"
                    id="confirmPassword"
                    class="form-control"
                    placeholder="Confirm Password"
                    aria-label="Confirm Password"
                    aria-describedby="key-addon2"
                  />
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="dateOfBirth" class="form-label"
                  >Date of birth</label
                >
                <input
                  required
                  type="date"
                  id="dateOfBirth"
                  class="form-control"
                  placeholder="mm/dd/yyyy"
                  aria-label="Date of birth"
                />
              </div>
              <div class="col-md-6 mb-3">
                <label for="height" class="form-label">Height</label>
                <div class="input-group">
                  <input
                    required
                    type="number"
                    id="dateOfBirth"
                    class="form-control"
                    placeholder="100"
                    aria-label="Height"
                  />
                  <span class="input-group-text" id="cm-addon">cm</span>
                </div>
              </div>
              <div class="col-md-12 mb-3">
                <label for="city" class="form-label">City</label>
                <select name="city" id="city" class="form-select">
                  <option selected disabled>Choose city</option>
                  <optgroup label="Latvia">
                    <option value="0">Riga</option>
                    <option value="1">Daugavpils</option>
                  </optgroup>
                </select>
              </div>
              <div class="d-grid mt-3 col-md-12">
                <button type="submit" class="btn btn-primary mb-3">
                  Register
                </button>
              </div>
              <div class="mt-2 text-center col-md-12">
                <div>
                  <span>Already have an account? <a href="#">Sign In</a></span>
                </div>
                <div>
                  <a href="#">Forgot password?</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </main>

@endsection
