<?php
include "db_connct.php";
$currentPage = $currentPage ?? '';
$subPage = $subPage ?? '';
?>

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
      <a class="nav-link <?= ($currentPage === 'home') ? '' : 'collapsed' ?>" href="/lib_sys/home.php">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <!-- إدارة الكتب -->
    <li class="nav-item">
      <a class="nav-link <?= ($currentPage === 'book-management') ? '' : 'collapsed' ?>"
        data-bs-target="#book-management-nav" data-bs-toggle="collapse" href="#">
        <i class="fas fa-book"></i>
        <span>Book Management</span>
        <i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="book-management-nav"
        class="nav-content collapse <?= ($currentPage === 'book-management') ? 'show' : '' ?>"
        data-bs-parent="#sidebar-nav">
        <li>
          <a href="/lib_sys/book_management/show.php" class="<?= ($subPage === 'show') ? 'active' : '' ?>">
            <i class="bi bi-circle"></i><span>Show Books</span>
          </a>
        </li>
        <li>
          <a href="/lib_sys/book_management/add.php" class="<?= ($subPage === 'add') ? 'active' : '' ?>">
            <i class="bi bi-circle"></i><span>Add Book</span>
          </a>
        </li>
      </ul>
    </li>
    <li class="nav-item">
      <a class="nav-link <?= ($currentPage === 'borrowing_management') ? '' : 'collapsed' ?>"
        data-bs-target="#borrowing-management-nav" data-bs-toggle="collapse" href="#">
        <i class="fas fa-exchange-alt"></i>
        <span>Borrowing Management</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="borrowing-management-nav"
        class="nav-content collapse <?= ($currentPage === 'borrowing_management') ? 'show' : '' ?>"
        data-bs-parent="#sidebar-nav">
        <li>
          <a href="/lib_sys/borrowing_management/view_loan.php"
            class="<?= ($subPage === 'view_loan') ? 'active' : '' ?>">
            <i class="bi bi-circle"></i>
            <span>Show Borrowers</span>
          </a>
        </li>
        <li>
          <a href="/lib_sys/borrowing_management/add_loan.php" 
          class="<?= ($subPage === 'add_loan') ? 'active' : '' ?>">
            <i class="bi bi-circle"></i><span>Add Borrower</span>
          </a>
        </li>
      </ul>
    </li><!-- End Borrowing Management Nav -->

    <li class="nav-item">
      <a class="nav-link <?= ($currentPage === 'categories_management') ? '' : 'collapsed' ?>"
        data-bs-target="#categories-management-nav" data-bs-toggle="collapse" href="#">
        <i class="fas fa-th-list"></i>
        <span>Categories Management</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="categories-management-nav"
        class="nav-content collapse <?= ($currentPage === 'categories_management') ? 'show' : '' ?>"
        data-bs-parent="#sidebar-nav">
        <li>
          <a href="/lib_sys/categories_management/show.php"
            class="<?= ($subPage === 'show_categories') ? 'active' : '' ?>">
            <i class="bi bi-circle"></i>
            <span>Show Categories</span>
          </a>
        </li>
        <li>
          <a href="/lib_sys/categories_management/add.php"
            class="<?= ($subPage === 'add_categories') ? 'active' : '' ?>">
            <i class="bi bi-circle"></i><span>Add Category</span>
          </a>
        </li>
      </ul>
    </li><!-- End Categories Management Nav -->

    <li class="nav-item">
      <a class="nav-link <?= ($currentPage === 'members_management') ? '' : 'collapsed' ?>"
        data-bs-target="#members-management-nav" data-bs-toggle="collapse" href="#">
        <i class="fas fa-users"></i>
        <span>Members Management</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="members-management-nav"
        class="nav-content collapse <?= ($currentPage === 'members_management') ? 'show' : '' ?>"
        data-bs-parent="#sidebar-nav">
        <li>
          <a href="/lib_sys/members_management/show.php" class="<?= ($subPage === 'show_members') ? 'active' : '' ?>">
            <i class="bi bi-circle"></i><span>Show Members</span>
          </a>
        </li>
        <li>
          <a href="/lib_sys/members_management/add.php" class="<?= ($subPage === 'add_members') ? 'active' : '' ?>">
            <i class="bi bi-circle"></i><span>Add Member</span>
          </a>
        </li>
      </ul>
    </li><!-- End Members Management Nav -->


    <?php
    if ($_SESSION['role'] === 'admin') {
      echo '
    <!-- Employees Management -->
    <li class="nav-item">
        <a class="nav-link ' . (($currentPage === 'employees-management') ? '' : 'collapsed') . '" data-bs-target="#employees-management-nav" data-bs-toggle="collapse" href="#">
            <i class="fas fa-users"></i>
            <span>Employees Management</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="employees-management-nav" class="nav-content collapse ' . (($currentPage === 'employees-management') ? 'show' : '') . '" data-bs-parent="#sidebar-nav">
            <li>
                <a href="/lib_sys/employee_management/show.php" class="' . (($subPage === 'show_employees') ? 'active' : '') . '">
                    <i class="bi bi-circle"></i><span>Show Employees</span>
                </a>
            </li>
            <li>
                <a href="/lib_sys/employee_management/add.php" class="' . (($subPage === 'add_employees') ? 'active' : '') . '">
                    <i class="bi bi-circle"></i><span>Add Employee</span>
                </a>
            </li>
      
        </ul>
    </li>';
    }
    ?>

  </ul>
</aside>