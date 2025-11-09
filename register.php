<?php include('php/db_connect.php'); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
  <h2>Create Account</h2>
  <form method="POST">
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="text" name="location" placeholder="Location" required>
    <select name="role" required>
      <option value="">Select Role</option>
      <option value="Donor">Donor</option>
      <option value="Receiver">Receiver</option>
      <option value="Volunteer">Volunteer</option>
      <option value="Admin">Admin</option>
    </select>
    <input type="text" name="contact" placeholder="Contact" required>
    <button type="submit" name="register" class="btn">Register</button>
  </form>
  <p>Already have an account? <a href="login.php">Login</a></p>
</div>
<?php
if(isset($_POST['register'])){
  $name=$_POST['name']; $email=$_POST['email'];
  $password=password_hash($_POST['password'],PASSWORD_DEFAULT);
  $location=$_POST['location']; $role=$_POST['role']; $contact=$_POST['contact'];
  if($conn->query("SELECT * FROM users WHERE Email='$email'")->num_rows>0)
      echo "<p style='text-align:center;color:red'>Email already exists!</p>";
  else{
    $sql="INSERT INTO users (Name,Email,Password,Location,Role,Contact)
          VALUES ('$name','$email','$password','$location','$role','$contact')";
    if($conn->query($sql))
      echo "<p style='text-align:center;color:green'>Registered! <a href='login.php'>Login</a></p>";
  }
}
?>
</body>
</html>
