<?php
  $conn = mysqli_connect("localhost","root","123456","si");
  //Tiền nạp
  $sql_str = "SELECT a.stock_date stock_date, count(*) as stock_number FROM si.stock a where 1=1 group by a.stock_date order by a.stock_date desc limit 10";
  $result = mysqli_query($conn,$sql_str);
  while($row = mysqli_fetch_assoc($result)){
    $stock_date = $row["stock_date"];
    $stock_number = $row["stock_number"];
  }
  $value = "";
  foreach ($result as $row) {
    $value .= "['".$row["stock_date"]."',".$row["stock_number"]."],";
  }
  //dd($value);
  mysqli_close($conn);
?>

<html>
  <head>
    <!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Thời gian', 'Số mã chứng khoán'],
          <?php echo $value; ?> 
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
          chartArea : { left: 800 },
          bar: { groupWidth: "90%" }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
        //chart.draw(data, google.charts.Bar);
      }
    </script>
  </head>
  <body>
    <div id="columnchart_material" style="width: 850px; height: 500px;"></div>
  </body>
</html>
