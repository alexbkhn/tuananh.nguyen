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
              <div class="card-body">
                <canvas id="priceChart"></canvas>
              </div>
            </div>
            <div class="card card-info" style="margin-top: 20px;">
              <div class="card-header">
                <h3 class="card-title">Khối lượng giao dịch</h3>
              </div>
              <div class="card-body">
                <canvas id="volumeChart"></canvas>
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

                // Prepare price data for candlestick
                const priceData = data.map((item, index) => ({
                    x: index,
                    o: parseFloat(item.price_open),
                    h: parseFloat(item.price_high),
                    l: parseFloat(item.price_low),
                    c: parseFloat(item.price_close)
                }));

                console.log('Price data:', priceData);

                // Prepare volume data
                const volumeLabels = data.map(item => item.stock_date);
                const volumeData = data.map(item => parseInt(item.volume) || 0);

                // Destroy old charts
                if (priceChart) priceChart.destroy();
                if (volumeChart) volumeChart.destroy();

                // Create price chart
                const priceCtx = document.getElementById('priceChart').getContext('2d');
                priceChart = new Chart(priceCtx, {
                    type: 'candlestick',
                    data: {
                        labels: data.map(item => item.stock_date),
                        datasets: [{
                            label: stockCode + ' - Giá',
                            data: priceData
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                labels: { font: { size: 12 } }
                            }
                        },
                        scales: {
                            x: {
                                type: 'category',
                                display: true,
                                title: { display: true, text: 'Ngày' }
                            },
                            y: { 
                                title: { display: true, text: 'Giá (VND)' },
                                beginAtZero: false
                            }
                        }
                    }
                });

                // Create volume chart
                const volumeCtx = document.getElementById('volumeChart').getContext('2d');
                volumeChart = new Chart(volumeCtx, {
                    type: 'bar',
                    data: {
                        labels: volumeLabels,
                        datasets: [{
                            label: 'Khối lượng',
                            data: volumeData,
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: true } },
                        scales: {
                            x: {
                                type: 'time',
                                time: {
                                    unit: 'day',
                                    displayFormats: { day: 'MMM DD' }
                                }
                            },
                            y: { title: { display: true, text: 'Khối lượng' } }
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