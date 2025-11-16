<?php
include('php/db_connect.php');
if (!isset($_SESSION['UserID']) || $_SESSION['Role'] != 'Admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - FoodShare</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <style>
    /* New styles for tab-like structure */
    .dashboard-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    .status-section {
        margin-top: 30px;
        border: 1px solid #ddd;
        border-radius: 10px;
        overflow: hidden;
        padding-bottom: 20px;
    }
    .status-section h2 {
        background-color: #27ae60;
        color: white;
        padding: 15px;
        margin: 0;
        font-size: 1.5em;
        text-align: center;
    }
    .status-section iframe {
        display: block;
        margin-top: 15px;
    }
  </style>
</head>
<body>

<header class="navbar">
  <div class="logo"><i class="fas fa-user-shield"></i> FoodShare Admin</div>
  <nav>
    <a href="logout.php">Logout</a>
  </nav>
</header>

<div class="dashboard-container">
  
  <section class="status-section">
    <h2>📦 Pending Requests (Awaiting Acceptance)</h2>
    <!-- This iframe shows requests where Status = 'Pending' -->
    <iframe src="php/admin_view_pending.php" width="100%" height="300" style="border:none;"></iframe>
  </section>
  
  <section class="status-section" style="border-color:#2980b9;">
    <h2>🚚 In Progress (Accepted, Assigned, Picked Up)</h2>
    <!-- This iframe shows requests assigned to a volunteer -->
    <iframe src="php/admin_view_in_progress.php" width="100%" height="400" style="border:none;"></iframe>
  </section>

  <section class="status-section" style="border-color:#555;">
    <h2>✅ Delivered / Done</h2>
    <!-- This iframe shows completed requests -->
    <iframe src="php/admin_view_delivered.php" width="100%" height="300" style="border:none;"></iframe>
  </section>

  <section class="table-section">
    <h2>🧑‍💻 Volunteer Information</h2>
    <iframe src="php/view_volunteers.php" width="100%" height="300" style="border:none; border-radius:10px;"></iframe>
  </section>
  
  <section class="table-section">
    <h2>📝 Automatic Activity History</h2>
    <iframe src="php/view_admin_logs.php" width="100%" height="300" style="border:none; border-radius:10px;"></iframe>
  </section>

</div>

<footer>
  <p>© 2025 Community Food Sharing | Admin Panel</p>
</footer>

</body>
</html>