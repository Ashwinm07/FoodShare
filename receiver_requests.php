<?php
include('php/db_connect.php');
if (!isset($_SESSION['UserID']) || $_SESSION['Role'] != 'Receiver') {
    header("Location: login.php");
    exit();
}
$receiver_id = $_SESSION['UserID'];

$sql = "SELECT r.RequestID, r.DonationID, r.RequestedQty, r.Status, r.Timestamp, d.Item, d.ExpiryTime
        FROM food_request r
        JOIN food_donation d ON r.DonationID = d.DonationID
        WHERE r.ReceiverID = '$receiver_id'
        ORDER BY r.Timestamp DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='UTF-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<title>My Requests - FoodShare</title>
<link rel='stylesheet' href='style.css'>
<style>
body {
  font-family: 'Poppins', sans-serif;
  margin: 0;
  background: #f7f9f9;
}
header.navbar {
  display:flex;justify-content:space-between;align-items:center;
  padding:10px 20px;background:#27ae60;color:white;
}
header.navbar a {
  color:white;text-decoration:none;margin-left:15px;
}
h2 {
  text-align:center;
  color:#27ae60;
  margin:20px 0;
}
.requests-container {
  display:grid;
  grid-template-columns:repeat(auto-fill, minmax(260px, 1fr));
  gap:20px;
  padding:20px;
  width:90%;
  margin:auto;
}
.card {
  background:white;
  border-radius:12px;
  box-shadow:0 2px 8px rgba(0,0,0,0.1);
  padding:18px;
  transition:transform 0.2s ease;
}
.card:hover {
  transform:scale(1.02);
}
.card h3 {
  margin-top:0;
  color:#27ae60;
}
.badge {
  display:inline-block;
  padding:5px 12px;
  border-radius:6px;
  font-size:13px;
  font-weight:500;
  color:white;
}
.badge.Pending { background:#e67e22; }
.badge.Accepted { background:#2ecc71; }
.badge.Declined { background:#e74c3c; }
.badge.Assigned { background:#2980b9; }
small {
  display:block;
  color:#555;
  font-size:13px;
  margin-top:5px;
}
</style>
</head>
<body>

<header class="navbar">
  <div class="logo">🍲 FoodShare</div>
  <nav>
    <a href="receiver_dashboard.php">Back</a>
    <a href="logout.php">Logout</a>
  </nav>
</header>

<h2>My Food Requests</h2>

<div class="requests-container">
<?php
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $item = htmlspecialchars($row['Item']);
        $qty = $row['RequestedQty'];
        $status = $row['Status'];
        $req_date = date("M d, Y H:i", strtotime($row['Timestamp']));
        $expiry = date("M d, Y", strtotime($row['ExpiryTime']));

        echo "<div class='card'>
                <h3>$item</h3>
                <p>Quantity Requested: <strong>$qty</strong></p>
                <p>Status: <span class='badge $status'>$status</span></p>
                <small>Requested On: $req_date</small>
                <small>Expiry: $expiry</small>";

        // Optional visual cue
        if ($status == 'Accepted') {
            echo "<p style='color:#27ae60;margin-top:10px;font-weight:bold;'>✅ Your request was accepted!</p>";
        } elseif ($status == 'Declined') {
            echo "<p style='color:#e74c3c;margin-top:10px;font-weight:bold;'>❌ Request declined by admin.</p>";
        } elseif ($status == 'Assigned') {
            echo "<p style='color:#2980b9;margin-top:10px;font-weight:bold;'>🚚 Volunteer assigned!</p>";
        }

        echo "</div>";
    }
} else {
    echo "<p style='text-align:center;width:100%;color:gray;'>No requests made yet.</p>";
}
?>
</div>

</body>
</html>
<?php $conn->close(); ?>
