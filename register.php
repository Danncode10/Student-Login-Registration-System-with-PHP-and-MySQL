<?php
require_once "config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = trim($_POST["name"]);
    $gender   = $_POST["gender"];
    $location = trim($_POST["location"]);
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    // Check if username already exists
    $stmt = $pdo->prepare("SELECT * FROM customers WHERE username = ?");
    $stmt->execute([$username]);
    $existingCustomer = $stmt->fetch();

    if ($existingCustomer) {
        $message = '<div class="alert alert-danger">⚠️ Username already exists.</div>';
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO customers (name, gender, location, username, password) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$name, $gender, $location, $username, $hashedPassword])) {
            $message = '<div class="alert alert-success">✅ Registration successful. <a href="index.php" class="alert-link">Login now</a>.</div>';
        } else {
            $message = '<div class="alert alert-danger">❌ Error during registration.</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #1f1c2c, #928dab);
    }
  </style>
</head>
<body>
<section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <div class="mb-md-5 mt-md-4 pb-3">
              <h2 class="fw-bold mb-2 text-uppercase">Register</h2>
              <p class="text-white-50 mb-4">Create your account below</p>

              <?= $message ?>

              <form method="post" action="">

                <div class="form-outline form-white mb-3 text-start">
                  <label class="form-label">Full Name</label>
                  <input type="text" name="name" class="form-control form-control-lg" required />
                </div>

                <div class="form-outline form-white mb-3 text-start">
                  <label class="form-label">Gender</label>
                  <select name="gender" class="form-select form-select-lg" required>
                    <option value="">Select gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                  </select>
                </div>

                <div class="form-outline form-white mb-3 text-start">
                  <label class="form-label">Location</label>
                  <input type="text" name="location" class="form-control form-control-lg" required />
                </div>

                <div class="form-outline form-white mb-3 text-start">
                  <label class="form-label">Username</label>
                  <input type="text" name="username" class="form-control form-control-lg" required />
                </div>

                <div class="form-outline form-white mb-4 text-start">
                  <label class="form-label">Password</label>
                  <input type="password" name="password" class="form-control form-control-lg" required />
                </div>

                <button class="btn btn-outline-light btn-lg px-5" type="submit">Register</button>
              </form>
            </div>

            <div>
              <p class="mb-0">Already have an account? <a href="index.php" class="text-white-50 fw-bold">Login here</a></p>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>
