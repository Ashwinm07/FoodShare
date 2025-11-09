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
</head>
<body>

<header class="navbar">
  <div class="logo"><i class="fas fa-utensils"></i> FoodShare Admin</div>
  <nav>
    <a href="logout.php">Logout</a>
  </nav>
</header>

<div class="form-container">
  <h2><i class="fas fa-user-shield"></i> Admin Activity Log</h2>
  <form action="php/log_admin.php" method="POST">
    <input type="text" name="name" placeholder="Admin Name" value="<?php echo $_SESSION['Name']; ?>" required>
    <input type="email" name="email" placeholder="Admin Email" required>
    <textarea name="activity" placeholder="Describe activity..." required></textarea>
    <button type="submit" class="btn">Save Log</button>
  </form>
</div>

<section class="table-section">
  <h2>📦 Pending Food Requests</h2>
  <iframe src="php/admin_view_requests.php" width="100%" height="300" style="border:none; border-radius:10px;"></iframe>
</section>

<section class="table-section">
  <h2>🚚 Volunteer Information</h2>
  <iframe src="php/view_volunteers.php" width="100%" height="300" style="border:none; border-radius:10px;"></iframe>
</section>

<section class="table-section">
  <h2>📝 Activity History</h2>
  <iframe src="php/view_admin_logs.php" width="100%" height="300" style="border:none; border-radius:10px;"></iframe>
</section>

<footer>
  <p>© 2025 Community Food Sharing | Admin Panel</p>
</footer>

</body>
</html>
