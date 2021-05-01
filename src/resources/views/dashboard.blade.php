<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Health Tracker App</title>

    <link rel="stylesheet" type="text/css" href="../../css/main.css" />
    <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="./node_modules/chart.js/dist/chart.min.js"></script>
  </head>
  <body class="bg-light">
    <div class="Body-Wrapper">
      <header class="Header">
        <nav class="Header-Navbar navbar navbar-expand-lg navbar-light">
          <div class="container">
            <a href="#" class="navbar-brand">Health Tracker App</a>
            <button
              class="navbar-toggler"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#navbarToggler"
            >
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarToggler">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                  <a href="#" class="nav-link active">Home</a>
                </li>
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
              </ul>
              <div class="text-end">
                <button class="btn btn-dark" type="button">Add a record</button>
              </div>
            </div>
          </div>
        </nav>
      </header>

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
    </div>

    <footer class="Body-Footer bg-light">
      <div class="container my-3 text-end text-secondary">
        <span>&copy; 2021 Artjoms Travkovs & Alina Voronko</span>
      </div>
    </footer>

    <script>
      const todayStepsCtx = document
        .getElementById("todayChart")
        .getContext("2d");
      const weekStepsCtx = document
        .getElementById("weekChart")
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
    </script>
  </body>
</html>
