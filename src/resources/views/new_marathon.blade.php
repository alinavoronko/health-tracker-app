@extends('layout')
@section('title', 'Create Marathon')
@section('button')
<x-named-route route="marathons.index">
  {{ __('View Marathons') }}
</x-named-route>
@endsection
@section('content')


      <main role="main" class="Main container bg-white px-4">
        <div class="mb-3">
          <h1 class="display-4 text-center">{{ __('Create Marathon') }}</h1>
        </div>

        <div class="Form Form__wide mx-auto px-5">
          @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
          <form action="{{ route('marathons.store', ['lang' => App::getLocale()]) }}" class="row" method="POST">
            @csrf
            {{-- <div class="col-md-12 mb-3">
              <label for="marathonName" class="form-label">Title</label>
              <input type="text" name="title" id="marathonName" class="form-control" placeholder="Title" />
            </div> --}}
            <div class="col-md-6 mb-3">
              <label for="startDate" class="form-label">{{ __('Start date') }}</label>
              <input type="date" name="startDate" id="startDate" value="{{ old('startDate') }}" class="form-control"/>
            </div>
            <div class="col-md-6 mb-3">
              <label for="goal" class="form-label">{{ __('Step Goal') }}</label>
              <input type="number" name="goal" id="goal" class="form-control" value="{{ old('goal') }}" placeholder="10000" />
            </div>
            <div class="col-md-12 text-center">
              <button type="submit" class="btn btn-primary mb-3">{{ __('Create Marathon') }}</button>
            </div>
            
          </form>
        </div>
      </main>
@endsection

