<?php
include "db_connct.php";
?>
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="home.php">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">

      <!-- Left side columns -->
      <div class="col-lg-8">
        <div class="row">

        
          <div class="col-xxl-4 col-md-6">

            <div class="card info-card sales-card">
              <div class="card-body">
                <h5 class="card-title">Number of <span>| Books</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fas fa-book"></i>
                  </div>
                  <div class="ps-3">
                    <?php
                    //   لحساب عدد الكتب
                    $query = "SELECT COUNT(*) AS total_books FROM books;";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    $total_books = $row['total_books'];
                    ?>
                    <h6><?php echo $total_books; ?></h6>
                    <span class="text-success small pt-1 fw-bold"></span> <span
                      class="text-muted small pt-2 ps-1">Book</span>

                  </div>
                </div>
              </div>

            </div>
          </div>

          
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card">

              <div class="card-body">
                <h5 class="card-title">Number of <span>| Borrowers</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fas fa-exchange-alt"></i>
                  </div>
                  <div class="ps-3">
                    <!-- <?php
                    // لحساب عدد الاستعارات 
                    $query = "SELECT COUNT(*) AS total_Borrowers FROM borrowedbooks;";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    $total_Borrowers = $row['total_Borrowers'];
                    ?>
                    <h6><?php echo $total_Borrowers; ?></h6> -->
                    <!-- نهاية الاستعلام للمستعيرين -->

                    <span class="text-success small pt-1 fw-bold"></span> <span
                      class="text-muted small pt-2 ps-1">Borrower</span>

                  </div>
                </div>
              </div>

            </div>
          </div><!-- end -->

          <!--  -->
          <div class="col-xxl-4 col-xl-12">

            <div class="card info-card customers-card">

              <div class="card-body">
                <h5 class="card-title">Number of <span>| Members</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="ps-3">
                    <?php
                    // لحساب عدد الاعضاء 
                    $query = "SELECT COUNT(*) AS total_members FROM users WHERE role = 'members'";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    $total_members = $row['total_members'];
                    ?>
                    <h6><?php echo $total_members; ?></h6>
                    <!-- نهاية الاستعلام لعدد الاعضاء -->

                    <span class="text-danger small pt-1 fw-bold"></span> <span
                      class="text-muted small pt-2 ps-1">Member</span>

                  </div>
                </div>

              </div>
            </div>

          </div>


        </div>
     
  </section>

</main><!-- End #main -->