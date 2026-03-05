<?php
session_start();
    //ensure that both the email and password are required
	if (isset($_POST['submitted'])){
		if ( !isset($_POST['email'], $_POST['password']) ) {

		 exit('Please fill both the Email Address and password!');
	    }

        //connect to database
		require_once ("connectdb.php");

        //checks if details are correct
		try {

			$stat = $db->prepare('SELECT password,uid FROM users WHERE email = ?');
			$stat->execute(array($_POST['email']));
		    

			if ($stat->rowCount()>0){  
				$row=$stat->fetch();

                //logins the user and redirects to homepage
				if (password_verify($_POST['password'], $row['password'])){ 
					$_SESSION["email"]=$_POST['email'];
					$_SESSION["userid"]=$row['uid'];
					header("Location:index.php");
					exit();
				
            //Explains why unable to login
				} else {
				 echo "<p style='color:red'>Error logging in, password does not match </p>";
 			    }
		    } else {

			  echo "<p style='color:red'>Error logging in, Email Address not found </p>";
		    }
		}
		catch(PDOException $ex) {
			echo("Failed to connect to the database. Please try again later<br>");
			echo($ex->getMessage());
			exit;
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


<div class="login-container">

    <div class="login-form">
        <h2>Login</h2>

        <form action="login.php" method="post">

            <label>Email Address:</label>
            <input type="text" name="email">

            <label>Password:</label>
            <input type="password" name="password">

            <a class="forgot-link" href="forgottenPassword.php">Forgot Password?</a>

            <input type="submit" value="Login">
            <input type="hidden" name="submitted" value="TRUE">

            <p>No Account? <a href="register.php">Register Here</a></p>
        </form>
    </div>

    <div class="login-image">
        <img src="images/Welcome_Back.png" alt="Welcome Back to GoodFit!">
    </div>

</div>

<?php include 'footer.php'; ?>

</body>
</html>
