<?php
include "db_connct.php";
?>

<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">
  <div class="d-flex align-items-center justify-content-between">
    <a href="#" class="logo d-flex align-items-center">
      <img src="/lib_sys/assets/img/logo1.png" >
      <span class="d-none d-lg-block">Library System</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div><!-- End Logo -->

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">
      <li class="nav-item dropdown pe-3">
        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <img src="assets/img/profile-img.jpg" onerror="this.onerror=null; this.src='../assets/img/profile-img.jpg';"
            alt="Profile" class="rounded-circle">
          <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $_SESSION['username']; ?></span>
        </a><!-- End Profile Image Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6><?php echo $_SESSION['username']; ?></h6> <!-- عرض اسم المستخدم -->
            <span><?php echo $_SESSION['role']; ?></span><!-- عرض صفة المستخدم -->
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li>
            <a class="dropdown-item d-flex align-items-center" href="/lib_sys/logout.php?logout=true">
              <i class="bi bi-box-arrow-right"></i>
              <span>Sign Out</span>
            </a>
          </li>
        </ul><!-- End Profile Dropdown Items -->
      </li><!-- End Profile Nav -->
    </ul>
  </nav>
</header><!-- End Header -->