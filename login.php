<?php include('php/db_connect.php'); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
  <h2>Login</h2>
  <form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login" class="btn">Login</button>
  </form>
  <p>Don't have an account? <a href="register.php">Register</a></p>
</div>
<?php
if(isset($_POST['login'])){
  $email=$_POST['email']; $password=$_POST['password'];
  $res=$conn->query("SELECT * FROM users WHERE Email='$email'");
  if($res->num_rows==1){
    $row=$res->fetch_assoc();
    if(password_verify($password,$row['Password'])){
      $_SESSION['UserID']=$row['UserID'];
      $_SESSION['Name']=$row['Name'];
      $_SESSION['Role']=$row['Role'];
      if($row['Role']=='Donor') header("Location: donor_dashboard.php");
      elseif($row['Role']=='Receiver') header("Location: receiver_dashboard.php");
      elseif($row['Role']=='Admin') header("Location: admin_dashboard.php");
      else header("Location: volunteer_dashboard.php");
      exit();
    }else echo "<p style='text-align:center;color:red'>Wrong password!</p>";
  }else echo "<p style='text-align:center;color:red'>Email not found!</p>";
}
?>
</body>
</html>
