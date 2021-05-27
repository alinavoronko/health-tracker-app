@extends('layout')
@section('title', 'Dashboard')
@section('optional')
<li class="nav-item">
  <a href="{{ route('marathons.index') }}" class="nav-link">Marathons</a>
</li>
<li class="nav-item">
  <a href="{{ route('stats') }}" class="nav-link">Stats</a>
</li>
<li class="nav-item">
  <a href="{{ route('friends.index') }}" class="nav-link">Friends</a>
</li>  
<li class="nav-item">
  <a href="{{ route('settings.index') }}" class="nav-link">Settings</a>
</li>
@endsection
{{-- @section('button-link', 'activity.create')
@section('button-text', 'Add records') --}}
@section('button')
<x-named-route route="activities.create">
  Add records
</x-named-route>
@endsection
@section('content')

      <main role="main" class="Main container bg-white px-4">
        <div class="d-flex Welcome w-100 justify-content-center mb-3">
          <img
          src="{{url('/images/neko_sensei.jpg')}}" alt="App logo"
            alt="Avatar for Name Surname"
            class="rounded-circle Welcome-Avatar me-3"
          />
          <h1 class="display-4">
            Welcome, {{ Auth::user()->name }} {{ Auth::user()->surname }}!
          </h1>
        </div>

        <div class="mb-3 DashboardSection">
          <h1 class="display-4 text-center mb-3">Overview</h1>
          <div class="row justify-content-around">
            <div class="Chart p-2 border col-sm-5 mb-3">
              <canvas id="todayChart" width="400" height="250"></canvas>
            </div>
            <div class="Chart p-2 border col-sm-5 mb-3">
              <canvas id="weekChart" width="400" height="250"></canvas>
            </div>
          </div>
        </div>

        <div class="mb-3 DashboardSection">
         
          {{-- <div class="row justify-content-between mx-5"> --}}
            <div class="row justify-content-around">
            {{-- <div class="col-sm-5 mb-3"> --}}
              <div class="Chart border p-2 col-sm-5 mb-3">
               
                {{-- <form method="POST" action="{{ route('friends.store ') }}"> --}}
                  @csrf
                  <h3 class="text-center mb-3">Add a friend</h3>

                <div class="form-group">
             
                  <label for="friendMail">Friend's e-mail address: </label>
                  <input type="email" class="form-control" name ="friendMail" id="friendMail" aria-describedby="emailHelp" placeholder="Enter email">
                  <small id="emailHelp" class="form-text text-muted">Type your friend's e-mail address so send a friend request.</small>
                </div>
                <div class="text-center my-3">
                <button type="submit" id="submitFReq" class="btn btn-primary">Submit</button>
                </div>
                <script>
                  document.addEventListener('DOMContentLoaded', () => {
                      let inp = document.getElementById('friendMail');
                      let sub = document.getElementById('submitFReq');
                      let _csrf=document.querySelector('input[name="_token"]').value;
                      sub.addEventListener('click', (e)=>{
                        e.preventDefault();
                        let email=inp.value;
                        //fetch() send a request to the server
                        fetch("{{ route('friends.store') }}", {
                          method: "POST",
                          headers: {
                                "Content-Type": "application/json",
                                "Accept": "application/json",
                                "X-Requested-With": "XMLHttpRequest",
                                "X-CSRF-Token": _csrf
                                   },
                          body: JSON.stringify({email}),
                          credentials: "same-origin"
                          }) //fetch
                        .then((response)=>{
                          if(response.status==200){
                          alert('Request to '+email+' has been sent!');
                        }
                          else {alert('No user with this e-mail!');}  
                         
                     
                      }); //then


                  });//evList
                });

                 
                  </script>
                {{-- </form> --}}
              </div>
  

            {{-- <div class="col-lg-5 mb-3 p-2"> --}}
              <div class="Chart col-lg-5 mb-3 p-2">
                <h3 class="text-center mb-3">Friends</h3>

                <ul class="list-group">
                  @foreach($friends as $friend)
                  <li class="list-group-item d-flex justify-content-between">
                    <span>{{$friend->name}} {{$friend->surname}}</span>
                    <span>{{$friend->email}}</span>
                 
                  </li>
                  @endforeach
                </ul>
              </div>
            {{-- </div> --}}

            {{-- <div class="col-lg-5 mb-3 p-2"> --}}
              <div class="Chart col-lg-5 mb-3 p-2">
                <h3 class="text-center mb-3">Goals</h3>

                <ul class="list-group">
                  <li class="list-group-item d-flex justify-content-between">
                    <span>Goal 1</span>
                    <span>-2700</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between">
                    <span>Goal 2</span>
                    <span>+500</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between">
                    <span>Goal 3</span>
                    <span>+1000</span>
                  </li>
                </ul>
              </div>
            {{-- </div> --}}
{{-- 
            <div class="col-lg-5 mb-3 p-2"> --}}
              <div class="Chart col-lg-5 mb-3 p-2">
                {{-- <h3 class="text-center mb-3">Marathons</h3>

                <ul class="list-group">
                  <li class="list-group-item d-flex justify-content-between">
                    <span>Goal 1</span>
                    <span>-2700</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between">
                    <span>Goal 2</span>
                    <span>+500</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between">
                    <span>Goal 3</span>
                    <span>+1000</span>
                  </li>
                </ul> --}}

                <h3 class="text-center mb-3">Friend Requests</h3>
                
                <ul class="list-group">
                  @foreach($users as $user)
                  <li class="list-group-item d-flex justify-content-between">
                    <span>{{$user->name}} {{$user->surname}}</span>
                    <span><button type="submit" id="acceptFReq" class="btn btn-primary">Accept</button></span>
                    <span><button type="submit" id="rejectFReq" class="btn btn-primary">Reject</button></span>
                  </li>
                  @endforeach
                </ul>
              </div>


            </div>
          </div>
        {{-- </div> --}}
      </main>
    

 @endsection

 