<?php
include('php/db_connect.php');
if (!isset($_SESSION['UserID']) || $_SESSION['Role'] != 'Donor') {
    header("Location: login.php");
    exit();
}
$donor_id = $_SESSION['UserID'];
?>
<!DOCTYPE html>
<html>
<head>
  <title>Donor Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="navbar">
    <div class="logo">🍲 FoodShare</div>
    <nav>
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <!-- "Add Donation" form remains at the top -->
  <div class="form-container">
    <h2>Add Food Donation</h2>
    <!-- 
      This form will now target "_top" to reload the whole page,
      so the "My Donations" list will update after an addition.
    -->
    <form action="php/add_donation.php" method="POST" target="_top">
      <input type="hidden" name="donor_id" value="<?php echo $donor_id; ?>">
      <input type="text" name="item" placeholder="Food Item" required>
      <input type="number" name="quantity" placeholder="Quantity" required>
      <input type="datetime-local" name="expiry_time" required>
      <button type="submit" class="btn">Add Donation</button>
    </form>
  </div>

  <!-- IDEA 3: Thank You Notifications -->
  <section class="table-section">
    <h2 style="text-align: center; color: #27ae60;">Notifications</h2>
    <p style="text-align: center; color: #555;">Thank you for your contributions!</p>
    <iframe src="php/donor_view_notifications.php" width="100%" height="200" style="border:none; border-radius:10px;"></iframe>
  </section>

  <!-- IDEA 2: My Donations List (with Edit/Delete) -->
  <section class="table-section">
    <h2 style="text-align: center; color: #27ae60;">My Donations</h2>
    <iframe src="php/donor_view_donations.php" width="100%" height="300" style="border:none; border-radius:10px;"></iframe>
  </section>

</body>
</html>