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
    $data = "";
    foreach ($result as $row) {
      /*
      $value[] = [
        'x' => $row["stock_date"],
        'y' => $row["stock_number"]
      ];
      */
      //$value .= "['".$row["stock_date"]."',".$row["stock_number"]."],";
      $value .= "'".$row["stock_date"]."',";
      $data .= $row["stock_number"].",";
    }
    //dd($data);
?>

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'Stock Number'],
           <?php echo $value; ?> 
        ]);

        var options = {
          title: 'Số mã giao dịch theo ngày',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="curve_chart" style="width: 900px; height: 500px"></div>
  </body>
</html>