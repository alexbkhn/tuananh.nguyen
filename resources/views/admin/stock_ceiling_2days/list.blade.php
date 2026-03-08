@extends('layouts.app')

@section('content')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>CP trần 2 ngày liên tiếp <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#infoModal" style="margin-left: 10px;"><i class="fas fa-info-circle"></i></button></h1>
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
                <h3 class="card-title">Biểu đồ giá nến</h3>
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
    let currentIndex = 0;

    // Register zoom plugin
    if (typeof ChartJS !== 'undefined') {
        Chart.register(ChartZoomPlugin);
    }

    // Load chart for first stock
    if ($('.stock-link').length > 0) {
        const firstStock = $('.stock-link').first().data('stock');
        $('.stock-link').first().closest('.stock-row').addClass('active');
        loadCharts(firstStock);
        currentIndex = 0;
    }

    // Keyboard navigation
    $(document).on('keydown', function(e) {
        if (e.key === 'ArrowUp' || e.key === 'ArrowDown') {
            e.preventDefault();
            const visibleRows = $('#stockTableBody .stock-row:visible');
            if (visibleRows.length === 0) return;
            
            if (e.key === 'ArrowUp') {
                currentIndex = currentIndex > 0 ? currentIndex - 1 : visibleRows.length - 1;
            } else {
                currentIndex = currentIndex < visibleRows.length - 1 ? currentIndex + 1 : 0;
            }
            
            // Ensure currentIndex is within bounds
            if (currentIndex >= visibleRows.length) currentIndex = visibleRows.length - 1;
            if (currentIndex < 0) currentIndex = 0;
            
            const selectedRow = visibleRows.eq(currentIndex);
            $('.stock-row').removeClass('active');
            selectedRow.addClass('active');
            
            const stockCode = selectedRow.find('.stock-link').data('stock');
            loadCharts(stockCode);
            
            // Scroll into view
            selectedRow[0].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    });

    // Handle click on stock link
    $('.stock-link').on('click', function(e) {
        e.preventDefault();
        const stockCode = $(this).data('stock');
        
        // Remove active class from all rows
        $('.stock-row').removeClass('active');
        
        // Add active class to clicked row
        $(this).closest('.stock-row').addClass('active');
        
        // Update current index
        const visibleRows = $('#stockTableBody .stock-row:visible');
        currentIndex = visibleRows.index($(this).closest('.stock-row'));
        
        loadCharts(stockCode);
    });

    function loadCharts(stockCode) {
        $.ajax({
            url: '{{ url("admin/stock_ceiling_2days/data") }}/' + stockCode,
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
                            },
                            borderWidth: 2
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
                        candlestick: {
                            fallingColor: { strokeWidth: 1, fill: '#EF553B', stroke: '#EF553B' }, // red for down
                            risingColor: { strokeWidth: 1, fill: '#26C281', stroke: '#26C281' }   // green for up
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
                                display: false
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
        link.setAttribute('download', 'CP_ceiling_2d_' + new Date().getTime() + '.csv');
        link.style.visibility = 'hidden';
        
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });
});
</script>

<!-- Info Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="infoModalLabel">Thông tin điều kiện lọc</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6 class="mb-3"><strong>Tính năng: CP trần 2 ngày liên tiếp mới nhất</strong></h6>
        <p>Danh sách này hiển thị các mã chứng khoán có nến trần trong 2 ngày liên tiếp, được lọc từ dữ liệu 3 ngày gần nhất.</p>
        
        <h6 class="mb-2"><strong>Điều kiện lọc:</strong></h6>
        <ul>
          <li><strong>Nến trần 2 ngày liên tiếp:</strong> Giá đóng cửa = giá cao nhất = giá mở cửa = giá thấp nhất trong 2 ngày liên tiếp</li>
          <li><strong>Giá đóng cửa tăng:</strong> Giá đóng cửa của ngày thứ 2 phải cao hơn ngày thứ 1</li>
          <li><strong>Khối lượng giao dịch:</strong> Khối lượng phải > 1000 cho cả 2 ngày</li>
          <li><strong>Thời gian:</strong> Chỉ xét dữ liệu trong 3 ngày gần nhất</li>
        </ul>
        
        <h6 class="mb-2"><strong>Cách sử dụng:</strong></h6>
        <ul>
          <li>Sử dụng <strong>phím mũi tên lên/xuống</strong> để điều hướng qua danh sách mã</li>
          <li>Biểu đồ giá nến và khối lượng sẽ cập nhật tự động theo mã được chọn</li>
          <li>Dùng ô tìm kiếm để lọc mã chứng khoán theo tên</li>
          <li>Bấm nút <strong>Export CSV</strong> để tải xuống danh sách</li>
        </ul>
        
        <h6 class="mb-2"><strong>Màu sắc biểu đồ:</strong></h6>
        <ul>
          <li><span style="color: #26C281;"><strong>Xanh lá (#26C281):</strong></span> Nến/khối lượng tăng (close >= open)</li>
          <li><span style="color: #EF553B;"><strong>Đỏ (#EF553B):</strong></span> Nến/khối lượng giảm (close < open)</li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>

@endsection