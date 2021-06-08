@extends('layout')
@section('title', 'Stats')

@section('additional_script')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.0/dist/chart.min.js" integrity="sha256-KP9rTEikFk097YZVFmsYwZdAg4cdGdea8O/V7YZJUxw=" crossorigin="anonymous"></script>
@endsection

@section('button')
<x-named-route route="activities.create">
  {{ __('Add records') }}
</x-named-route>
@endsection
@section('content')

      <main role="main" class="Main container bg-white px-4">
        <div class="mb-3 DashboardSection">
          <h1 class="display-4 text-center mb-3">{{ __('Steps') }}</h1>
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
              <button type="button" class="btn btn-warning">{{ __('Set step goal') }}</button>
              </a>
        </div>
        </div>

        <div class="mb-3 DashboardSection">
          <h1 class="display-4 text-center mb-3">{{ __('Sleep') }}</h1>
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
          <h1 class="display-4 text-center mb-3">{{ __('Weight') }}</h1>
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
        <div class="col-md-12 text-center">
          <a href="{{ route('download.stats', ['lang' => App::getLocale()]) }}">
            <button type="button" class="btn btn-danger">{{ __('Download Statistics') }}</button>
            </a>
      </div>

        </div>
      </main>

     <script>
       //TO-DO: Add different colors for goals and regular data
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
        //TO-DO: Translate days of the week & categories
        // const cats = ['{{ __("Sleep") }}', '{{ __("Steps") }}'];
        const weekDays = ['{{ __("Sunday") }}', '{{ __("Monday") }}', '{{ __("Tuesday") }}', '{{ __("Wednesday") }}', '{{ __("Thursday") }}', '{{ __("Friday") }}', '{{ __("Saturday") }}'];
        const periodi= {"week":"{{ __('Week') }}", "month":"{{ __('Month') }}"};
        const cats = ['Sleep', 'Steps'];
        //const weekDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

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
                                label: periodi[period],
                                data: dateList.map(date => value[category][date.toISOString().split('T')[0]] || 0),
                                borderWidth: 1,
                                backgroundColor: "rgba(66, 132, 237,0.8)",
                                hoverBackgroundColor: "rgba(20, 95, 217, 1)",
                                hoverBorderColor: "blue",
                            },
                        ];

                        if (category === 'Steps') {
                            datasets.push({
                                type: "line",
                                label: '{{ __("Goal") }}',
                                data: Array(labels.length).fill(stepsGoal),
                                backgroundColor: "rgba(255, 205, 33, 0.8)",
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
                                    label: periodi[period],
                                    data,
                                    backgroundColor: "rgba(255, 164, 84,0.8)",
                                    hoverBackgroundColor: "rgba(209, 73, 10,0.8)",
                                    hoverBorderColor: "orange",
                                    borderWidth: 1,
                                }
                            ]
                        }
                    });
                });
        });
    
    </script>

@endsection
