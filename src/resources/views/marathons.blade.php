
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
  <a href="{{ route('settings') }}" class="nav-link">Settings</a>
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
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Author</th>
                <th scope="col">Goal</th>
                <th scope="col">Due date</th>
                <th scope="col">Details</th>
              </tr>
            </thead>
            <tbody>
              <tr>
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
              </tr>
            </tbody>
          </table>
        </div>
      </main>
   
@endsection
