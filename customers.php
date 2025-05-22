<?php
session_start();
require_once "config.php";

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Fetch all customers
$stmt = $pdo->prepare("SELECT * FROM customers ORDER BY id DESC");
$stmt->execute();
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Customer Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #09203f, #537895);
      min-height: 100vh;
      color: white;
    }
    .container {
      margin-top: 60px;
    }
    .card {
      background-color: rgba(0, 0, 0, 0.75);
      border-radius: 1rem;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card p-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Customer Dashboard</h2>
        <a href="logout.php" class="btn btn-danger">Logout</a>
      </div>

      <div class="mb-3">
        <a href="register.php" class="btn btn-success">➕ Add New Customer</a>
      </div>

      <div class="table-responsive">
        <table class="table table-dark table-striped table-hover text-center">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Gender</th>
              <th>Location</th>
              <th>Username</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($customers): ?>
              <?php foreach ($customers as $row): ?>
                <tr>
                  <td><?= htmlspecialchars($row['id']) ?></td>
                  <td><?= htmlspecialchars($row['name']) ?></td>
                  <td><?= htmlspecialchars($row['gender']) ?></td>
                  <td><?= htmlspecialchars($row['location']) ?></td>
                  <td><?= htmlspecialchars($row['username']) ?></td>
                  <td>
                    <a href="view_customer.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info">View</a>
                    <a href="edit_customer.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete_customer.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this customer?')">Delete</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="6">No customers found.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
