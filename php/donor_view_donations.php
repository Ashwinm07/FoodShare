<?php
include('db_connect.php');
if (!isset($_SESSION['UserID']) || $_SESSION['Role'] != 'Donor') {
    echo "<p>Access denied.</p>";
    exit();
}
$donor_id = $_SESSION['UserID'];

// Securely fetch donations for the logged-in donor
$stmt = $conn->prepare("SELECT DonationID, Item, Quantity, Status, ExpiryTime FROM food_donation WHERE DonorID = ? ORDER BY ExpiryTime DESC");
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
    table { width: 95%; margin:auto; border-collapse: collapse; text-align: center; }
    th { background: #27ae60; color: white; padding: 10px; }
    td { padding: 8px; border-bottom: 1px solid #ddd; }
    tr:hover { background-color: #f1f1f1; }
    .btn-small { padding: 5px 10px; font-size: 13px; border-radius: 5px; }
    .btn-delete { background: #e74c3c; }
    .btn-edit { background: #f39c12; }
    .btn-disabled { background: #bdc3c7; cursor: not-allowed; }
  </style>
</head>
<body>
  <table>
    <tr>
      <th>Item</th>
      <th>Quantity</th>
      <th>Status</th>
      <th>Expiry</th>
      <th>Action</th>
    </tr>
    <?php if ($result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo htmlspecialchars($row['Item']); ?></td>
          <td><?php echo htmlspecialchars($row['Quantity']); ?></td>
          <td><?php echo htmlspecialchars($row['Status']); ?></td>
          <td><?php echo date("M d, Y", strtotime($row['ExpiryTime'])); ?></td>
          <td>
            <?php if ($row['Status'] == 'Available'): ?>
              <!-- IDEA 2: Edit and Delete buttons -->
              
              <!-- Edit Button: Links to a new page -->
              <a href="../edit_donation.php?id=<?php echo $row['DonationID']; ?>" class="btn btn-small btn-edit" style="text-decoration:none;" target="_top">Edit</a>
              
              <!-- Delete Button: Submits a form -->
              <form action="delete_donation.php" method="POST" style="display:inline;" target="_top" onsubmit="return confirm('Are you sure you want to delete this item?');">
                <input type="hidden" name="donation_id" value="<?php echo $row['DonationID']; ?>">
                <button type="submit" class="btn btn-small btn-delete">Delete</button>
              </form>
            <?php else: ?>
              <button class="btn btn-small btn-disabled" disabled>Locked</button>
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="5">You have not added any donations yet.</td></tr>
    <?php endif; ?>
  </table>
</body>
</html>
<?php $stmt->close(); $conn->close(); ?>