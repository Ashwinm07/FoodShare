<?php 
include('php/db_connect.php'); 
$registration_success = false;
$error_message = "";

if(isset($_POST['register'])){
  $name = $_POST['name']; 
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $location = $_POST['location']; 
  $role = $_POST['role']; 
  $contact = $_POST['contact'];

  // --- 1. Check if email already exists (SECURE) ---
  $stmt_check = $conn->prepare("SELECT UserID FROM users WHERE Email = ?");
  $stmt_check->bind_param("s", $email);
  $stmt_check->execute();
  $stmt_check->store_result();
  
  if($stmt_check->num_rows > 0) {
      $error_message = "Email already exists!";
      $stmt_check->close(); // Close here
  } else {
      $stmt_check->close(); // Close here

      // --- 2. Insert into 'users' table (SECURE) ---
      $stmt_users = $conn->prepare("INSERT INTO users (Name, Email, Password, Location, Role, Contact) VALUES (?, ?, ?, ?, ?, ?)");
      $stmt_users->bind_param("ssssss", $name, $email, $password, $location, $role, $contact);
      
      if($stmt_users->execute()) {
          $registration_success = true;
          $new_user_id = $stmt_users->insert_id; // Get the ID of the user just created
          
          // --- 3. If Role is 'Volunteer', insert into 'volunteer' table (SECURE) ---
          if ($role == 'Volunteer') {
              // We'll set a default status for the new volunteer
              $default_status = 'Available'; // Or 'Pending'
              $default_assigned = 0; // Default for no assignment
              
              // We use the same details from the registration form
              $stmt_volunteer = $conn->prepare("INSERT INTO volunteer (VolunteerID, Name, Email, LOC, AssignedRequests, PickupStatus) VALUES (?, ?, ?, ?, ?, ?)");
              
              // We use the $new_user_id as the VolunteerID to link the tables
              $stmt_volunteer->bind_param("isssis", $new_user_id, $name, $email, $location, $default_assigned, $default_status);
              
              if (!$stmt_volunteer->execute()) {
                  // Handle error if volunteer insert fails
                  $error_message = "User registered, but failed to create volunteer profile.";
                  $registration_success = false; // Mark as partial failure
              }
              $stmt_volunteer->close();
          }
          
      } else {
          $error_message = "Registration failed. Please try again.";
      }
      $stmt_users->close();
  }
}
?>
<!DOCTYPE html><html>
<head>
  <title>Register</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
  <h2>Create Account</h2>
  
  <?php if ($registration_success): ?>
    <p style='text-align:center;color:green;font-weight:bold;'>Registration Successful!</p>
    <p style='text-align:center;'>You can now <a href='login.php'>Login</a></p>
  <?php elseif (!empty($error_message)): ?>
    <p style='text-align:center;color:red;font-weight:bold;'><?php echo htmlspecialchars($error_message); ?></p>
  <?php endif; ?>

  <form method="POST" action="register.php">
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="text" name="location" placeholder="Location" required>
    <select name="role" required>
      <option value="">Select Role</option>
      <option value="Donor">Donor</option>
      <option value="Receiver">Receiver</option>
      <option value="Volunteer">Volunteer</option>
      </select>
    <input type="text" name="contact" placeholder="Contact" required>
    <button type="submit" name="register" class="btn">Register</button>
  </form>
  <p>Already have an account? <a href="login.php">Login</a> | <a href="index.html">Home</a></p>
</div>
</body>
</html>