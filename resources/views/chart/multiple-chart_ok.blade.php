<?php
  $conn = mysqli_connect("localhost","root","123456","si");
  //Tiền nạp
  $sql_str = "select s.stock_date, s.price_low, s.price_open, s.price_close, s.price_high, s.volume
              from stock s
              where s.stock_code = 'VNAll-INDEX'
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
  $value1 = "";
  foreach ($result as $row) {
    $value .= "['".$row["stock_date"]."',".$row["price_low"].",".$row["price_open"].",".$row["price_close"].",".$row["price_high"]."],";
    $value1 .= "['".$row["stock_date"]."',".$row["volume"]."],";
  }
  //dd($value);
  mysqli_close($conn);
?>

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- Đồ thị nến -->
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
        //var chart = new google.charts.CandlestickChart(document.getElementById('chart_div'));
        //chart.draw(data, google.charts.CandlestickChart.convertOptions(options));
      }
    </script>
    <!-- Đồ thị nến -->
    <!-- Đồ thị bar -->
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Thời gian', 'Số lượng'],
          <?php echo $value1; ?> 
        ]);
        
        var options = {
          width: 600,
          legend: { position: 'none' },      
          /*
          chart: {
            title: 'Chess opening moves',
            subtitle: 'popularity by percentage' },
          axes: {
            x: {
              0: { side: 'top', label: 'White to move'} // Top x-axis.
            }
          },
          */
          bar: { groupWidth: "90%" }
        };
        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
        //var chart = new google.visualization.Bar(document.getElementById('columnchart_material'));
        //chart.draw(data, options);
      }
    </script>
    <!-- Đồ thị bar -->
  </head>
  <body>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
    <div id="columnchart_material" style="width: 900px; height: 500px;"></div>
  </body>
</html>

