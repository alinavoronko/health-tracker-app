@extends('layout')
@section('title', 'Join Marathon')
@section('optional')
<li class="nav-item">
  <a href="#" class="nav-link">Marathon</a>
</li>
<li class="nav-item">
  <a href="#" class="nav-link">Stats</a>
</li>
<li class="nav-item">
  <a href="#" class="nav-link">Friends</a>
</li>
<li class="nav-item">
  <a href="#" class="nav-link">Settings</a>
</li>
@endsection
@section('additional_script')
<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"
integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc"
crossorigin="anonymous"
></script>
@endsection
@section('button-text', 'Join marathon')
@section('content')




      <main role="main" class="Main container bg-white px-4">
        <div class="mb-3">
          <h1 class="display-4 text-center">Test marathon by Artjoms</h1>
          <h3 class="text-center">Goal: 10000 steps</h3>
        </div>

        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Step Count</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>1</th>
                <td>Artjoms</td>
                <td>540</td>
              </tr>
              <tr>
                <th>2</th>
                <td>Artjoms</td>
                <td>540</td>
              </tr>
              <tr>
                <th>3</th>
                <td>Artjoms</td>
                <td>540</td>
              </tr>
              <tr>
                <th>4</th>
                <td>Artjoms</td>
                <td>540</td>
              </tr>
            </tbody>
          </table>
        </div>

      </main>
    
@endsection