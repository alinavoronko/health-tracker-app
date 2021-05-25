

@extends('layout')
@section('title', 'Friends')
@section('optional')
<li class="nav-item">
  <a href="{{ route('marathons.index', ['lang' => App::getLocale()]) }}" class="nav-link">Marathons</a>
</li>
<li class="nav-item">
  <a href="{{ route('stats', ['lang' => App::getLocale()]) }}" class="nav-link">Stats</a>
</li>
<li class="nav-item">
  <a href="{{ route('friends.index', ['lang' => App::getLocale()]) }}" class="nav-link">Friends</a>
</li>
<li class="nav-item">
  <a href="{{ route('settings', ['lang' => App::getLocale()]) }}" class="nav-link">Settings</a>
</li>
@endsection
@section('additional_script')
<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"
integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc"
crossorigin="anonymous"></script>
@endsection
  {{-- @section('button')
  <x-named-route route="friends.create">
    Add friends
  </x-named-route>
  @endsection  --}}
@section('content')



      <main role="main" class="Main container bg-white px-4">
        <div class="mb-3">
          <h1 class="text-center">Friends</h1>

          <div class="d-flex justify-content-center">
            <ul class="nav nav-pills justify-content-center mb-3 border-end">
              <li class="nav-item">
                <a href="#" class="nav-link active" aria-current="page">Steps</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">Weight</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">Sleep time</a>
              </li>
            </ul>
            <ul class="nav nav-pills justify-content-center ms-3 mb-3">
              <li class="nav-item">
                <a href="#" class="nav-link active" aria-current="page">Day</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">Week</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">Month</a>
              </li>
            </ul>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Value</th>
                <th scope="col">Updated at</th>
                <th scope="col">Make a trainer</th>
                <th scope="col">Remove</th>
              </tr>
            </thead>
            <!--use blade for loop to loop over friends get a list of them from db-->

            <tbody>
              <tr>
                <th scope="row">1</th>
                <td>Artjoms</td>
                <td>10 000</td>
                <td>24-06-2021</td>
                <td><a href="#">Make a trainer</a></td>
                <td><a href="#">Remove</a></td>
              </tr>
              <tr>
                <th scope="row">2</th>
                <td>Artjoms</td>
                <td>10 000</td>
                <td>24-06-2021</td>
                <td><a href="#">Make a trainer</a></td>
                <td><a href="#">Remove</a></td>
              </tr>
              <tr>
                <th scope="row">3</th>
                <td>Artjoms</td>
                <td>10 000</td>
                <td>24-06-2021</td>
                <td><a href="#">Make a trainer</a></td>
                <td><a href="#">Remove</a></td>
              </tr>
              <tr>
                <th scope="row">4</th>
                <td>Artjoms</td>
                <td>10 000</td>
                <td>24-06-2021</td>
                <td><a href="#">Make a trainer</a></td>
                <td><a href="#">Remove</a></td>
              </tr>
              <tr>
                <th scope="row">5</th>
                <td>Artjoms</td>
                <td>10 000</td>
                <td>24-06-2021</td>
                <td><a href="#">Make a trainer</a></td>
                <td><a href="#">Remove</a></td>
              </tr>
            </tbody>
          </table>
        </div>
      </main>




@endsection
