  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('admin/dashboard')}}" class="nav-link">The harder you work, the luckier you get!</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{ url('public/dist/img/paul_tudor_jones.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Paul Jones
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Quy tắc quan trong nhất trong đầu tư chứng khoán là phòng thủ, chứ không phải tấn công</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 1 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{ url('public/dist/img/livermore1.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                Jesse Livermoore
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Kết thúc giao dịch khi thấy rõ xu hướng đang tạo lợi nhuận sắp kết thúc. Chiết khấu 3%!</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 100 Years Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{ url('public/dist/img/livermore1.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Jesse Livermoore
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Gia tăng các giao dịch có tiềm năng lợi nhuận!</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 100 Years Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">3 notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-search-dollar mr-2"></i> Nghiên cứu thị trường
            <span class="float-right text-muted text-sm">Every day</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-book-reader mr-2"></i> Đọc sách
            <span class="float-right text-muted text-sm">Every day</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> Xem Youtube chứng khoán
            <span class="float-right text-muted text-sm">Every day</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->


  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('admin/dashboard')}}" class="brand-link center">
      <img src="{{ url('public/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light" style="font-weight: bold !important;font-size: 20px;">Tuấn Anh</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-16 d-flex">
        <div class="image">
          <img src="{{ url('public/dist/img/ant5.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-item">
            <a href="{{ url('admin/dashboard') }}" class="nav-link @if(Request::segment(2) == 'dashboard') active @endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <!--  Cá nhân -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-business-time"></i>
              <p>
                Cá nhân
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="margin-left: 20px;">
              <li class="nav-item">
                <a href="{{ url('admin/nav_savings/list') }}" class="nav-link">
                  <i class="fa fa-balance-scale nav-icon"></i>
                  <p>Tiền gửi tiết kiệm</p>
                </a>
              </li>
            </ul>
          </li>
          <!--  Chứng khoán -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-business-time"></i>
              <p>
                Chứng khoán
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="margin-left: 20px;">
              <li class="nav-item">
                <a href="{{ url('admin/stock_keeping/list') }}" class="nav-link">
                  <i class="fa fa-briefcase nav-icon"></i>
                  <p>Danh mục đầu tư</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/nav_history/list') }}" class="nav-link">
                  <i class="fa fa-balance-scale nav-icon"></i>
                  <p>Lịch sử vốn</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/stock_history/list') }}" class="nav-link">
                  <i class="fa fa-cart-plus nav-icon"></i>
                  <p>Lịch sử giao dịch</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/stock_company/list') }}" class="nav-link">
                  <i class="fa fa-address-card nav-icon"></i>
                  <p>Công ty chứng khoán</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/stock_ceiling_1day/list') }}" class="nav-link">
                  <i class="fa fa-address-card nav-icon"></i>
                  <p>CP tăng trần 1d</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/stock_ceiling_2days/list') }}" class="nav-link">
                  <i class="fa fa-address-card nav-icon"></i>
                  <p>CP tăng trần 2d</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/stock_highest_2days/list') }}" class="nav-link">
                  <i class="fa fa-address-card nav-icon"></i>
                  <p>CP tăng cao 2d</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/stock_vsa_volume_1vs3d/list') }}" class="nav-link">
                  <i class="fa fa-address-card nav-icon"></i>
                  <p>CP tăng vsa 1vs3d</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- Giao dịch thử nghiệm -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-vial"></i>
              <p>
                Thử nghiệm
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="margin-left: 20px;">
              <li class="nav-item">
                <a href="{{ url('admin/test_stock_keeping/list') }}" class="nav-link">
                  <i class="fa fa-briefcase nav-icon"></i>
                  <p>Danh mục thử nghiệm</p>
                </a>
              </li>
              <!--
              <li class="nav-item">
                <a href="{{ url('admin/test_stock_history/list') }}" class="nav-link">
                  <i class="fa fa-cart-plus nav-icon"></i>
                  <p>Lịch sử giao dịch</p>
                </a>
              </li>
              -->
            </ul>
          </li>
          <!-- Other -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Khác
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="margin-left: 20px;">
              <li class="nav-item">
                <a href="{{ url('admin/note_to_do/list') }}" class="nav-link">
                  <i class="fa fa-list nav-icon"></i>
                  <p>Công việc</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/admin/list') }}" class="nav-link @if(Request::segment(2) == 'admin') active @endif">
                  <i class="nav-icon far fa-user"></i>
                  <p>
                    Account
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/apps/list') }}" class="nav-link">
                  <i class="fa fa-briefcase nav-icon"></i>
                  <p>Ứng dụng chứng khoán</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/price_trading_economics/list') }}" class="nav-link">
                  <i class="fa fa-balance-scale nav-icon"></i>
                  <p>Price - Trading Economics</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ url('logout') }}" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <script>
    // Sidebar state persistence - must run after page load
    document.addEventListener('DOMContentLoaded', function() {
      const sidebarKey = 'adminSidebarMenuState';
      
      // Delay slightly to ensure AdminLTE is initialized
      setTimeout(function() {
        restoreSidebarState();
        setCurrentMenuActive();
        setupMenuListeners();
      }, 500);
      
      function setupMenuListeners() {
        // Listen to AdminLTE treeview events
        $(document).on('expanded.lte.treeview', function(e) {
          saveSidebarState();
        }).on('collapsed.lte.treeview', function(e) {
          saveSidebarState();
        });
      }
      
      function saveSidebarState() {
        const state = {};
        
        // Get all top-level menu items with submenus
        $('.nav-sidebar > .nav-item > .nav-link').each(function() {
          const $parent = $(this).parent('.nav-item');
          const menuText = $(this).find('> p').first().text().trim();
          
          if (menuText && $parent.find('> .nav-treeview').length > 0) {
            state[menuText] = $parent.hasClass('menu-open');
          }
        });
        
        localStorage.setItem(sidebarKey, JSON.stringify(state));
        console.log('Sidebar state saved:', state);
      }
      
      function restoreSidebarState() {
        const savedState = localStorage.getItem(sidebarKey);
        console.log('Restoring sidebar state:', savedState);
        
        if (savedState) {
          try {
            const state = JSON.parse(savedState);
            
            $('.nav-sidebar > .nav-item > .nav-link').each(function() {
              const $parent = $(this).parent('.nav-item');
              const menuText = $(this).find('> p').first().text().trim();
              const $submenu = $parent.find('> .nav-treeview');
              
              if (menuText && $submenu.length > 0) {
                if (state[menuText]) {
                  // Menu should be open
                  $parent.addClass('menu-open');
                  $submenu.css('display', 'block');
                } else {
                  // Menu should be closed
                  $parent.removeClass('menu-open');
                  $submenu.css('display', 'none');
                }
              }
            });
          } catch (e) {
            console.error('Error restoring sidebar state:', e);
          }
        }
      }
      
      function setCurrentMenuActive() {
        const currentPath = window.location.pathname;
        console.log('Current path:', currentPath);
        
        // Mark current page link as active
        $('.nav-sidebar .nav-link[href]').each(function() {
          const href = $(this).attr('href');
          const hrefPath = href.substring(href.indexOf('admin'));
          const currentPagePath = currentPath.substring(currentPath.indexOf('admin'));
          
          if (hrefPath && currentPagePath.includes(hrefPath)) {
            console.log('Found active link:', href);
            $(this).addClass('active');
            
            // Open parent menu
            const $parentTreeview = $(this).closest('.nav-treeview');
            if ($parentTreeview.length > 0) {
              const $parentItem = $parentTreeview.parent('.nav-item');
              $parentItem.addClass('menu-open');
              $parentTreeview.css('display', 'block');
            }
          }
        });
      }
    });
  </script>
