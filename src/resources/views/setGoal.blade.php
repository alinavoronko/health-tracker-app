@extends('layout')
@section('title', 'Create Marathon')
@section('button')
<x-named-route route="stats">
  {{ __('View Stats') }}
</x-named-route>
@endsection
@section('content')


      <main class="Main container bg-white px-4">
        <div class="mb-3">
          <h1 class="display-4 text-center">{{ __('Set a new goal') }}</h1>
        </div>
        <div class="d-flex justify-content-center">
          <div class="col-sm-6 mb-3 mx-sm-0 mx-auto" >
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  </div>
</div>
<div class="Form Form__wide mx-auto px-5 ">

          <form action="{{ route('goal.store', ['lang' => App::getLocale()]) }}" class="text-center" method="POST">

            @csrf

{{-- pass the category as a parameter (from the stats page), set it as "selected" --}}

<div class="d-flex justify-content-center">
<div class="col-sm-6 mb-3 mx-sm-0 mx-auto" id="type">
    <label for="goalType" class="form-label">{{ __('Select goal type') }}:</label>

    <select name="goalType" id="goalType">
      <option value="DAY">{{ __('Daily') }}</option>
      <option value="WEEK">{{ __('Weekly') }}</option>
      <option value="MONTH">{{ __('Monthly') }}</option>
    </select>
</div>
</div>
<div class="d-flex justify-content-center">
            <div class="col-sm-6 mb-3 mx-sm-0 mx-auto">

              <label for="value" class="form-label">{{ __('Value') }}:</label>
              <input type="number" name="value" id="goal" class="form-control" placeholder="10000" />
            </div>

          </div>

          <div class="d-flex justify-content-center">
            <div class="col-sm-6 mb-3 mx-sm-0 mx-auto">
              <input type="submit" class="btn btn-primary mb-3" value="{{ __('Submit') }}" />
            </div>
          </div>
          </form>
        </div>
      </main>
@endsection

