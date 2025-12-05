
<?php
session_start();

if (isset($_POST['submitted'])){
	
  //definitions
  $firstName = isset($_POST['First_Name']) ? trim(strtolower($_POST['First_Name'])) : false;
  $lastName = isset($_POST['Last_Name']) ? trim(strtolower($_POST['Last_Name'])) : false;
  $role = isset($_POST['customer_admin']) ? trim(strtolower($_POST['customer_admin'])) : false;
  $email=isset($_POST['email']) ? trim(strtolower($_POST['email'])):false;
  $phoneNumber = isset($_POST['phone']) ? $_POST['phone'] : false;
  $justPassword=isset($_POST['password']) ? $_POST['password']:false;
  $rePassword = isset($_POST['re_password']) ? $_POST['re_password']: false;

  //checks if all fields are filled
  if(!$justPassword || !$email || !$firstName || !$lastName || !$phoneNumber || !$rePassword || !$role){
    echo "<p style='color:red;'>Please fill in all required fields.</p>";
    exit;
  }

  //compare the two passwords
  if($justPassword !== $rePassword){
    echo "<p style='color:red;'> Passwords do not match.</p>";
  }

  //connect to the database
  require_once('connectdb.php');

  //check if email address exists or not
  $check = $db->prepare("SELECT * FROM users WHERE LOWER(TRIM(email)) = ?");
  $check->execute([$email]);

  //if email exists throws an error otherwise hashes the password
  if($check->rowCount()>0){
    echo "<p style='color:red;'>Email Address already exists. Please try to Login instead, or register with a different email address.</p>";
  } else {
    $hashPassword = password_hash($justPassword, PASSWORD_DEFAULT);

    //save the data in to the database
    try{
	
      $stat=$db->prepare("insert into users values(default,?,?,?,?,?,?)");
      $stat->execute(array($firstName, $lastName, $email, $hashPassword, $phoneNumber, $role));
      
      $id=$db->lastInsertId();
      $_SESSION['user_id']=$id;
      echo "Congratulations! You are now registered. Your ID is: $id  ";  	
      
     }
     catch (PDOexception $ex){
      echo "Sorry, a database error occurred. Please try again later <br>";
      echo "Error details: <em>". $ex->getMessage()."</em>";
     }
    

  }
 
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="icon" type="image/x.icon" href="images/GoodFit_favicon.ico">
</head>
<body>
    <header>
        
                <header id="main-header">
                 <?php include 'navbar.php'; ?>
              
    </header>
    <div class="everything">
    <div class="image">
        <img src="images/Welcome.png" alt="Welcome To GoodFit!">
    </div>
    <div class="form">
        <div class="register-container">
    <h2>Register</h2>
    <form action="register.php" method="post">

            First Name: <input type="text" name="First_Name" /><br><br>
            Last Name: <input type="text" name="Last_Name" /><br><br>
            Email:	  <input type="email" name="email" /><br><br>
            Password: <input type="password" name="password" /><br><br>
            Re-Enter Password: <input type="password" name="re_password" /><br><br>
            Phone Number: <input type="number" name="phone" /><br><br>
            Customer or Admin: <select name="customer_admin">
                                  <option value="customer">Customer</option>
                                  <option value="admin">Admin</option>
                               </select>


            <input type="submit" value="Register" /> 
            <input type="hidden" name="submitted" value="true"/>
        </form>  
        <p> Already a user? <a href="login.php">Log in</a>  </p>
        <p>&nbsp;</p>
    </div>
</div>
     
</body>
 <?php include 'footer.php'; ?>
</html>