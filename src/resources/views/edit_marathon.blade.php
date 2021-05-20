
@extends('layout')
@section('title', 'Edit Marathon')
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
  Add marathons
</x-named-route>
@endsection
@section('content')


      <main role="main" class="Main container bg-white px-4">
        <div class="mb-3">
          <h1 class="display-4 text-center">Edit marathon</h1>
        </div>

        <div class="Form Form__wide mx-auto px-5">
          <form action="#" class="row" method="POST">
            <div class="col-md-12 mb-3">
              <label for="marathonName" class="form-label">Title</label>
              <input type="text" name="title" id="marathonName" class="form-control" value="Title" />
            </div>
            <div class="col-md-6 mb-3">
              <label for="startDate" class="form-label">Start Date</label>
              <input type="date" name="start_date" id="startDate" class="form-control" value="2021-04-26" />
            </div>
            <div class="col-md-6 mb-3">
              <label for="goal" class="form-label">Steps Goal</label>
              <input type="number" name="goal" id="goal" class="form-control" value="10000" />
            </div>
            <div class="col-md-12 text-end">
              <button type="submit" class="btn btn-danger mb-3">Update Marathon</button>
            </div>
          </form>
        </div>
      </main>
    


@endsection