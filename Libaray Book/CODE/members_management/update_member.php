<?php
include "head.php";
include "../db_connct.php";
// تحقق إذا كان المستخدم قد سجل الدخول
if (!isset($_SESSION['user_id'])) {
  // إذا لم يكن قد سجل الدخول، أعد التوجيه إلى صفحة الولوج
  header("Location: /lib_sys/index.php");  // أو رابط صفحة الولوج الخاصة بك
  exit();  // تأكد من توقف السكربت بعد إعادة التوجيه
}
// التحقق من وجود معرّف المستخدم
if (isset($_GET['userid'])) {
  $userid = intval($_GET['userid']);

  // جلب بيانات العضو من قاعدة البيانات
  $query = "SELECT * FROM users WHERE userid = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $userid);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $member = $result->fetch_assoc();
  } else {
    echo '<script>
            alert("Member not found.");
            window.location.href = "show.php";
        </script>';
    exit;
  }
} else {
  echo '<script>
        alert("Invalid request.");
        window.location.href = "show.php";
    </script>';
  exit;
}

// عند إرسال النموذج
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['username']);
  $address = trim($_POST['address']);
  $phone = trim($_POST['phone']);
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  if (!empty($name) && !empty($address) && !empty($phone) && !empty($email) && !empty($password)) {
    $updateQuery = "UPDATE users SET username = ?, address = ?, phone = ?, email = ?, password = ? WHERE userid = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("sssssi", $name, $address, $phone, $email, $password, $userid);

    if ($updateStmt->execute()) {
      echo '<script>
                alert("Member updated successfully!");
                window.location.href = "show.php";
            </script>';
      exit;
    } else {
      echo '<script>
                alert("Error updating member.");
            </script>';
    }
  } else {
    echo '<script>
            alert("All fields are required.");
        </script>';
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<body>
  <?php include "../header.php"; ?>
  <?php include("../sidebar.php"); ?>
  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Update Member</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
          <li class="breadcrumb-item active">Management Members</li>
          <li class="breadcrumb-item active">Update Member</li>
        </ol>
      </nav>
    </div>
    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-8">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Update Member</h5>
              <!-- Update member form -->
              <form method="POST" action="">
                <div class="row mb-3">
                  <label for="name" class="col-sm-2 col-form-label">Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="username" name="username"
                      value="<?= htmlspecialchars($member['username']) ?>" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="address" class="col-sm-2 col-form-label">Address</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="address" name="address"
                      value="<?= htmlspecialchars($member['address']) ?>" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="phone" name="phone"
                      value="<?= htmlspecialchars($member['phone']) ?>" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="email" class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" name="email"
                      value="<?= htmlspecialchars($member['email']) ?>" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="password" class="col-sm-2 col-form-label">Password</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="password" name="password"
                      value="<?= htmlspecialchars($member['password']) ?>" required>
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Save</button>
                  <a href="show.php" class="btn btn-secondary">Cancel</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</body>

</html>