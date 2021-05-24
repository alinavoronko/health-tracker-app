
@extends('layout')
@section('title', 'My Marathons')
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
@section('additional_script')
<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"
integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc"
crossorigin="anonymous"
></script>
@endsection

@section('button')
<x-named-route route="marathons.create">
  Create new
</x-named-route>
@endsection

@section('content')

 
      <main role="main" class="Main container bg-white px-4">
        <div class="mb-3">
          <h1 class="text-center">My Marathons</h1>
        </div>
 
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>

                <th scope="col">Author</th>
                <th scope="col">Goal</th>
                <th scope="col">Start date </th>
                <th scope="col">Due date</th>
                <th scope="col">Details</th>
              </tr>
            </thead>
            <tbody>
              {{-- [
                "startDate" => "2021-05-19T18:38:03"
                "goal" => 10000
                "creatorId" => 3
                "participants" => null
                "id" => 3
                "createdAt" => "2021-05-24T18:38:03"
                "updatedAt" => "2021-05-24T18:38:03"
              ] --}}
              @foreach($usrMar as $mar)
              <tr>
                <td>{{$mar->authName}} {{$mar->authSurname}}</td>
                <td>{{$mar->goal}}</td>
                <td>{{$mar->startDate}}</td>
                <td>{{$mar->endDate}}</td>
                <td><a href="#">See more</a></td>

              </tr>
             
              @endforeach
              
              {{-- <tr>
                <th scope="row">1</th>
                <td>Test marathon 1</td>
                <td>Artjoms</td>
                <td>10 000</td>
                <td>24-06-2021</td>
                <td><a href="#">Details</a></td>
              </tr>
              <tr>

                
                <th scope="row">2</th>
                <td>Test marathon 2</td>
                <td>Artjoms</td>
                <td>10 000</td>
                <td>24-06-2021</td>
                <td><a href="#">Details</a></td>
              </tr>
              <tr>
                <th scope="row">3</th>
                <td>Test marathon 3</td>
                <td>Artjoms</td>
                <td>10 000</td>
                <td>24-06-2021</td>
                <td><a href="#">Details</a></td>
              </tr>
              <tr>
                <th scope="row">4</th>
                <td>Test marathon 4</td>
                <td>Artjoms</td>
                <td>10 000</td>
                <td>24-06-2021</td>
                <td><a href="#">Details</a></td>
              </tr>
              <tr>
                <th scope="row">5</th>
                <td>Test marathon 5</td>
                <td>Artjoms</td>
                <td>10 000</td>
                <td>24-06-2021</td>
                <td><a href="#">Details</a></td>
              </tr> --}}
            </tbody>
          </table>
        </div>
      </main>
   
@endsection
