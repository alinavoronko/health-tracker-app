@extends('layout')
@section('title', 'Create Record')
@section('button')
<x-named-route route="dashboard">
 {{ __('Dashboard') }}
</x-named-route>
@endsection

@section('content')


      <main class="Main container bg-white px-4">
        <div class="mb-3">
          <h1 class="display-4 text-center">{{ __('Add a record') }}</h1>
        </div>

        <div class="Form Form__wide mx-auto px-5">

          <form action="{{ route('record.create', ['lang' => App::getLocale()]) }}" class="row" method="POST">
@csrf

<script>
  document.addEventListener('DOMContentLoaded', ()=>{
    const sel = document.getElementById('rtype');
  const inp = document.getElementById('value');
sel.addEventListener('change' , (event)=>
{
  if(sel.value=='STEPS'){
    inp.step=1;

  }
  else{
    inp.step=0.1;
  }


})

  })
  </script>


            <div class="col-md-6 mb-3">
              @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                    <label for="rtype" class="form-label"> {{__('Type') }}:</label>
                    <select class="form-select" aria-label="Default select example" name="rtype" id="rtype" >
                      {{-- <option selected>Type: </option> --}}
                      <option value="STEPS" selected>{{__('Steps') }}</option>
                      <option value="SLEEP">{{__('Sleep') }}</option>
                      <option value="WEIGHT">{{__('Weight') }}</option>
                    </select>

            </select>

            <div class="col-md-6 mb-3 my-2">
              <label for="value" class="form-label">{{__('Value') }}:</label>
              <input type="number" name="value" id="value" class="form-control" placeholder="10000"  />
            </div>

            <div class="col-md-6 mb-3" id="forRecords">

              <label for="date" class="form-label">{{__('Date') }}:</label>
              <input type="date" name="date" id="date" class="form-control"/>
            </div>


            <div class="col-md-12 text-center">
              <button type="submit" class="btn btn-primary mb-3">{{__('Submit') }}</button>
            </div>
          </form>
        </div>
      </main>
@endsection

