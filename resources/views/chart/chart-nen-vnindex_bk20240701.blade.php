<?php
  $conn = mysqli_connect("localhost","root","123456","si");
  //Tiền nạp
  $sql_str = "select s.stock_date, s.price_low, s.price_open, s.price_close, s.price_high
from stock s
where s.stock_code = 'VNINDEX'
and str_to_date(s.stock_date, '%Y%m%d') >= DATE(NOW() - INTERVAL 30 DAY)
order by s.stock_date asc";
  $result = mysqli_query($conn,$sql_str);
  while($row = mysqli_fetch_assoc($result)){
    $stock_date = $row["stock_date"];
    $price_low = $row["price_low"];
    $price_open = $row["price_open"];
    $price_close = $row["price_close"];
    $price_high = $row["price_high"];
  }
  $value = "";
  foreach ($result as $row) {
    $value .= "['".$row["stock_date"]."',".$row["price_low"].",".$row["price_open"].",".$row["price_close"].",".$row["price_high"]."],";
  }
  //dd($value);
  mysqli_close($conn);
?>

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          <?php echo $value; ?> 
          // ['Time', minimum, opening, closing, maximum]
        ], true);

        var options = {
          legend: 'none',
          bar: { groupWidth: '90%' }, // Remove space between bars.
          candlestick: {
            fallingColor: { strokeWidth: 0, fill: '#a52714' }, // red
            risingColor: { strokeWidth: 0, fill: '#0f9d58' }   // green
          }
        };

        var chart = new google.visualization.CandlestickChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
  </body>
</html>

