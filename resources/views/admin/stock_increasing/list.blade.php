@extends('layouts.app')

@section('content')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Mã chứng khoán tăng giá 3 ngày liên tiếp</h1>
          </div>
        </div>
      </div>
    </section>

    <!-- Biểu đồ và danh sách mã -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- Biểu đồ bên trái -->
          <div class="col-md-8">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Biểu đồ giá</h3>
              </div>
              <div class="card-body" style="padding: 10px;">
                <div style="position: relative; height: 350px; width: 100%;">
                  <canvas id="priceChart"></canvas>
                </div>
              </div>
            </div>
            <div class="card card-info" style="margin-top: 10px;">
              <div class="card-header">
                <h3 class="card-title">Khối lượng giao dịch</h3>
              </div>
              <div class="card-body" style="padding: 10px;">
                <div style="position: relative; height: 150px; width: 100%;">
                  <canvas id="volumeChart"></canvas>
                </div>
              </div>
            </div>
          </div>
          <!-- Danh sách mã bên phải -->
          <div class="col-md-4">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Danh sách mã</h3>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Mã chứng khoán</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($stocks as $stock)
                    <tr>
                      <td><a href="#" class="stock-link" data-stock="{{ $stock->stock_code }}">{{ $stock->stock_code }}</a></td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    let priceChart, volumeChart;

    // Load chart for first stock
    if ($('.stock-link').length > 0) {
        const firstStock = $('.stock-link').first().data('stock');
        loadCharts(firstStock);
    }

    // Handle click on stock link
    $('.stock-link').on('click', function(e) {
        e.preventDefault();
        const stockCode = $(this).data('stock');
        loadCharts(stockCode);
    });

    function loadCharts(stockCode) {
        $.ajax({
            url: '{{ url("admin/stock_increasing/data") }}/' + stockCode,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (!data || data.length === 0) {
                    alert('Không có dữ liệu cho mã ' + stockCode);
                    return;
                }

                console.log('Data received:', data);

                // Prepare price data for candlestick with colors
                const priceData = data.map((item, index) => ({
                    x: index,
                    o: parseFloat(item.price_open),
                    h: parseFloat(item.price_high),
                    l: parseFloat(item.price_low),
                    c: parseFloat(item.price_close)
                }));

                // Prepare volume data with colors based on price movement
                const volumeLabels = data.map(item => item.stock_date);
                const volumeDatasets = [];
                const upVolume = [];
                const downVolume = [];
                
                data.forEach((item, index) => {
                    const volume = parseInt(item.volume) || 0;
                    if (parseFloat(item.price_close) >= parseFloat(item.price_open)) {
                        upVolume.push(volume);
                        downVolume.push(0);
                    } else {
                        upVolume.push(0);
                        downVolume.push(volume);
                    }
                });

                // Create common labels for both charts
                const commonLabels = data.map(item => item.stock_date);

                console.log('Price data:', priceData);

                // Destroy old charts
                if (priceChart) priceChart.destroy();
                if (volumeChart) volumeChart.destroy();

                // Create price chart
                const priceCtx = document.getElementById('priceChart').getContext('2d');
                priceChart = new Chart(priceCtx, {
                    type: 'candlestick',
                    data: {
                        labels: commonLabels,
                        datasets: [{
                            label: stockCode + ' - Giá',
                            data: priceData,
                            color: {
                                up: 'rgba(75, 192, 75, 1)',
                                down: 'rgba(255, 99, 99, 1)',
                                unchangedColor: 'rgba(125, 125, 125, 1)'
                            },
                            borderColor: {
                                up: 'rgba(75, 192, 75, 1)',
                                down: 'rgba(255, 99, 99, 1)',
                                unchangedColor: 'rgba(125, 125, 125, 1)'
                            }
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                labels: { font: { size: 11 } }
                            }
                        },
                        scales: {
                            x: {
                                type: 'category',
                                display: true,
                                offset: true,
                                title: { display: false },
                                ticks: { display: false },
                                grid: { display: true, drawBorder: false }
                            },
                            y: { 
                                title: { display: false },
                                beginAtZero: false,
                                grid: { display: true, drawBorder: false },
                                ticks: { display: false }
                            }
                        }
                    }
                });

                // Create volume chart
                const volumeCtx = document.getElementById('volumeChart').getContext('2d');
                volumeChart = new Chart(volumeCtx, {
                    type: 'bar',
                    data: {
                        labels: commonLabels,
                        datasets: [
                            {
                                label: 'Tăng',
                                data: upVolume,
                                backgroundColor: 'rgba(75, 192, 75, 0.7)',
                                borderColor: 'rgba(75, 192, 75, 1)',
                                borderWidth: 0,
                                categoryPercentage: 0.5,
                                barPercentage: 0.5
                            },
                            {
                                label: 'Giảm',
                                data: downVolume,
                                backgroundColor: 'rgba(255, 99, 99, 0.7)',
                                borderColor: 'rgba(255, 99, 99, 1)',
                                borderWidth: 0,
                                categoryPercentage: 0.5,
                                barPercentage: 0.5
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { 
                            legend: { 
                                display: true,
                                position: 'top',
                                labels: { font: { size: 11 } }
                            } 
                        },
                        scales: {
                            x: {
                                type: 'category',
                                offset: true,
                                title: { display: false },
                                stacked: true,
                                ticks: { font: { size: 9 }, maxRotation: 45, minRotation: 0, autoSkip: false },
                                grid: { display: true, drawBorder: false }
                            },
                            y: { 
                                stacked: true,
                                title: { display: false },
                                beginAtZero: true,
                                grid: { display: true, drawBorder: false },
                                ticks: { display: false }
                            }
                        }
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Lỗi:', error);
                alert('Không thể lấy dữ liệu cho mã ' + stockCode);
            }
        });
    }
});
</script>
@endsection