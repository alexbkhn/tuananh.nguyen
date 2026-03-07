@extends('layouts.app')

@section('content')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Mã chứng khoán tăng giá 3 ngày liên tiếp - 90 ngày gần nhất</h1>
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
                <h3 class="card-title">Biểu đồ giá nến - 90 ngày gần nhất</h3>
              </div>
              <div class="card-body" style="padding: 5px;">
                <div style="position: relative; height: 400px; width: 100%;">
                  <canvas id="priceChart"></canvas>
                </div>
              </div>
            </div>
            <div class="card card-info" style="margin-top: 10px;">
              <div class="card-header">
                <h3 class="card-title">Khối lượng giao dịch</h3>
              </div>
              <div class="card-body" style="padding: 5px;">
                <div style="position: relative; height: 180px; width: 100%;">
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

@endsection

@section('scripts')
<style>
  .stock-row.active {
    background-color: #fff3cd !important;
    font-weight: bold;
  }
</style>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@2.0.1/dist/chartjs-plugin-zoom.min.js"></script>
<script>
$(document).ready(function() {
    let priceChart, volumeChart;

    // Register zoom plugin
    if (typeof ChartJS !== 'undefined') {
        Chart.register(ChartZoomPlugin);
    }

    // Load chart for first stock
    if ($('.stock-link').length > 0) {
        const firstStock = $('.stock-link').first().data('stock');
        $('.stock-link').first().closest('.stock-row').addClass('active');
        loadCharts(firstStock);
    }

    // Handle click on stock link
    $('.stock-link').on('click', function(e) {
        e.preventDefault();
        const stockCode = $(this).data('stock');
        
        // Remove active class from all rows
        $('.stock-row').removeClass('active');
        
        // Add active class to clicked row
        $(this).closest('.stock-row').addClass('active');
        
        loadCharts(stockCode);
    });

    function loadCharts(stockCode) {
        $.ajax({
            url: '{{ url("admin/stock_increasing_3days/data") }}/' + stockCode,
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

                // Create price chart with zoom plugin
                const priceCtx = document.getElementById('priceChart').getContext('2d');
                priceChart = new Chart(priceCtx, {
                    type: 'candlestick',
                    data: {
                        labels: commonLabels,
                        datasets: [{
                            label: stockCode + ' (Nến giá)',
                            data: priceData,
                            color: {
                                up: '#26C281',
                                down: '#EF553B',
                                unchangedColor: '#999'
                            },
                            borderColor: {
                                up: '#26C281',
                                down: '#EF553B',
                                unchangedColor: '#999'
                            }
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        plugins: {
                            zoom: {
                                zoom: {
                                    wheel: {
                                        enabled: true,
                                        speed: 0.1
                                    },
                                    pinch: {
                                        enabled: true
                                    },
                                    mode: 'x'
                                },
                                pan: {
                                    enabled: true,
                                    mode: 'x'
                                },
                                limits: {
                                    x: {min: 'original', max: 'original'},
                                    y: {min: 'original', max: 'original'}
                                }
                            },
                            legend: {
                                display: true,
                                labels: { 
                                    font: { size: 12 },
                                    padding: 15
                                }
                            }
                        },
                        scales: {
                            x: {
                                type: 'category',
                                display: true,
                                offset: false,
                                title: { display: false },
                                ticks: { 
                                    font: { size: 10 },
                                    maxRotation: 45,
                                    minRotation: 0,
                                    autoSkip: true,
                                    maxTicksLimit: 20
                                },
                                grid: { 
                                    display: false, 
                                    drawBorder: false,
                                    color: 'rgba(200, 200, 200, 0.2)'
                                }
                            },
                            y: { 
                                title: { display: false },
                                beginAtZero: false,
                                position: 'right',
                                grid: { 
                                    display: false, 
                                    drawBorder: false,
                                    color: 'rgba(200, 200, 200, 0.2)'
                                },
                                ticks: { 
                                    font: { size: 10 },
                                    display: false
                                }
                            }
                        }
                    }
                });

                // Create volume chart with zoom plugin
                const volumeCtx = document.getElementById('volumeChart').getContext('2d');
                volumeChart = new Chart(volumeCtx, {
                    type: 'bar',
                    data: {
                        labels: commonLabels,
                        datasets: [
                            {
                                label: 'Tăng',
                                data: upVolume,
                                backgroundColor: '#26C281',
                                borderColor: '#26C281',
                                borderWidth: 0,
                                categoryPercentage: 0.8,
                                barPercentage: 0.8
                            },
                            {
                                label: 'Giảm',
                                data: downVolume,
                                backgroundColor: '#EF553B',
                                borderColor: '#EF553B',
                                borderWidth: 0,
                                categoryPercentage: 0.8,
                                barPercentage: 0.8
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        plugins: { 
                            zoom: {
                                zoom: {
                                    wheel: {
                                        enabled: true,
                                        speed: 0.1
                                    },
                                    pinch: {
                                        enabled: true
                                    },
                                    mode: 'x'
                                },
                                pan: {
                                    enabled: true,
                                    mode: 'x'
                                },
                                limits: {
                                    x: {min: 'original', max: 'original'},
                                    y: {min: 'original', max: 'original'}
                                }
                            },
                            legend: { 
                                display: true,
                                position: 'top',
                                labels: { 
                                    font: { size: 11 },
                                    padding: 10
                                }
                            } 
                        },
                        scales: {
                            x: {
                                type: 'category',
                                offset: false,
                                title: { display: false },
                                stacked: true,
                                ticks: { 
                                    font: { size: 9 }, 
                                    maxRotation: 45, 
                                    minRotation: 0, 
                                    autoSkip: true,
                                    maxTicksLimit: 20
                                },
                                grid: { 
                                    display: false, 
                                    drawBorder: false,
                                    color: 'rgba(200, 200, 200, 0.2)'
                                }
                            },
                            y: { 
                                stacked: true,
                                title: { display: false },
                                beginAtZero: true,
                                position: 'right',
                                grid: { 
                                    display: false, 
                                    drawBorder: false,
                                    color: 'rgba(200, 200, 200, 0.2)'
                                },
                                ticks: { 
                                    font: { size: 9 },
                                    display: false
                                }
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
        link.setAttribute('download', 'CP_tang_3d_' + now + '.csv');
        link.style.visibility = 'hidden';
        
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });
});
</script>
@endsection