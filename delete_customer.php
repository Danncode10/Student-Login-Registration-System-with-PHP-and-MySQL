<?php
session_start();
require_once "config.php";

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Check if ID is passed
if (!isset($_GET['id'])) {
    header("Location: customers.php");
    exit;
}

$id = $_GET['id'];

// Optional: prevent deleting yourself
// if ($id == $_SESSION['customer_id']) {
//     header("Location: customers.php?error=cannot_delete_yourself");
//     exit;
// }

// Delete the customer
$stmt = $pdo->prepare("DELETE FROM customers WHERE id = ?");
$stmt->execute([$id]);

// Redirect back to dashboard
header("Location: customers.php");
exit;
?>
