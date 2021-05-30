@extends('layout')
@section('title', 'Create Marathon')
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
  <a href="{{ route('settings.index', ['lang' => App::getLocale()]) }}" class="nav-link">Settings</a>
</li>
@endsection
@section('additional_script')
<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"
integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc"
crossorigin="anonymous"
></script>
@endsection
{{-- @section('button') --}}
@section('content')


      <main role="main" class="Main container bg-white px-4">
        <div class="mb-3">
          <h1 class="display-4 text-center">Set a new goal</h1>
        </div>

<div class="Form Form__wide mx-auto px-5">
          {{-- SET THE ACTION! --}}
          <form action="{{ route('goal.store', ['lang' => App::getLocale()]) }}" class="row" method="POST">

            @csrf

{{-- pass the category as a parameter (from the stats page), set it as "selected" --}}
<div class="col-md-6 col-lg-12 mb-3" id="category">
    {{-- <label for="value" class="form-label">Select goal category:</label>

    <select name="goalCategory" id="goalCategory"  required>
      <option value="steps">Steps</option>
      <option value="sleep">Sleep</option>
      <option value="weight">Weight</option>
    </select> --}}
</div>

<div class="col-md-6 col-lg-12 mb-3" id="type">
    <label for="goalType" class="form-label">Select goal type:</label>

    <select name="goalType" id="goalType"  required>
      <option value="DAY">Daily</option>
      <option value="WEEK">Weekly</option>
      <option value="MONTH">Monthly</option>
    </select>
</div>



            <div class="col-md-6 col-lg-12 mb-3">
                {{-- check according constraints in the store method --}}
              <label for="value" class="form-label">Value:</label>
              <input type="number" name="value" id="goal" class="form-control" placeholder="10000" required />
            </div>




            <div class="col-md-12 text-center">
              <input type="submit" class="btn btn-primary mb-3" value="Submit" />
            </div>
          </form>
        </div>
      </main>
@endsection

