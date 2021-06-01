@extends('layout')
@section('title', 'Statistics')

@section('additional_script')
<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"
integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc"
crossorigin="anonymous"
></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.0/dist/chart.min.js" integrity="sha256-KP9rTEikFk097YZVFmsYwZdAg4cdGdea8O/V7YZJUxw=" crossorigin="anonymous"></script>
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
          <div class="w-80">
              @foreach ($goals as $goal)
              <div class="progress mb-3">
                  <div class="progress-bar" role="progressbar" style="width: {{ 100 * ($todayTotal / ($goal->value === 0 ? $todayTotal : $goal->value)) }}%;">{{ $todayTotal }} / {{ $goal->value }}</div>
              </div>
              @endforeach
          </div>
          <div class="row justify-content-around">
            <div class="Chart p-2 border col-sm-5 mb-3">
              <canvas id="weekStepsChart" width="400" height="250"></canvas>
            </div>
            <div class="Chart p-2 border col-sm-5 mb-3">
              <canvas id="monthStepsChart" width="400" height="250"></canvas>
            </div>
          </div>
          <div class="col-md-12 text-center">
            <a href="{{ route('goal.create', ['lang' => App::getLocale()]) }}">
              <button type="button" class="btn btn-warning">Set step goal</button>
              </a>
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
            {{-- <div class="col-md-12 text-center">
              <a href="{{ route('goal.create', ['lang' => App::getLocale()]) }}">
              <button type="button" class="btn btn-primary">Set sleep goal</button>
              </a>
          </div> --}}

      

          </div>
        </div>


        <div class="mb-3 DashboardSection">
          <h1 class="display-4 text-center mb-3">Weight</h1>
          <div class="row justify-content-around">
            <div class="col-sm-5 mb-3 Chart border p-2">
              <canvas id="weekWeightChart" width="400" height="250"></canvas>
            </div>
            <div class="col-sm-5 mb-3 Chart border p-2">
              <canvas id="monthWeightChart" width="400" height="250"></canvas>
            </div>
          </div>
          {{-- <div class="col-md-12 text-center">
          
            <a href="{{ route('goal.create', ['lang' => App::getLocale()]) }}">
              <button type="button" class="btn btn-danger">Set weight goal</button>
              </a>
        </div> --}}

        </div>
      </main>

     <script>
        function genereateDateList(from, to) {
            const list = [];
            for (let dt = new Date(from); dt <= to; dt.setDate(dt.getDate()  + 1)) {
                list.push(new Date(dt));
            }
            return list;
        }

        function datediff(first, second) {
            // Take the difference between the dates and divide by milliseconds per day.
            // Round to nearest whole number to deal with DST.
            return Math.ceil((second-first)/(1000*60*60*24));
        }

        const statistics = {
        @foreach ($statistics as $period => $value)
          '{{ $period }}': {
            dates: {
                to: new Date(`{!! $value['dates']['to'] !!}`),
                from: new Date(`{!! $value['dates']['from'] !!}`),
            },
            Sleep: JSON.parse(`{!! $value['sleep'] !!}`),
            Steps: JSON.parse(`{!! $value['steps'] !!}`),
            Weight: JSON.parse(`{!! $value['weight'] !!}`),
          },
        @endforeach
        };

        const cats = ['Sleep', 'Steps'];
        const weekDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        const stepsGoal = {!! count($stepsGoal) > 0 ? $stepsGoal[0]->value : 6000 !!};

        console.log('st goal', stepsGoal);

        window.addEventListener('DOMContentLoaded', (event)=> {
            Object.entries(statistics)
                .filter(([k]) => k !== 'day')
                .forEach(([period, value]) => {
                    const dateList = genereateDateList(value.dates.from, value.dates.to);


                    cats.forEach(category => {
                        const ctx = document.getElementById(`${period}${category}Chart`).getContext('2d');

                        const labels = dateList.map(date => period == 'month' ? date.getDate() : weekDays[date.getDay()]);

                        const datasets = [
                            {
                                type: "bar",
                                label: period,
                                data: dateList.map(date => value[category][date.toISOString().split('T')[0]] || 0),
                                borderWidth: 1,
                            },
                        ];

                        if (category === 'Steps') {
                            datasets.push({
                                type: "line",
                                label: 'Goal',
                                data: Array(labels.length).fill(stepsGoal),
                            });
                        }

                        const chart = new Chart(ctx, {
                            data: {
                                datasets,
                                labels,
                            },
                        });
                    });

                    const ctx = document.getElementById(`${period}WeightChart`).getContext('2d');

                    const data = [];
                    const labels = dateList.map(date => period == 'month' ? date.getDate() : weekDays[date.getDay()]);

                    if (value.Weight.length !== 0) {
                        const entries = Object.entries(value.Weight);
                        let lastDate = value.dates.from;
                        let [firstDate,lastValue] = entries[0];

                        if (lastDate !== new Date(firstDate)) data.push(lastValue);

                        entries.forEach(([date, value]) => {
                            const diff = datediff(lastDate, new Date(date));

                            console.log('ld', lastDate, new Date(date), diff);
                            const step = (value - lastValue) / (diff || 1);

                            for (let i = 1; i < diff; i++) {
                                // Linear interpolation
                                data.push(lastValue + step * i);
                            }

                            data.push(value);

                            lastDate = new Date(date);
                            lastValue = value;
                        });

                        for (let i = data.length; i < labels.length; i++) data.push(lastValue);
                    }

                    const chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels,
                            datasets: [
                                {
                                    label: period,
                                    data,
                                }
                            ]
                        }
                    });
                });
        });
    //    const todaySleepCtx =document.getElementById('todaySleepChart').getContext('2d');



    //   const todayStepsCtx = document
    //     .getElementById("todayChart")
    //     .getContext("2d");
    //   const weekStepsCtx = document
    //     .getElementById("weekChart")
    //     .getContext("2d");
    //   const weekSleepChartCtx = document
    //     .getElementById("weekSleepChart")
    //     .getContext("2d");
    //   const monthSleepCtx = document
    //     .getElementById("monthSleepChart")
    //     .getContext("2d");

    //   const weightCtx = document.getElementById("weightChart").getContext("2d");

    //   const todayChart = new Chart(todayStepsCtx, {
    //     type: "bar",
    //     data: {
    //       labels: [
    //         "10:00",
    //         "11:00",
    //         "12:00",
    //         "13:00",
    //         "14:00",
    //         "15:00",
    //         "16:00",
    //         "17:00",
    //         "18:00",
    //       ],
    //       datasets: [
    //         {
    //           label: "Today",
    //           data: [300, 1000, 50, 400, 800, 900, 100, 150, 220],
    //           borderWidth: 1,
    //         },
    //       ],
    //     },
    //   });




    // const todaySleep=new Chart(todaySleepCtx, {


    // type: 'gauge',
    // data: {
    //     //labels: ['Success', 'Warning', 'Warning', 'Error'],
    //     datasets: [{
    //     data: [100,200,300,400]],
    //     // value: value, //????????????
    //     backgroundColor: ['green', 'yellow', 'orange', 'red'],
    //     borderWidth: 2
    //     }]
    // },
    // options: {
    //     responsive: true,
    //     title: {
    //     display: true,
    //     text: 'Gauge chart'
    //     },
    //     layout: {
    //     padding: {
    //         bottom: 30
    //     }
    //     },
    //     needle: {
    //     // Needle circle radius as the percentage of the chart area width
    //     radiusPercentage: 2,
    //     // Needle width as the percentage of the chart area width
    //     widthPercentage: 3.2,
    //     // Needle length as the percentage of the interval between inner radius (0%) and outer radius (100%) of the arc
    //     lengthPercentage: 80,
    //     // The color of the needle
    //     color: 'rgba(0, 0, 0, 1)'
    //     },
    //     valueLabel: {
    //     formatter: Math.round
    //     }
    // }
    // });


    //   const weekSleepChart = new Chart(weekSleepChartCtx, {
    //     type: "bar",
    //     data: {
    //       labels: [
    //         "Monday",
    //         "Tuesday",
    //         "Wednesday",
    //         "Thursday",
    //         "Friday",
    //         "Saturday",
    //         "Sunday",
    //       ],
    //       datasets: [
    //         {
    //           label: "Week",
    //           data: [4.3, 6, 8, 7, 6.6, 7, 8],
    //           borderWidth: 1,
    //         },
    //       ],
    //     },
    //   });

    //   const weightChart = new Chart(weightCtx, {
    //     type: "line",
    //     data: {
    //       labels: [
    //         "01",
    //         "02",
    //         "03",
    //         "04",
    //         "05",
    //         "06",
    //         "07",
    //         "08",
    //         "09",
    //         "10",
    //         "11",
    //         "12",
    //         "13",
    //         "14",
    //         "15",
    //         "16",
    //         "17",
    //         "18",
    //         "19",
    //         "20",
    //         "21",
    //         "22",
    //         "23",
    //         "24",
    //         "25",
    //         "26",
    //         "27",
    //         "28",
    //         "29",
    //         "30",
    //       ],
    //       datasets: [
    //         {
    //           label: "Weight",
    //           data: [
    //             80.0,
    //             80.5,
    //             81,
    //             81.5,
    //             82,
    //             82.5,
    //             83,
    //             83.5,
    //             84.0,
    //             85,
    //             86.0,
    //             86.5,
    //             87,
    //             87.5,
    //             88,
    //             88.5,
    //             89,
    //             89.5,
    //             90.0,
    //             91,
    //             92.0,
    //             92.5,
    //             93,
    //             93.5,
    //             94,
    //             94.5,
    //             95,
    //             95.5,
    //             96.0,
    //             97,
    //           ],
    //         },
    //       ],
    //     },
    //   });
    </script>

@endsection
