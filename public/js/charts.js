google.charts.load('current', {'packages':['bar']});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['', 'Before', 'After'],
    ['Anger', 7, 4],
    ['Jealousy', 5, 2],
    ['Love', 3, 5],
    ['Hate', 1, 2]
  ]);

  var options = {
    chart: {
      title: 'Emotions',
      subtitle: 'Before and After CBT',
    },
    bars: 'vertical' // Required for Material Bar Charts.
  };

  var chart = new google.charts.Bar(document.getElementById('chart_div'));

  chart.draw(data, options);
}
