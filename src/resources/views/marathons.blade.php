
@extends('layout')
@section('title', 'My Marathons')
@section('button')
<x-named-route route="marathons.create">
  {{ __('Create new') }}
</x-named-route>
@endsection

@section('content')


      <main class="Main container bg-white px-4">
        <div class="mb-3">
          <h1 class="text-center">{{ __('My Marathons') }} </h1>
        </div>

        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>

                <th scope="col">{{ __('Creator') }}</th>
                <th scope="col">{{ __('Goal') }}</th>
                <th scope="col">{{ __('Start date') }} </th>
                <th scope="col">{{ __('End date') }}</th>
                <th scope="col">{{ __('Details') }}</th>
              </tr>
            </thead>
            <tbody id='table'>

              @foreach($usrMar as $mar)
              <tr>
                <td>{{$mar->authName}} {{$mar->authSurname}}</td>
                <td>{{$mar->goal}}</td>
                <td>{{$mar->startDate}}</td>
                <td>{{$mar->endDate}}</td>
                <td><a href="{{ route('marathons.show', ['marathon' => $mar->id, 'lang' => App::getLocale()]) }}">{{ __('View') }}</a></td>

              </tr>

              @endforeach



            </tbody>
          </table>
        </div>
      </main>

@endsection
