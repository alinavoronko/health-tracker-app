@extends('layout')
@section('title', "{{ __('Join Marathon') }} ")
@section('additional_script')
<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"
integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc"
crossorigin="anonymous"
></script>
@endsection
@section('button')
<x-named-route route="marathons.index">
  {{ __('View marathons') }}
</x-named-route>
@endsection
@section('content')




      <main role="main" class="Main container bg-white px-4">
        <div class="mb-3">
          <h1 class="display-4 text-center">{{ __('Information about marathon') }}</h1>
          <h3 class="text-center">{{ __('Goal') }}: {{ $marathon->goal }} {{ __('steps') }}</h3>
        </div>

        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>{{ __('Rank') }}</th>
                <th>{{ __('Participant Name') }}</th>
                <th>{{ __('Step Count') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach($participantInfo as $part)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$part->name}} {{$part->surname}}</td>
                <td>{{$part->stepCount}}</td>
                
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @if (!in_array($user, $marathon->participants))
        <form action="{{ route('marathons.join', ['lang' => App::getLocale(), 'user'=>$user, 'marathon'=>$marathon->id]) }}" method="POST">
          @csrf
        <input type="submit" class='btn btn-primary' value="{{ __('Join') }}"/>
        </form>
        @endif
      </main>

@endsection
