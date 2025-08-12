<?php

include 'db_connct.php';

if (isset($_POST['email']) && isset($_POST['password'])) {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  // Query the user table
  $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    // Save user data in session
    $_SESSION['user_id'] = $row['userid'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['role'] = $row['role'];

    // Redirect based on the role
    if ($row['role'] === 'admin') {
      header("Location: home.php");
    } elseif ($row['role'] === 'Members') {
      header("Location: /lib_sys/Member_page/index.php");
    } elseif ($row['role'] === 'Employee') {
      header("Location: home.php");
    } else {
      header("Location: index.php");
    }
    exit();
  } else {
    $error = "Invalid email or password!";
  }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Login</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
              <a href="index.html" class="logo d-flex align-items-center w-auto">
                <img src="assets/img/logo1.png"  alt="" >
                <span class="d-none d-lg-block">Library System</span>
              </a>
              <br>
              <div class="card mb-3">
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Please Log in to your Account to use the System</p>
                  </div>
                  <?php if (isset($error)): ?>
                    <div class="alert alert-danger text-center"> <?php echo $error; ?> </div>
                  <?php endif; ?>
                  <form class="row g-3 needs-validation" method="POST" novalidate>
                    <div class="col-12">
                      <label for="youremail" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="email" name="email" class="form-control" id="youremail" required>
                        <div class="invalid-feedback">Please enter your email.</div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>

</html>