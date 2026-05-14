  <!-- Topbar -->
  <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

      <!-- Sidebar Toggle (Topbar) -->
      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
          <i class="fa fa-bars"></i>
      </button>

      <!-- Topbar Search -->
      <form
          class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
          <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                  aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                  <button class="btn btn-primary" type="button">
                      <i class="fas fa-search fa-sm"></i>
                  </button>
              </div>
          </div>
      </form>

      <!-- Topbar Navbar -->
      <ul class="navbar-nav ml-auto">

          <!-- Nav Item - Search Dropdown (Visible Only XS) -->
          <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                  aria-labelledby="searchDropdown">
                  <form class="form-inline mr-auto w-100 navbar-search">
                      <div class="input-group">
                          <input type="text" class="form-control bg-light border-0 small"
                              placeholder="Search for..." aria-label="Search"
                              aria-describedby="basic-addon2">
                          <div class="input-group-append">
                              <button class="btn btn-primary" type="button">
                                  <i class="fas fa-search fa-sm"></i>
                              </button>
                          </div>
                      </div>
                  </form>
              </div>
          </li>

          <!-- Nav Item - Alerts -->
          <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-bell fa-fw"></i>
                  <!-- Counter - Alerts -->
                  <span class="badge badge-danger badge-counter" id="alertCounter">
                      <?= isset($alerts) && count($alerts) > 0 ? count($alerts) . '+' : '0' ?>
                  </span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                  <h6 class="dropdown-header">
                      Alerts Center
                  </h6>
                  <div id="alertList">
                      <?php if (!empty($alerts)): ?>
                          <?php foreach ($alerts as $alert): ?>
                              <a class="dropdown-item d-flex align-items-center" href="#" id="alert-<?= $alert['id'] ?>">
                                  <div class="mr-3">
                                      <div class="icon-circle bg-primary">
                                          <i class="fas fa-file-alt text-white"></i>
                                      </div>
                                  </div>
                                  <div>
                                      <div class="small text-gray-500"><?= date('F j, Y', strtotime($alert['created_at'])) ?></div>
                                      <span class="font-weight-bold"><?= $alert['first_name'] ?> <?= $alert['last_name'] ?> has a new alert!</span>
                                  </div>
                                  <!-- ปุ่มปิด -->
                                  <button class="close" type="button" onclick="closeAlert(<?= $alert['id'] ?>)">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                              </a>
                          <?php endforeach; ?>
                      <?php else: ?>
                          <div class="dropdown-item text-center text-gray-500">ไม่มีการแจ้งเตือน</div>
                      <?php endif; ?>
                  </div>
                  <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
              </div>
          </li>

          <!-- jQuery (for AJAX) -->
          <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
          <script>
              // ฟังก์ชันสำหรับอัปเดตการแจ้งเตือน
              function updateAlerts() {
                  $.ajax({
                      url: '/home/getAlertsAjax', // URL สำหรับดึงข้อมูลการแจ้งเตือน
                      method: 'GET',
                      success: function(data) {
                          if (Array.isArray(data)) {
                              // อัปเดตจำนวนการแจ้งเตือน
                              $('#alertCounter').text(data.length > 0 ? data.length + '+' : '0');

                              // เคลียร์การแจ้งเตือนเก่าใน dropdown
                              $('#alertList').empty();

                              // แสดงการแจ้งเตือนใหม่
                              if (data.length === 0) {
                                  $('#alertList').append('<div class="dropdown-item text-center text-gray-500">ไม่มีการแจ้งเตือน</div>');
                              } else {
                                  data.forEach(function(alert) {
                                      var alertHtml = `
                                <a class="dropdown-item d-flex align-items-center" href="#" id="alert-${alert.id}">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">${alert.created_at}</div>
                                        <span class="font-weight-bold">${alert.first_name} ${alert.last_name} ลงทะเบียนว่างงาน!</span>
                                    </div>
                                    <button class="close" type="button" onclick="closeAlert(${alert.id})">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </a>
                            `;
                                      $('#alertList').append(alertHtml);
                                  });
                              }
                          } else {
                              console.error('Unexpected data format:', data);
                          }
                      },
                      error: function() {
                          console.error('Error fetching alerts.');
                      }
                  });
              }
              // อัปเดตข้อมูลแจ้งเตือนทุกๆ 5 วินาที
              setInterval(updateAlerts, 5000);
          </script>

          <div class="topbar-divider d-none d-sm-block"></div>

          <?php
            $session = session();
            ?>
          <!-- Nav Item - User Information -->
          <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo htmlspecialchars($session->get('em_fullname')); ?></span>
                  <img class="img-profile rounded-circle"
                      src="<?= base_url('uploads/' . session()->get('em_pic')) ?>"
                      alt="Profile Picture">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                  aria-labelledby="userDropdown">
                  <a class="dropdown-item" href="<?= base_url('/employeecontroller/profile') ?>">
                      <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                      Profile
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="<?= base_url('/logout') ?>">
                      <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                      Logout
                  </a>
              </div>
          </li>

      </ul>

  </nav>
  <!-- End of Topbar -->