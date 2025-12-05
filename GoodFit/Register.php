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
<html lang="en">
<head>
    <!-- Viewport, Fonts, Stylesheet -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <!-- Favicon and Title -->
    <title>GoodFit</title>
    <link rel="icon" href="favicon/GoodFit_favicon.png" type="image/x-icon">
</head>

<body>

    <!-- Header + Navbar Include -->
    <header id="main-header">
        <?php include 'navbar.php'; ?>
    </header>
    
    <div class="form">
        <h2>Register</h2>
        <form method = "post" action="register.php">
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
<?php include 'footer.php'; ?>
</body>
</html>