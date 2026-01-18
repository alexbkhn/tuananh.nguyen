<?php
  //$conn = mysqli_connect("localhost","root","123456","si");
  //$db = mysqli_connect("localhost","root","123456","");
  $servername = "localhost";
  $username = "root";
  $password = "123456";
  $dbname = "si";

    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql_str = "select s.stock_date, s.price_low, s.price_open, s.price_close, s.price_high, s.volume from stock s where s.stock_code = 'VNINDEX'";
    if(isset($_GET['days']) & !empty($_GET['days'])){
      //$sql_str .= " and str_to_date(s.stock_date, '%Y%m%d') >= DATE(NOW() - INTERVAL {$_GET['days']} DAY) order by s.stock_date asc";
      $sql_str .= " order by s.stock_date desc limit {$_GET['days']}";
    } else{
      //$sql_str .= " order by s.stock_date asc";
      $sql_str .= " order by s.stock_date desc limit 60";
    }
    $result = $db->prepare($sql_str);
    $res = $result->execute() or die(print_r($result->errorInfo(), true));
    //$res = $result->execute(array($_GET['scrip'])) or die(print_r($result->errorInfo(), true));
    //$stock_vals = $result->fetchAll(PDO::FETCH_ASSOC);
    $stock_vals = $result->fetchAll(PDO::FETCH_ASSOC);
    $stock_vals = array_reverse($stock_vals);
    //var_dump($stock_vals);
  //Tiền nạp
  
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
          <?php
            foreach ($stock_vals as $stock_val){
          ?>
          ['<?php echo $stock_val['stock_date']; ?>', <?php echo $stock_val['price_low']; ?>, <?php echo $stock_val['price_open']; ?>, <?php echo $stock_val['price_close']; ?>, <?php echo $stock_val['price_high']; ?>],
          <?php } ?>
        ], true);

        var options = {
          legend: 'none',
          bar: { groupWidth: '90%' }, // Remove space between bars.
          candlestick: {
            fallingColor: { strokeWidth: 0, fill: '#a52714', stroke: '#a52714' }, // red
            risingColor: { strokeWidth: 0, fill: '#0f9d58', stroke: '#0f9d58' }   // green
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
          <?php
            foreach ($stock_vals as $stock_val){
          ?>
          ['<?php echo $stock_val['stock_date']; ?>', <?php echo $stock_val['volume']; ?>],
          <?php } ?> 
        ]);
        
        var options = {
          legend: { position: 'none' },      
          bar: { groupWidth: "90%" }
        };
        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
    <!-- Đồ thị bar -->
  </head>
  <body>
    <a href="http://localhost/tuananh.nguyen/line-chart?days=30">30 days</a> | <a href="http://localhost/tuananh.nguyen/line-chart?days=60">60 days</a> | <a href="http://localhost/tuananh.nguyen/line-chart?days=90">90 days</a> | <a href="http://localhost/tuananh.nguyen/line-chart?days=180">180 days</a>  | <a href="http://localhost/tuananh.nguyen/line-chart?days=360">360 days</a>
    <div id="chart_div" style="width: 100%; height: 500px;"></div>
    <div id="columnchart_material" style="width: 100%; height: 500px;"></div>
  </body>
</html>

