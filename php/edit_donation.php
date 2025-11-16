<?php
include('php/db_connect.php');
if (!isset($_SESSION['UserID']) || $_SESSION['Role'] != 'Donor') {
    header("Location: login.php");
    exit();
}
$donor_id = $_SESSION['UserID'];
$donation_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$item = "";
$quantity = "";
$expiry_time = "";
$error_message = "";
$success_message = "";

// --- 1. HANDLE FORM SUBMISSION (POST) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from form
    $donation_id = intval($_POST['donation_id']);
    $item = $_POST['item'];
    $quantity = intval($_POST['quantity']);
    $expiry_time = $_POST['expiry_time'];

    // Securely update the donation
    // We check DonorID AND Status='Available' to ensure they can't edit locked items
    $stmt_update = $conn->prepare("UPDATE food_donation 
                                  SET Item = ?, Quantity = ?, ExpiryTime = ? 
                                  WHERE DonationID = ? AND DonorID = ? AND Status = 'Available'");
    $stmt_update->bind_param("sisii", $item, $quantity, $expiry_time, $donation_id, $donor_id);
    
    if ($stmt_update->execute()) {
        if ($stmt_update->affected_rows > 0) {
            // Success! Redirect back to the dashboard.
            header("Location: donor_dashboard.php");
            exit();
        } else {
            $error_message = "Could not update donation. It might be locked or already updated.";
        }
    } else {
        $error_message = "Error updating donation: " . $conn->error;
    }
    $stmt_update->close();
}

// --- 2. LOAD DONATION DETAILS (GET) ---
if ($donation_id > 0) {
    // Securely fetch the donation details,
    // ensuring it belongs to the logged-in donor
    $stmt_load = $conn->prepare("SELECT Item, Quantity, ExpiryTime FROM food_donation 
                                WHERE DonationID = ? AND DonorID = ? AND Status = 'Available'");
    $stmt_load->bind_param("ii", $donation_id, $donor_id);
    $stmt_load->execute();
    $result = $stmt_load->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $item = $row['Item'];
        $quantity = $row['Quantity'];
        // Format expiry for the datetime-local input
        $expiry_time = date('Y-m-d\TH:i', strtotime($row['ExpiryTime']));
    } else {
        $error_message = "Donation not found or is not 'Available' for editing.";
        $donation_id = 0; // Prevent form from showing
    }
    $stmt_load->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Donation</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="navbar">
    <div class="logo">🍲 FoodShare</div>
    <nav>
      <a href="donor_dashboard.php">Back to Dashboard</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <div class="form-container">
    <h2>Edit Donation</h2>

    <?php if ($error_message): ?>
      <p style='text-align:center;color:red;font-weight:bold;'><?php echo $error_message; ?></p>
    <?php endif; ?>

    <?php if ($donation_id > 0): // Only show form if we successfully loaded a donation ?>
      <form action="edit_donation.php" method="POST">
        <input type="hidden" name="donation_id" value="<?php echo $donation_id; ?>">
        
        <label for="item">Food Item:</label>
        <input type="text" id="item" name="item" value="<?php echo htmlspecialchars($item); ?>" required>
        
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>" required>
        
        <label for="expiry_time">Expiry Time:</label>
        <input type="datetime-local" id="expiry_time" name="expiry_time" value="<?php echo $expiry_time; ?>" required>
        
        <button type="submit" class="btn">Update Donation</button>
      </form>
    <?php else: ?>
      <p style='text-align:center;'>No editable donation selected. <a href="donor_dashboard.php">Go back</a>.</p>
    <?php endif; ?>
  </div>
</body>
</html>