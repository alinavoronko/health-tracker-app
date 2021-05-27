@php
$periods = ['Day' => 'DAY', 'Week' => 'WEEK', 'Month' => 'MONTH'];
$activities = ['Steps' => 'STEPS', 'Weight' => 'WEIGHT', 'Sleep time' => 'SLEEP'];
@endphp

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
  <a href="{{ route('settings.index', ['lang' => App::getLocale()]) }}" class="nav-link">Settings</a>
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
              @foreach ($activities as $name => $param)
              <li class="nav-item">
                  <a href="{{ route('friends.index', ['lang' => App::getLocale(), 'activity' => $param, 'period' => $period]) }}" class="nav-link {{ $activity === $param ? 'active': '' }}">{{ $name }}</a>
              </li>
              @endforeach
            </ul>
            <ul class="nav nav-pills justify-content-center ms-3 mb-3">
                @foreach ($periods as $name => $param)
                <li class="nav-item">
                  <a href="{{ route('friends.index', ['lang' => App::getLocale(), 'activity' => $activity, 'period' => $param]) }}" class="nav-link {{ $period === $param ? 'active': '' }}">{{ $name }}</a>
                </li>
                @endforeach
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
                <th scope="col">Make a trainer</th>
                <th scope="col">Remove</th>
              </tr>
            </thead>
            <!--use blade for loop to loop over friends get a list of them from db-->

            <tbody>
                @foreach ($friends as $friend)
                <tr>
                  <th scope="row">{{ $loop->iteration }}</th>
                  <td>{{ $friend->friend->getFullName() }}</td>
                  <td>{{ $friend->value }}</td>
                  <td>
                      <form action="{{ route('friend.trainer', ['lang' => App::getLocale()]) }}" method="post">
                          @csrf
                          @method('PUT')

                          <input type="hidden" name="friendId" value="{{ $friend->friendId }}" />

                          @if ($friend->isTrainer)
                          <input type="hidden" name="action" value="remove" />
                          <input type="submit" class="btn btn-link p-0" value="Remove a trainer">
                          @else
                          <input type="hidden" name="action" value="make" />
                          <input type="submit" class="btn btn-link p-0" value="Make a trainer">
                          @endif
                      </form>
                  </td>
                  <td>
                    <form action="{{ route('friends.destroy', ['lang' => App::getLocale(), 'friend' => $friend->friendId]) }}" method="post">
                        @csrf
                        @method('DELETE')

                        <input type="submit" class="btn btn-link p-0" value="Remove" />
                    </form>
                  </td>
                </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      </main>




@endsection
