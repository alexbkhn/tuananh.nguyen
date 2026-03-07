@extends('layouts.app')

@section('content')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>CP tăng cao 2 ngày liên tiếp gần nhất
              <i id="infoIcon" class="fas fa-info-circle text-info ml-2" style="cursor:pointer;" data-toggle="modal" data-target="#infoModal"></i>
            </h1>
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
                <!-- Filter input -->
                <div class="form-group">
                  <input type="text" id="stockFilter" class="form-control" placeholder="Tìm kiếm mã chứng khoán...">
                </div>
                <!-- Total count and export button -->
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <small class="text-muted">Tổng số mã: <span id="totalStocks">{{ count($stocks) }}</span></small>
                  <button id="exportBtn" class="btn btn-sm btn-success">
                    <i class="fas fa-download"></i> Export CSV
                  </button>
                </div>

                <!-- Scrollable table -->
                <div style="max-height: 400px; overflow-y: auto;">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Mã chứng khoán</th>
                      </tr>
                    </thead>
                    <tbody id="stockTableBody">
                      @foreach($stocks as $stock)
                      <tr class="stock-row">
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
      </div>
    </section>
</div>

<!-- Info modal -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="infoModalLabel">Điều kiện lọc</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="font-size:0.9em;">
        <strong>Note:</strong> Danh sách chỉ bao gồm mã có 2 phiên gần nhất<br>
        - phiên sau có giá đóng tăng so với phiên trước.<br>
        - mỗi phiên có khối lượng > 1.000.<br>
        - hai phiên là hai ngày liền kề (chênh lệch không quá 1 ngày).<br>
        - phiên gần nhất trong vòng 3 ngày qua.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    let priceChart, volumeChart;

    // Load chart for first stock
    if ($('.stock-link').length > 0) {
        const firstStock = $('.stock-link').first().data('stock');
        // Highlight first stock
        $('.stock-link').first().closest('.stock-row').addClass('font-weight-bold');
        loadCharts(firstStock);
    }

    // Handle click on stock link
    $('.stock-link').on('click', function(e) {
        e.preventDefault();
        const stockCode = $(this).data('stock');
        
        // Remove active class from all rows
        $('.stock-row').removeClass('font-weight-bold');
        
        // Add active class to clicked row
        $(this).closest('.stock-row').addClass('font-weight-bold');
        
        loadCharts(stockCode);
    });

    function loadCharts(stockCode) {
        $.ajax({
            url: '{{ url("admin/stock_highest_2days/data") }}/' + stockCode,
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

    // Filter functionality for stock list
    $('#stockFilter').on('keyup', function() {
        const filter = $(this).val().toLowerCase();
        let visibleCount = 0;
        $('#stockTableBody .stock-row').each(function() {
            const stockCode = $(this).find('.stock-link').text().toLowerCase();
            if (stockCode.includes(filter)) {
                $(this).show();
                visibleCount++;
            } else {
                $(this).hide();
            }
        });
        $('#totalStocks').text(visibleCount);
    });

    // Export CSV functionality
    $('#exportBtn').on('click', function() {
        let csvContent = '\uFEFF'; // UTF-8 BOM for proper encoding
        csvContent += 'Mã chứng khoán\n';
        let count = 0;
        
        $('#stockTableBody .stock-row:visible').each(function() {
            const stockCode = $(this).find('.stock-link').text();
            csvContent += stockCode + '\n';
            count++;
        });
        
        if (count === 0) {
            alert('Không có dữ liệu để export!');
            return;
        }
        
        // Create blob and download
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        
        link.setAttribute('href', url);
        const now = new Date().toISOString().slice(0, 19).replace('T', '_').replace(/:/g, '-');
        link.setAttribute('download', 'CP_tang_cao_2d_' + now + '.csv');
        link.style.visibility = 'hidden';
        
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });
});
</script>
@endsection