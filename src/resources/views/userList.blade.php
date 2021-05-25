@extends('layout')
@section('title', 'Dashboard')
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
  <a href="{{ route('settings', ['lang' => App::getLocale()]) }}" class="nav-link">Settings</a>
</li>
@endsection

@section('button')
<x-named-route route="activities.create">
  Add records
</x-named-route>
@endsection
@section('content')

@if (count($users) == 0)
    <p class="red">There are no users in the database!</p>
@else

<main role="main" class="Main container bg-white px-4">
    <div class="mb-3">
      <h1 class="text-center">All Users</h1>


    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Name Surname</th>
            <th scope="col">e-mail</th>
            <th scope="col">Remove</th>
          </tr>
        </thead>
        <!--use blade for loop to loop over friends get a list of them from db-->
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}  {{ $user->surname }}</td>
                <td>{{ $user->email }}</td>
                <td>

                    {{-- Add an appropriate method that sets user's blocked property to 1 --}}
                    <form action="{{ action([App\Http\Controllers\AdminController::class, 'block'], ['id' =>$user->id, 'blocked'=>$user->isBlocked, 'lang' => App::getLocale()]) }}" method="post">
                        @csrf

                        {{-- <label for="block">{{ $user->isBlocked ? 'Unblock' : 'Block' }}</label> --}}

                        <input type="submit" value="{{ $user->isBlocked ? 'Unblock' : 'Block' }}" id="block" />
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
