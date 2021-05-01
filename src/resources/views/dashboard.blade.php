@extends('layout')
@section('title', 'Dashboard')
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
@section('button-text', 'Add records')
@section('content')

      <main role="main" class="Main container bg-white px-4">
        <div class="d-flex Welcome w-100 justify-content-center mb-3">
          <img
            src="./assets/images/Badge.png"
            alt="Avatar for Name Surname"
            class="rounded-circle Welcome-Avatar me-3"
          />
          <h1 class="display-4">
            Welcome, <span class="SeparateLine">&lt;Name Surname&gt;</span>
          </h1>
        </div>

        <div class="mb-3 DashboardSection">
          <h1 class="display-4 text-center mb-3">Steps</h1>
          <div class="row justify-content-around">
            <div class="Chart p-2 border col-sm-5 mb-3">
              <canvas id="todayChart" width="400" height="250"></canvas>
            </div>
            <div class="Chart p-2 border col-sm-5 mb-3">
              <canvas id="weekChart" width="400" height="250"></canvas>
            </div>
          </div>
        </div>

        <div class="mb-3 DashboardSection">
          <div class="row justify-content-between mx-5">
            <div class="col-sm-5 mb-3">
              <div class="Chart border p-2">
                <canvas id="weightChart" width="400" height="250"></canvas>
              </div>
            </div>

            <div class="col-sm-5 mb-3 p-2">
              <div class="Chart">
                <h3 class="text-center mb-3">Friends</h3>

                <ul class="list-group">
                  <li class="list-group-item d-flex justify-content-between">
                    <span>Friend 1</span>
                    <span>-2700</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between">
                    <span>Friend 2</span>
                    <span>+500</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between">
                    <span>Friend 3</span>
                    <span>+1000</span>
                  </li>
                </ul>
              </div>
            </div>

            <div class="col-sm-5 mb-3 p-2">
              <div class="Chart">
                <h3 class="text-center mb-3">Goals</h3>

                <ul class="list-group">
                  <li class="list-group-item d-flex justify-content-between">
                    <span>Goal 1</span>
                    <span>-2700</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between">
                    <span>Goal 2</span>
                    <span>+500</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between">
                    <span>Goal 3</span>
                    <span>+1000</span>
                  </li>
                </ul>
              </div>
            </div>

            <div class="col-sm-5 mb-3 p-2">
              <div class="Chart">
                <h3 class="text-center mb-3">Marathons</h3>

                <ul class="list-group">
                  <li class="list-group-item d-flex justify-content-between">
                    <span>Goal 1</span>
                    <span>-2700</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between">
                    <span>Goal 2</span>
                    <span>+500</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between">
                    <span>Goal 3</span>
                    <span>+1000</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </main>
    

 @endsection

 

