<?php
session_start();
require_once "config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $username;
        header("Location: home.php");
        exit;
    } else {
        $message = "❌ Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg,rgb(44, 6, 214), #928dab);
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

              <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
              <p class="text-white-50 mb-4">Please enter your username and password</p>

              <?php if (!empty($message)): ?>
                <div class="alert alert-danger"><?= $message ?></div>
              <?php endif; ?>

              <form method="post" action="">

                <div class="form-outline form-white mb-4 text-start">
                  <label class="form-label">Username</label>
                  <input type="text" name="username" class="form-control form-control-lg" required />
                </div>

                <div class="form-outline form-white mb-4 text-start">
                  <label class="form-label">Password</label>
                  <input type="password" name="password" class="form-control form-control-lg" required />
                </div>

                <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
              </form>

            </div>

            <div>
              <p class="mb-0">Don't have an account? <a href="register.php" class="text-white-50 fw-bold">Register here</a></p>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>
