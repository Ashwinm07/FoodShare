<?php
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $activity = $_POST['activity'];

    $sql = "INSERT INTO admin_logs (Name, Email, Activity) VALUES ('$name', '$email', '$activity')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;text-align:center;'>Activity logged successfully!</p>";
    } else {
        echo "<p style='color:red;text-align:center;'>Error: " . $conn->error . "</p>";
    }

    echo "<div style='text-align:center;'><a href='../admin_dashboard.php'>Go Back</a></div>";
}
?>
