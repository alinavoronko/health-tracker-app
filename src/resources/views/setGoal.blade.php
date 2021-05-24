@extends('layout')
@section('title', 'Create Marathon')
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
{{-- @section('button') --}}
@section('content')


      <main role="main" class="Main container bg-white px-4">
        <div class="mb-3">
          <h1 class="display-4 text-center">Set a new goal</h1>
        </div>

        <div class="Form Form__wide mx-auto px-5">
          {{-- SET THE ACTION! --}}
          <form action="#" class="row" method="POST">



{{-- pass the category as a parameter (from the stats page), set it as "selected" --}}
<div class="col-md-6 col-lg-12 mb-3" id="category">
    <label for="value" class="form-label">Select goal category:</label>

    <select name="goalCategory" id="goalCategory"  required>
      <option value="steps">Steps</option>
      <option value="sleep">Sleep</option>
      <option value="weight">Weight</option>
    </select>
</div>

<div class="col-md-6 col-lg-12 mb-3" id="tyope">
    <label for="value" class="form-label">Select goal type:</label>

    <select name="goalType" id="goalType"  required>
      <option value="daily">Daily</option>
      <option value="weekly">Weekly</option>
      <option value="monthly">Monthly</option>
    </select>
</div>



            <div class="col-md-6 col-lg-12 mb-3">
                {{-- check according constraints in the store method --}}
              <label for="value" class="form-label">Value:</label>
              <input type="number" name="value" id="goal" class="form-control" placeholder="10000" required />
            </div>




            <div class="col-md-12 text-center">
              <button type="submit" class="btn btn-primary mb-3">Submit</button>
            </div>
          </form>
        </div>
      </main>
@endsection

