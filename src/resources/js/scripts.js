import Chart from 'chart.js/auto'
require('bootstrap');

window.addEventListener('DOMContentLoaded', (event)=> {
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


})