<?php
include('db_connect.php');
if (!isset($_SESSION['UserID']) || $_SESSION['Role'] != 'Donor') {
    echo "<p>Access denied.</p>";
    exit();
}
$donor_id = $_SESSION['UserID'];

/*
 * IDEA 3: Find delivered requests linked to this donor.
 * We JOIN food_donation (d) with food_request (r) and users (u)
 * to find the item name and the receiver's name.
 */
$stmt = $conn->prepare("SELECT d.Item, u.Name 
                        FROM food_donation d
                        JOIN food_request r ON d.DonationID = r.DonationID
                        JOIN users u ON r.ReceiverID = u.UserID
                        WHERE d.DonorID = ? AND r.Status = 'Delivered'");
$stmt->bind_param("i", $donor_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../style.css">
  <style>
    body { background: #f7f9f9; font-family: 'Poppins', sans-serif; }
    .notification {
      background: white;
      color: #333;
      padding: 15px;
      margin: 10px 20px;
      border-radius: 8px;
      border-left: 5px solid #2ecc71;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .notification strong {
      color: #27ae60;
    }
  </style>
</head>
<body>
  <?php if ($result->num_rows > 0): ?>
    <?php while($row = $result->fetch_assoc()): ?>
      <div class="notification">
        ✅ Your donation of <strong><?php echo htmlspecialchars($row['Item']); ?></strong> was successfully delivered to <?php echo htmlspecialchars($row['Name']); ?>. Thank you!
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p style="text-align:center; color:gray;">No delivery notifications yet.</p>
  <?php endif; ?>
</body>
</html>
<?php $stmt->close(); $conn->close(); ?>