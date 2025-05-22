<?php
session_start();
require_once "config.php";

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Check if ID is present
if (!isset($_GET['id'])) {
    header("Location: customers.php");
    exit;
}

$id = $_GET['id'];

// Fetch customer details
$stmt = $pdo->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->execute([$id]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

// If no customer found
if (!$customer) {
    header("Location: customers.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Customer</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #373B44, #4286f4);
      color: white;
      min-height: 100vh;
    }
    .container {
      margin-top: 60px;
    }
    .card {
      background-color: rgba(255, 255, 255, 0.75);
      border-radius: 1rem;
      padding: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <a href="customers.php" class="btn btn-light mb-4">← Back to Dashboard</a>

    <div class="card">
      <h2 class="mb-4">Customer Details</h2>
      <p><strong>Full Name:</strong> <?= htmlspecialchars($customer['name']) ?></p>
      <p><strong>Gender:</strong> <?= htmlspecialchars($customer['gender']) ?></p>
      <p><strong>Location:</strong> <?= htmlspecialchars($customer['location']) ?></p>
      <p><strong>Username:</strong> <?= htmlspecialchars($customer['username']) ?></p>
    </div>
  </div>
</body>
</html>
