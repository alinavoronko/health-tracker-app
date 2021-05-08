@extends('layout')
@section('title', 'Statistics')
@section('optional')
<li class="nav-item">
  <a href="{{ route('marathons.index') }}" class="nav-link">Marathons</a>
</li>
<li class="nav-item">
  <a href="{{ route('stats') }}" class="nav-link">Stats</a>
</li>
<li class="nav-item">
  <a href="{{ route('friends.index') }}" class="nav-link">Friends</a>
</li>  
<li class="nav-item">
  <a href="{{ route('settings') }}" class="nav-link">Settings</a>
</li>
@endsection
@section('additional_script')
<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"
integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc"
crossorigin="anonymous"
></script>
@endsection
@section('button-text', 'Add records')
@section('content')

      <main role="main" class="Main container bg-white px-4">
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
          <h1 class="display-4 text-center mb-3">Sleep</h1>
          <div class="row justify-content-around">
            <div class="Chart p-2 border col-sm-5 mb-3">
              <canvas id="weekSleepChart" width="400" height="250"></canvas>
            </div>
            <div class="Chart p-2 border col-sm-5 mb-3">
              <canvas id="monthSleepChart" width="400" height="250"></canvas>
            </div>
          </div>
        </div>

        <div class="mb-3 DashboardSection">
          <h1 class="display-4 text-center mb-3">Blood</h1>
          <div class="row justify-content-around">
            <div class="Chart p-2 border col-sm-5 mb-3">
              <canvas id="bloodPressureChart" width="400" height="250"></canvas>
            </div>
            <div class="Chart p-2 border col-sm-5 mb-3">
              <canvas id="pulseChart" width="400" height="250"></canvas>
            </div>
          </div>
        </div>

        <div class="mb-3 DashboardSection">
          <h1 class="display-4 text-center mb-3">Weight</h1>
          <div class="row justify-content-around">
            <div class="col-sm-5 mb-3 Chart border p-2">
              <canvas id="weightChart" width="400" height="250"></canvas>
            </div>
            <div class="col-sm-5 mb-3 Chart border p-2">
              <canvas id="weightChart" width="400" height="250"></canvas>
            </div>
          </div>
        </div>
      </main>
     <script>
      const todayStepsCtx = document
        .getElementById("todayChart")
        .getContext("2d");
      const weekStepsCtx = document
        .getElementById("weekChart")
        .getContext("2d");
      const weekSleepChartCtx = document
        .getElementById("weekSleepChart")
        .getContext("2d");
      const monthSleepCtx = document
        .getElementById("monthSleepChart")
        .getContext("2d");
      const bloodPressureCtx = document
        .getElementById("bloodPressureChart")
        .getContext("2d");
      const pulseCtx = document
        .getElementById("pulseChart")
        .getContext("2d");
      const weightCtx = document.getElementById("weightChart").getContext("2d");

      const todayChart = new Chart(todayStepsCtx, {
        type: "bar",
        data: {
          labels: [
            "10:00",
            "11:00",
            "12:00",
            "13:00",
            "14:00",
            "15:00",
            "16:00",
            "17:00",
            "18:00",
          ],
          datasets: [
            {
              label: "Today",
              data: [300, 1000, 50, 400, 800, 900, 100, 150, 220],
              borderWidth: 1,
            },
          ],
        },
      });

      const weekChart = new Chart(weekStepsCtx, {
        type: "bar",
        data: {
          labels: [
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday",
            "Sunday",
          ],
          datasets: [
            {
              label: "Week",
              data: [1000, 2000, 10000, 8000, 800, 17000, 19800],
              borderWidth: 1,
            },
          ],
        },
      });

      const weekSleepChart = new Chart(weekSleepChartCtx, {
        type: "bar",
        data: {
          labels: [
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday",
            "Sunday",
          ],
          datasets: [
            {
              label: "Week",
              data: [4.3, 6, 8, 7, 6.6, 7, 8],
              borderWidth: 1,
            },
          ],
        },
      });

      const weightChart = new Chart(weightCtx, {
        type: "line",
        data: {
          labels: [
            "01",
            "02",
            "03",
            "04",
            "05",
            "06",
            "07",
            "08",
            "09",
            "10",
            "11",
            "12",
            "13",
            "14",
            "15",
            "16",
            "17",
            "18",
            "19",
            "20",
            "21",
            "22",
            "23",
            "24",
            "25",
            "26",
            "27",
            "28",
            "29",
            "30",
          ],
          datasets: [
            {
              label: "Weight",
              data: [
                80.0,
                80.5,
                81,
                81.5,
                82,
                82.5,
                83,
                83.5,
                84.0,
                85,
                86.0,
                86.5,
                87,
                87.5,
                88,
                88.5,
                89,
                89.5,
                90.0,
                91,
                92.0,
                92.5,
                93,
                93.5,
                94,
                94.5,
                95,
                95.5,
                96.0,
                97,
              ],
            },
          ],
        },
      });

      const pulseChart = new Chart(pulseCtx, {
        type: "line",
        data: {
          labels: [
            "10:00","10:15","10:30","10:45",
            "11:00","11:15","11:30","11:45",
            "12:00","12:15","12:30","12:45",
            "13:00","13:15","13:30","13:45",
            "14:00","14:15","14:30","14:45",
            "15:00","15:15","15:30","15:45",
            "16:00","16:15","16:30","16:45",
            "17:00","17:15","17:30","17:45",
            "18:00","18:15","18:30","18:45",
          ],
          datasets: [
            {
              label: "Pulse",
              data: [
                80.0,
                80.5,
                81,
                81.5,
                82,
                82.5,
                83,
                83.5,
                84.0,
                85,
                86.0,
                86.5,
                87,
                87.5,
                88,
                88.5,
                89,
                89.5,
                90.0,
                91,
                92.0,
                92.5,
                93,
                93.5,
                94,
                94.5,
                95,
                95.5,
                96.0,
                97,
                94,
                94.5,
                95,
                95.5,
                96.0,
                97,
              ],
            },
          ],
        },
      });

      const monthSleepChart = new Chart(monthSleepCtx, {
        type: "bar",
        data: {
          labels: [
            "01",
            "02",
            "03",
            "04",
            "05",
            "06",
            "07",
            "08",
            "09",
            "10",
            "11",
            "12",
            "13",
            "14",
            "15",
            "16",
            "17",
            "18",
            "19",
            "20",
            "21",
            "22",
            "23",
            "24",
            "25",
            "26",
            "27",
            "28",
            "29",
            "30",
          ],
          datasets: [
            {
              label: "Month",
              data: [
                8.0,
                8.5,
                8,
                8.5,
                8,
                8.5,
                8,
                8.5,
                8.0,
                8,
                8.0,
                8.5,
                8,
                8.5,
                8,
                8.5,
                8,
                8.5,
                9.0,
                9,
                9.0,
                9.5,
                9,
                9.5,
                9,
                9.5,
                9,
                9.5,
                9.0,
                9,
              ],
            },
          ],
        },
      });
    </script>

@endsection