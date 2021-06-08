@extends('layout')
@section('title', 'Dashboard')
@section('additional_script')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.0/dist/chart.min.js" integrity="sha256-KP9rTEikFk097YZVFmsYwZdAg4cdGdea8O/V7YZJUxw=" crossorigin="anonymous"></script>
@endsection

@section('button')
<x-named-route route="activities.create">
  {{ __('Add records') }}
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
            {{__('Welcome')}}, {{ Auth::user()->name }} {{ Auth::user()->surname }}!
          </h1>
        </div>

        <div class="mb-3 DashboardSection">
          <h1 class="display-4 text-center mb-3">{{ __('Overview') }}</h1>
          <div class="row justify-content-around">
            <div class="Chart p-2 border col-sm-5 mb-3">
              <canvas id="sleepChart" width="400" height="250"></canvas>
            </div>
            <div class="Chart p-2 border col-sm-5 mb-3">
              <canvas id="stepsChart" width="400" height="250"></canvas>
            </div>
            <div class="Chart p-2 border col-sm-5 mb-3">
              <canvas id="weightChart" width="400" height="250"></canvas>
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
                  <h3 class="text-center mb-3">{{ __('Add friends') }}</h3>

                <div class="form-group">

                  <label for="friendMail">{{ __("Friend's e-mail address") }}</label>
                  <input type="email" class="form-control" name ="friendMail" id="friendMail" aria-describedby="emailHelp" placeholder="{{ __('user@example.com') }}">
                  <small id="emailHelp" class="form-text text-muted"> {{ __("Type your friend's e-mail address to send a friend request.") }}</small>
                </div>
                <div class="text-center my-3">
                <button type="submit" id="submitFReq" class="btn btn-primary">{{ __("Submit") }}</button>
                </div>
                <script>
                  document.addEventListener('DOMContentLoaded', () => {
                      let inp = document.getElementById('friendMail');
                      let sub = document.getElementById('submitFReq');
                      let _csrf=document.querySelector('input[name="_token"]').value;
                      sub.addEventListener('click', (e)=>{
                        e.preventDefault();
                        let email=inp.value;
                        //fetch() sends a request to the server
                        fetch("{{ route('friends.store', ['lang' => App::getLocale()]) }}", {
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
           
              </div>


          
              <div class="Chart col-lg-5 mb-3 p-2">
                <h3 class="text-center mb-3">{{ __('Friends') }}</h3>
                @if (count($friends)==0)
                <div class="text-center"> {{ __('You have not added any friends yet!') }}</div>
               @endif
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
                <h3 class="text-center mb-3">{{ __('Goals') }}</h3>
                @if (count($gls)==0)
                <div class="text-center">{{ __('You have not set any goals yet!') }}</div>
              @endif

                <table class="table">
                  <thead>
                    <tr>
                      
                      <th scope="col">{{ __('Time Period') }}</th>
                      <th scope="col">{{ __('Steps') }}</th>
                      <th scope="col">{{ __('Creator') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                  
                    @foreach($gls as $goal) 
                  <tr>
                
                    <td>{{ __($goal->timePeriod) }}</td>
                    <td>{{$goal->value}}</td>
                    <td>{{$goal->creatorId}}</td>
                  </tr>
                  @endforeach
                    
                  </tbody>
                </table>
              </div>
              <div class="Chart col-lg-5 mb-3 p-2">

                <h3 class="text-center mb-3">{{ __('Friend Requests') }}</h3>
                @if (count($users)==0)
                <div class="text-center">{{ __('You do not have any incoming friend requests!') }}</div>
              @endif
                <ul class="list-group">
                  @foreach($users as $user)
                  <li class="list-group-item d-flex justify-content-between">
                    <span>{{$user->name}} {{$user->surname}}</span>
                    <form action="{{route('friends.request', ['lang' =>App::getLocale(),'friendId' => $user->id])}}" method="POST">
                      @csrf
                      <input type="hidden" name ='type' value="accept"/>
                    <span><button type="submit" id="acceptFReq" class="btn btn-primary">{{ __('Accept') }}</button></span>
                    </form>

                    <form action="{{route('friends.request', ['lang' =>App::getLocale(),'friendId' => $user->id])}}" method="POST">
                      @csrf
                      <input type="hidden" name ='type' value="reject"/>
                    <span><button type="submit" id="rejectFReq" class="btn btn-primary">{{ __('Reject') }}</button></span>
                    </form>
                  </li>
                  @endforeach
                </ul>
              </div>


            </div>
          </div>
        {{-- </div> --}}
      </main>


    <script>
        const sleep = JSON.parse(`{!! $sleep !!}`);
        const steps = JSON.parse(`{!! $steps !!}`);
        const weight = JSON.parse(`{!! $weight !!}`);
        const dates = {
            to: new Date(`{!! $dates['to'] !!}`),
            from: new Date(`{!! $dates['from'] !!}`),
        };

        const dateList = genereateDateList(dates.from, dates.to);

        function genereateDateList(from, to) {
            const list = [];
            for (let dt = new Date(from); dt <= to; dt.setDate(dt.getDate()  + 1)) {
                list.push(new Date(dt));
            }
            return list;
        }

        console.log(sleep, dates);

        window.addEventListener('DOMContentLoaded', (event)=> {
            const sleepChartCtx = document
                .getElementById("sleepChart")
                .getContext("2d");
            const stepsChartCtx = document
                .getElementById("stepsChart")
                .getContext("2d");
            const weightChartCtx = document
                .getElementById("weightChart")
                .getContext("2d");

            const sleepChart = new Chart(sleepChartCtx, {
                type: "bar",
                data: {
                labels: dateList.map(date => date.getDate()),
                datasets: [
                    {
                    label: "{{ __('Sleep') }}",
                    backgroundColor: "rgba(66, 132, 237,0.8)",
                    borderWidth: 1,
                    hoverBackgroundColor: "rgba(20, 95, 217, 1)",
                    hoverBorderColor: "blue",
                    data: dateList.map(date => sleep[date.toISOString().split('T')[0]] || 0),
                    
                    },
                ],
                },
            });

            const stepsChart = new Chart(stepsChartCtx, {
                type: "bar",
                data: {
                labels: dateList.map(date => date.getDate()),
                datasets: [
                    {
                    label: "{{ __('Steps') }}",
                    backgroundColor: "rgba(255, 164, 84,0.8)",
                    hoverBackgroundColor: "rgba(209, 73, 10,0.8)",
                    hoverBorderColor: "orange",
                    data: dateList.map(date => steps[date.toISOString().split('T')[0]] || 0),
                    borderWidth: 1,
                    },
                ],
                },
            });

            const weightChart = new Chart(weightChartCtx, {
                type: "bar",
                data: {
                labels: dateList.map(date => date.getDate()),
                datasets: [
                    {
                    label: "{{ __('Weight') }}",
                    backgroundColor: "rgba(180, 223, 229,0.8)",
                    hoverBackgroundColor: "rgba(4, 166, 189,0.8)",
                    hoverBorderColor: "rgba(4, 166, 189,1)",
                    data: dateList.map(date => weight[date.toISOString().split('T')[0]] || 0),
                    borderWidth: 1,
                    },
                ],
                },
            });
        });
    </script>

 @endsection

