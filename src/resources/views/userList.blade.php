@extends('layout')
@section('title', 'User list')

{{-- @section('button')
<x-named-route route="activities.create">
  Add records
</x-named-route>
@endsection --}}
@section('content')

@if (count($users) == 0)
    <p class="red">{{ __('There are no users in the database!') }}</p>
@else

<main class="Main container bg-white px-4">
    <div class="mb-3">
      <h1 class="text-center">{{ __('All Users') }}</h1>


    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">{{ __('Name') }} {{ __('Surname') }}</th>
            <th scope="col">{{ __('Email') }}</th>
            <th scope="col">{{ __('Action') }}</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}  {{ $user->surname }}</td>
                <td>{{ $user->email }}</td>
                <td>

                    <form action="{{ action([App\Http\Controllers\AdminController::class, 'block'], ['id' =>$user->id, 'blocked'=>$user->isBlocked ? 'unblock' : 'block', 'lang' => App::getLocale()]) }}" method="post">
                        @csrf


                        <input type="submit" value="{{ $user->isBlocked ?  __("Unblock") :  __("Block")  }}" id="block" />
                        {{-- <input type="submit" value="{{ $user->isBlocked ? 'Unblock' : 'Block' }}" id="block" /> --}}
                    </form>
                </td>
            </tr>


        @endforeach


        </tbody>
      </table>
    </div>
  </main>

@endif

@endsection
