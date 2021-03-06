@php
$periods = ['Day' => 'DAY', 'Week' => 'WEEK', 'Month' => 'MONTH'];
$activities = ['Steps' => 'STEPS', 'Weight' => 'WEIGHT', 'Sleep time' => 'SLEEP'];
@endphp

@extends('layout')
@section('title', 'Friends')
@section('button')
<x-named-route route="activities.create">
  {{ __('Add records') }}
</x-named-route>
@endsection
@section('content')



      <main class="Main container bg-white px-4">
        <div class="mb-3">
          <h1 class="text-center">{{ __('Friends') }}</h1>

          <div class="d-flex justify-content-center">
            <ul class="nav nav-pills justify-content-center mb-3 border-end">
              @foreach ($activities as $name => $param)
              <li class="nav-item">
                  <a href="{{ route('friends.index', ['lang' => App::getLocale(), 'activity' => $param, 'period' => $period]) }}" class="nav-link {{ $activity === $param ? 'active': '' }}">{{ __($name) }}</a>
              </li>
              @endforeach
            </ul>
            <ul class="nav nav-pills justify-content-center ms-3 mb-3">
                @foreach ($periods as $name => $param)
                <li class="nav-item">
                  <a href="{{ route('friends.index', ['lang' => App::getLocale(), 'activity' => $activity, 'period' => $param]) }}" class="nav-link {{ $period === $param ? 'active': '' }}">{{ __($name) }}</a>
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
                <th scope="col">{{ __('Name') }}</th>
                <th scope="col">{{ __('Value') }}</th>
                @if ($activity === 'STEPS')
                <th scope="col">{{ __('Set friend goal') }}</th>
                @endif
                <th scope="col">{{ __('Make a trainer') }}</th>
                <th scope="col">{{__('Remove') }}</th>
              </tr>
            </thead>

            <tbody>
                @foreach ($friends as $friend)
                <tr>
                  <th scope="row">{{ $loop->iteration }}</th>
                  <td>{{ $friend->friend->getFullName() }}</td>
                  <td>{{ $friend->value }}</td>
                  @if ($activity === 'STEPS')
                  <td>
                    @if ($friend->isTrainee)
                    <form action="{{ route('friend.goal', ['lang' => App::getLocale()]) }}" class="row" method="post">
                        @csrf
                        <input type="hidden" name="traineeId" value="{{ $friend->friendId }}" />
                        <div class="col-auto">
                            <input type="number" class="form-control form-control-sm" name="goal" />
                        </div>
                        <div class="col-auto">
                            <input type="submit" class="btn btn-secondary btn-sm" value="{{ __('Set goal') }}" />
                        </div>
                    </form>
                    @endif
                  </td>
                  @endif
                  <td>
                      <form action="{{ route('friend.trainer', ['lang' => App::getLocale()]) }}" method="post">
                          @csrf
                          @method('PUT')

                          <input type="hidden" name="friendId" value="{{ $friend->friendId }}" />

                          @if ($friend->isTrainer)
                          <input type="hidden" name="action" value="remove" />
                          <input type="submit" class="btn btn-link p-0" value="{{ __('Remove trainer') }}">
                          @else
                          <input type="hidden" name="action" value="make" />
                          <input type="submit" class="btn btn-link p-0" value="{{ __('Make a trainer') }}">
                          @endif
                      </form>
                  </td>
                  <td>
                    <form action="{{ route('friends.destroy', ['lang' => App::getLocale(), 'friend' => $friend->friendId]) }}" method="post">
                        @csrf
                        @method('DELETE')

                        <input type="submit" class="btn btn-link p-0" value="{{ __('Remove') }}" />
                    </form>
                  </td>
                </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      </main>




@endsection
