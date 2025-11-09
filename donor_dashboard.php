<?php
include('php/db_connect.php');
if (!isset($_SESSION['UserID']) || $_SESSION['Role'] != 'Donor') {
    header("Location: login.php");
    exit();
}
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

  <div class="form-container">
    <h2>Add Food Donation</h2>
    <form action="php/add_donation.php" method="POST">
      <input type="hidden" name="donor_id" value="<?php echo $_SESSION['UserID']; ?>">
      <input type="text" name="item" placeholder="Food Item" required>
      <input type="number" name="quantity" placeholder="Quantity" required>
      <input type="datetime-local" name="expiry_time" required>
      <button type="submit" class="btn">Add Donation</button>
    </form>
  </div>
</body>
</html>
