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
{{-- @section('button') --}}
@section('content')


      <main role="main" class="Main container bg-white px-4">
        <div class="mb-3">
          <h1 class="display-4 text-center">Add a record</h1>
        </div>

        <div class="Form Form__wide mx-auto px-5">
          {{-- SET THE ACCTION! --}}
          <form action="#" class="row" method="POST">

            {{-- <div class="col-md-12 mb-3">
            <label for="vehicle1"> Set as a goal</label>
            <input type="checkbox" id="isGoal" name="isGoal">
            </div> --}}

            {{-- <div class="form-check">
                <label class="form-check-label" for="isGoal">
                    Set as a goal
                  </label>
                <input class="form-check-input" type="checkbox" id="isGoal" name="isGoal">

              </div> --}}


{{-- <script>
const checkbox = document.getElementById('isGoal')

checkbox.addEventListener('change', (event) => {
    var rec = document.getElementById("forRecords");
    var go = document.getElementById("forGoals");
  if (event.currentTarget.checked) {
      go.style.display = "block";
      rec.style.display = "none";
    // filter the RecordType table accordingly so that only record types that have isGoal==1 are displayed in the select
  } 
  else{
      //show all
      rec.style.display = "block";
      go.style.display = "none";
  }
})
    </script> --}}


{{-- For goals only those with isGoal==1 should be --}}
            <div class="col-md-12 mb-3">
                <label for="rtype" class="form-label">Type:</label>
                <select name="rtype_id" id="rtype" required>
                    {{-- @foreach ($rtypes as $rtype)
                        {{-- @if ($rtype->isGoal == true) //
                        <option value="{{ $rtype->id }}">{{ $rtype->name }} </option>
                        {{-- @endif //
                    @endforeach --}}

            </select> 
             {{-- </div>
            <div class="col-md-6 mb-3">
              <label for="goal" class="form-label">Goal:</label>
              <input type="number" name="goal" id="goal" class="form-control" />
            </div> --}}
            <div class="col-md-6 mb-3">
                {{-- check according constraints in the store method --}}
              <label for="value" class="form-label">Value:</label>
              <input type="number" name="value" id="goal" class="form-control" placeholder="10000" required />
            </div>

            <div class="col-md-6 mb-3" id="forRecords">
                
              <label for="date" class="form-label">Date:</label>
              <input type="date" name="date" id="date" class="form-control" required />
            </div>

            <div class="col-md-6 mb-3" id="forGoals" style="display:none;">
                <label for="value" class="form-label">Select goal type:</label>

                <select name="goalType" id="goalType"  required>
                  <option value="daily">Daily</option>
                  <option value="weekly">Weekly</option>
                  <option value="monthly">Monthly</option>
                </select>
            </div>


            <div class="col-md-12 text-center">
              <button type="submit" class="btn btn-primary mb-3">Submit</button>
            </div>
          </form>
        </div>
      </main>
@endsection

