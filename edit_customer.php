<?php
session_start();
require_once "config.php";

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Get customer ID from URL
if (!isset($_GET['id'])) {
    header("Location: customers.php");
    exit;
}

$id = $_GET['id'];
$message = "";

// Fetch customer data
$stmt = $pdo->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->execute([$id]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

// If no customer found
if (!$customer) {
    header("Location: customers.php");
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = trim($_POST["name"]);
    $gender   = $_POST["gender"];
    $location = trim($_POST["location"]);
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    // If password field is not empty, hash and update it
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE customers SET name=?, gender=?, location=?, username=?, password=? WHERE id=?");
        $updated = $stmt->execute([$name, $gender, $location, $username, $hashedPassword, $id]);
    } else {
        // Don't update password
        $stmt = $pdo->prepare("UPDATE customers SET name=?, gender=?, location=?, username=? WHERE id=?");
        $updated = $stmt->execute([$name, $gender, $location, $username, $id]);
    }

    if ($updated) {
        $message = '<div class="alert alert-success">✅ Customer updated successfully.</div>';
        // Refresh customer data
        $stmt = $pdo->prepare("SELECT * FROM customers WHERE id = ?");
        $stmt->execute([$id]);
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $message = '<div class="alert alert-danger">❌ Error updating customer.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Customer</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #28313B, #485563);
      color: white;
      min-height: 100vh;
    }
    .container {
      margin-top: 60px;
    }
    .card {
      background-color: rgba(255, 255, 255, 0.85);
      color: black;
      border-radius: 1rem;
      padding: 20px;
    }
  </style>
</head>
<body>
<div class="container">
  <a href="customers.php" class="btn btn-light mb-4">← Back to Dashboard</a>

  <div class="card">
    <h2 class="mb-4">Edit Customer</h2>
    <?= $message ?>

    <form method="post" action="">
      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($customer['name']) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-select" required>
          <option value="Male"   <?= $customer['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
          <option value="Female" <?= $customer['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
          <option value="Other"  <?= $customer['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Location</label>
        <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($customer['location']) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($customer['username']) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">New Password (leave blank to keep current)</label>
        <input type="password" name="password" class="form-control">
      </div>

      <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
  </div>
</div>
</body>
</html>
