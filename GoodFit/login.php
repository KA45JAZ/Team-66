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
					header("Location:home.html");
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
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
  <link rel="icon" type="image/x.icon" href="images/GoodFit_favicon.ico">
</head>
<body>
    <header>
        <table>
            <tr>
                <a href="home.html">
                    <img src="images/GoodFit_Logo.png" alt="GoodFit Logo" width="120" height="120">
                </a>
            </tr>
        </table>
    </header>
    <div name="form">
        <form action="login.php" method="post">

            <label>Email Address:</label>
            <input type="text" name="email"/>
            <label>Password:</label>
            <input type="password" name="password"/>
            
            <a href="forgottenPassword.php">Forgot Password?</a>
            <input type="submit" value="Login" />
            <input type="hidden" name="submitted" value="TRUE" />
            <p>
                No Account? <a href="Register.php">Register Here</a>
            </p>
        </form>
    </div>
    <div name="image">
        <img src="images/Welcome_Back.png" alt="Welcome Back to GoodFit!">
    </div>
    <p>&nbsp;</p>
    <footer>
        
    </footer>
</body>
</html>