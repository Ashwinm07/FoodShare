<?php
include('db_connect.php');

$sql = "SELECT DonationID, Item, Quantity, Status, ExpiryTime
        FROM food_donation
        ORDER BY ExpiryTime ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style.css">
  <title>Available Donations</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      background: #f7f9f9;
    }

    .donations-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 20px;
      padding: 20px;
      width: 90%;
      margin: auto;
    }

    .card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      padding: 20px;
      transition: transform 0.2s ease;
    }

    .card:hover {
      transform: scale(1.02);
    }

    .card h3 {
      margin-top: 0;
      color: #27ae60;
    }

    .badge {
      display: inline-block;
      padding: 4px 10px;
      border-radius: 6px;
      font-size: 13px;
      font-weight: 500;
      color: white;
    }
    .badge.available { background: #27ae60; }
    .badge.requested { background: #e67e22; }
    .badge.assigned { background: #2980b9; }

    .card-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 15px;
    }

    .btn {
      background: #2ecc71;
      color: white;
      border: none;
      padding: 8px 14px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
    }
    .btn:disabled {
      background: #bdc3c7;
      cursor: not-allowed;
    }
  </style>
</head>
<body>

<div class="donations-container">
  <?php
  if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $id = $row['DonationID'];
          $item = htmlspecialchars($row['Item']);
          $qty = htmlspecialchars($row['Quantity']);
          $status = strtolower($row['Status']);
          $expiry = date("M d, Y H:i", strtotime($row['ExpiryTime']));

          echo "<div class='card'>
                  <h3>$item</h3>
                  <p>Quantity: <strong>$qty</strong></p>
                  <p>Expiry: <strong>$expiry</strong></p>
                  <span class='badge $status'>$row[Status]</span>
                  <div class='card-footer'>";
          
         if ($row['Status'] == 'Available') {
    echo "<form method='POST' action='../php/request_food.php' target='_parent'>
            <input type='hidden' name='donation_id' value='$id'>
            <label for='qty_$id' style='font-size:13px;'>Quantity:</label>
            <select name='requested_qty' id='qty_$id' style='padding:4px; border-radius:5px; margin-left:5px;'>
                <option value='1'>1</option>
                <option value='2'>2</option>
                <option value='3'>3</option>
                <option value='4'>4</option>
                <option value='5'>5</option>
            </select>
            <button type='submit' class='btn' style='margin-top:8px;'>Request</button>
          </form>";
} else {
    echo "<button class='btn' disabled>Requested</button>";
}
          echo "</div></div>";
      }
  } else {
      echo "<p style='text-align:center;width:100%;color:gray;'>No donations found.</p>";
  }
  ?>
</div>

</body>
</html>
<?php $conn->close(); ?>
