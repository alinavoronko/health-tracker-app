@extends('layout')
@section('title', 'Settings')
@section('button')
<x-named-route route="activities.create">
  {{ __('Add records') }}
</x-named-route>
@endsection
@section('content')


      <main role="main" class="Main container bg-white px-4">
        <div>
          <h1 class="display-4 text-center">{{ __('Settings') }}</h1>
        </div>

        <div class="d-flex align-items-start mx-5">
          <div
            class="nav flex-column nav-pills me-3"
            id="settings-menu"
            role="tablist"
            aria-orientation="vertical"
          >
            <button
              class="nav-link active"
              id="settings-menu-profile-tab"
              data-bs-toggle="pill"
              data-bs-target="#settings-menu-profile"
              role="tab"
              aria-controls="settings-menu-profile"
              aria-selected="true"
            >
            {{ __('Profile') }}
            </button>
            <button
              class="nav-link"
              id="settings-menu-security-tab"
              data-bs-toggle="pill"
              data-bs-target="#settings-menu-security"
              role="tab"
              aria-controls="settings-menu-security"
              aria-selected="false"
            >
            {{ __('Security') }}
            </button>

            <button
              class="nav-link"
              id="settings-menu-gfit-tab"
              data-bs-toggle="pill"
              data-bs-target="#settings-menu-gfit"
              role="tab"
              aria-controls="settings-menu-gfit"
              aria-selected="false"
            >
              Google Fit
            </button>
          </div>
          <div class="tab-content" id="settings-menu-content">
            <div
              class="tab-pane fade show active p-3"
              id="settings-menu-profile"
              role="tabpanel"
              aria-labelledby="settings-menu-profile-tab"
            >
              <h4>{{ __('Profile settings') }}</h4>
              
              <form class="row" action="{{ route('settings.store', ['lang' => App::getLocale()]) }}" method="post">
                @csrf
                <div class="col-md-12 mb-3">
                  <label for="inputName" class="form-label">{{ __('Name') }}</label>
                  <input
                    type="text"
                    name="name"
                    id="inputName"
                    class="form-control"
                    placeholder="{{ __('Name') }}"
                  />
                  @error('name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-12 mb-3">
                  <label for="inputSurname" class="form-label">{{ __('Surname') }}</label>
                  <input
                    {{-- required --}}
                    type="text"
                    name="surname"
                    id="inputSurname"
                    class="form-control"
                    placeholder="{{ __('Surname') }}"
                  />
                  @error('surname')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-6 mb-3">
                  <label for="dateOfBirth" class="form-label"
                    >{{ __('Date of birth') }}</label
                  >
                  <input
                  
                    type="date"
                    name="dob"
                    id="dateOfBirth"
                    class="form-control"
                    placeholder="{{ __('mm/dd/yyyy') }}"
                    aria-label="Date of birth"
                  />
                  @error('dob')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-6 mb-3">
                  <label for="height" class="form-label">{{ __('Height') }}</label>
                  <div class="input-group">
                    <input
                      
                      type="number"
                      name="height"
                      id="Height"
                      class="form-control"
                      placeholder="100"
                      aria-label="Height"
                    />
                    <span class="input-group-text" id="cm-addon">cm</span>
                  </div>
                  @error('height')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-12 mb-3">
                  <label for="country" class="form-label">{{ __('Country') }}</label>
                  <select name="country" id="country" class="form-select">
                    @foreach ($countries as $country)
                    <option value="{{$country->id}}" {{ ($country->id==$userCountry->id) ? 'selected' : '' }}>{{$country->name}}</option>
                    @endforeach
                  </select>
                </div>
                <script>
                  document.addEventListener('DOMContentLoaded', ()=>{
                  const counSel=document.getElementById('country');
                  const statSel=document.getElementById('state');
                  const citySel=document.getElementById('city');
                  counSel.addEventListener('change', async()=> {
//delete children
                      statSel.innerHTML='';
                      citySel.innerHTML='';
                      let country=counSel.value;
                      let resp=await fetch(`/country/${country}`);
                      let statelist=await resp.json();
                     
                      let contents='';
                      statelist.forEach(state => {
                        contents+=`<option value="${state.id}" >${state.name}</option>`
                      });
                      statSel.innerHTML=contents;
                     
                  })//counSel
                  
                  
                  statSel.addEventListener('change', async()=> {
//delete children
                      
                      citySel.innerHTML='';
                      let state=statSel.value;
                      let resp=await fetch(`/state/${state}`);
                      let citylist=await resp.json();
                      
                      let contents='';
                     citylist.forEach(city=> {
                        contents+=`<option value="${city.id}" >${city.name}</option>`
                      });
                      citySel.innerHTML=contents;
                     
                  })//counSel

                })//DOMContentLoaded
                  </script>
                <div class="col-md-12 mb-3">
                  <label for="state" class="form-label">{{ __('State') }}</label>
                  <select name="state" id="state" class="form-select">
                    @foreach ($states as $state)
                    
                    <option value="{{$state->id}}" {{ ($state->id==$userState->id) ? 'selected' : '' }}>{{$state->name}}</option>
                    @endforeach
                  </select>
                </div>


                <div class="col-md-12 mb-3">
                  <label for="city" class="form-label">{{ __('City') }}</label>
                  <select name="city" id="city" class="form-select">
                  
                    @foreach ($cities as $city)
                    <option value="{{$city->id}}" {{ ($city->id==$userCity->id) ? 'selected' : '' }}>{{$city->name}}</option>
                    @endforeach
                  </select>
                  @error('city')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                  @enderror
                </div>
                <div class="text-end mt-3 col-md-12">
                  <button type="submit" class="btn btn-danger mb-3">
                    {{ __('Update') }}
                  </button>
                </div>
              </form>
            </div>
            <div
              class="tab-pane fade p-3"
              id="settings-menu-security"
              role="tabpanel"
              aria-labelledby="settings-menu-security-tab"
            >
              <h4> {{ __('Security settings') }}</h4>
               @if ($errors->any())
               <div class="alert alert-danger mt-2">
               {{session('errors')->first('notMatchingErr')}}
               </div>
               
          @endif 
             

                <form class="row" action="{{ route('pass.change', ['lang' => App::getLocale()]) }}" method="post">
                  @csrf                

              
                <div class="col-md-12 mb-3">
                  {{-- <label for="email" class="form-label">Email</label>
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
                </div>--}}
                <div class="col-md-12 mb-3">
                  <label for="oldPassword" class="form-label">{{ __('Old Password') }}</label>
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
                     
                      type="password"
                      name="oldPassword"
                      id="oldPassword"
                      class="form-control"
                      placeholder="{{ __('Old Password') }}"
                      aria-label="Password"
                      aria-describedby="key-addon"
                    />
                  </div>
                  @error('oldPassword')
                  <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                </div>
                <div class="col-md-12 mb-3">
                  <label for="password" class="form-label">{{ __('New Password') }}</label>
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
                     
                      type="password"
                      name="password"
                      id="password"
                      class="form-control"
                      placeholder="{{ __('New Password') }}"
                      aria-label="Password"
                      aria-describedby="key-addon"
                    />
                  </div>
                  @error('password')
                  <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                </div>
                <div class="col-md-12 mb-3">
                  <label for="confirmPassword" class="form-label">
                    {{ __('Confirm Password') }}
                  </label>
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
                      
                      type="password"
                      name="confirmPassword"
                      id="confirmPassword"
                      class="form-control"
                      placeholder="{{ __('New Password') }}"
                      aria-label="Confirm Password"
                      aria-describedby="key-addon2"
                    />
                   
                  </div>
                  @error('confirmPassword')
                  <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                </div>
                <div class="text-end mt-3 col-md-12">
                  <button type="submit" class="btn btn-lightblue mb-3">
                    {{ __('Update') }}
                  </button>
                  {{-- <button type="submit" class="btn btn-lightblue mb-3">
                    Update Email
                  </button>
                  <button type="submit" class="btn btn-oceanblue mb-3">
                    Update Password
                  </button> --}}
                </div>
              </form>
            </div>
          </div>
            <div
              class="tab-pane fade p-3"
              id="settings-menu-gfit"
              role="tabpanel"
              aria-labelledby="settings-menu-gfit-tab"
            >
            @if (!!$user->googleAuth)
            Google Fit {{ __('Settings') }}
            @else
            <a href="{{ $authUrl }}" class="btn btn-primary">{{ __('Authorize') }}</a>
            @endif
            </div>
          </div>
        </div>

      </main>
@endsection
