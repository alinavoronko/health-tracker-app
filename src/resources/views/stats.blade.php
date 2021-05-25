@extends('layout')
@section('title', 'Statistics')
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
@section('additional_script')
<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"
integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc"
crossorigin="anonymous"
></script>
@endsection
@section('button-text', 'Add records')
@section('button')
<x-named-route route="activities.create">
  Add records
</x-named-route>
@endsection
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
            <div class="Chart p-2 border col-sm-5 mb-3">
              <canvas id="monthChart" width="400" height="250"></canvas>
            </div>
          </div>
          <div class="col-md-12 text-center">
            <button type="button" class="btn btn-warning">Set step goal</button>
        </div>
        </div>

        <div class="mb-3 DashboardSection">
          <h1 class="display-4 text-center mb-3">Sleep</h1>
          <div class="row justify-content-around">
            <div class="Chart p-2 border col-sm-5 mb-3">
              <canvas id="todaySleepChart" width="400" height="250"></canvas>
            </div>
            <div class="Chart p-2 border col-sm-5 mb-3">
              <canvas id="weekSleepChart" width="400" height="250"></canvas>
            </div>
            <div class="Chart p-2 border col-sm-5 mb-3">
              <canvas id="monthSleepChart" width="400" height="250"></canvas>
            </div>
            <div class="col-md-12 text-center">
              <button type="button" class="btn btn-primary">Set sleep goal</button>
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
            <div class="col-sm-5 mb-3 Chart border p-2">
              <canvas id="weightChart" width="400" height="250"></canvas>
            </div>
          </div>
          <div class="col-md-12 text-center">
            <button type="button" class="btn btn-danger">Set weight goal</button>
        </div>

        </div>
      </main>
     <script>
       const todaySleepCtx =document.getElementById('todaySleepChart').getContext('2d');


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




const todaySleep=new Chart(todaySleepCtx, {


  type: 'gauge',
  data: {
    //labels: ['Success', 'Warning', 'Warning', 'Error'],
    datasets: [{
      data: [100,200,300,400]],
      // value: value, //????????????
      backgroundColor: ['green', 'yellow', 'orange', 'red'],
      borderWidth: 2
    }]
  },
  options: {
    responsive: true,
    title: {
      display: true,
      text: 'Gauge chart'
    },
    layout: {
      padding: {
        bottom: 30
      }
    },
    needle: {
      // Needle circle radius as the percentage of the chart area width
      radiusPercentage: 2,
      // Needle width as the percentage of the chart area width
      widthPercentage: 3.2,
      // Needle length as the percentage of the interval between inner radius (0%) and outer radius (100%) of the arc
      lengthPercentage: 80,
      // The color of the needle
      color: 'rgba(0, 0, 0, 1)'
    },
    valueLabel: {
      formatter: Math.round
    }
  }
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
