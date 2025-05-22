<?php
session_start();
require_once "config.php";

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Fetch all customers
$stmt = $pdo->prepare("SELECT * FROM customers ORDER BY id DESC");
$stmt->execute();
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Count by gender
$genderData = $pdo->query("SELECT gender, COUNT(*) as count FROM customers GROUP BY gender")->fetchAll(PDO::FETCH_ASSOC);

// Count by location
$locationData = $pdo->query("SELECT location, COUNT(*) as count FROM customers GROUP BY location")->fetchAll(PDO::FETCH_ASSOC);
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
        <h2 style="color: white; text-align: left;">Customer Dashboard</h2>
        <div>
            <a href="home.php" class="btn btn-secondary me-2">🏠 Home</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
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

    <!-- Charts Section -->
    <div class="card mt-5 p-4">
      <h3 class="mb-4 text-white">Customer Analytics</h3>
      <div class="row">
        <div class="col-md-6">
          <canvas id="genderChart"></canvas>
        </div>
        <div class="col-md-6">
          <canvas id="locationChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Chart.js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const genderCtx = document.getElementById('genderChart').getContext('2d');
    const locationCtx = document.getElementById('locationChart').getContext('2d');

    const genderChart = new Chart(genderCtx, {
      type: 'pie',
      data: {
        labels: <?= json_encode(array_column($genderData, 'gender')) ?>,
        datasets: [{
          label: 'Gender Distribution',
          data: <?= json_encode(array_column($genderData, 'count')) ?>,
          backgroundColor: ['#007bff', '#dc3545', '#ffc107'],
          borderWidth: 1
        }]
      },
      options: {
        plugins: {
          legend: {
            labels: { color: 'white' }
          }
        }
      }
    });

    const locationChart = new Chart(locationCtx, {
      type: 'bar',
      data: {
        labels: <?= json_encode(array_column($locationData, 'location')) ?>,
        datasets: [{
          label: 'Customers per Location',
          data: <?= json_encode(array_column($locationData, 'count')) ?>,
          backgroundColor: '#28a745',
          borderRadius: 5
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
            ticks: { color: 'white' }
          },
          x: {
            ticks: { color: 'white' }
          }
        },
        plugins: {
          legend: {
            labels: { color: 'white' }
          }
        }
      }
    });
  </script>
</body>
</html>
