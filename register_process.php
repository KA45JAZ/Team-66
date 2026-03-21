<?php
session_start();
include 'connectdb.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $first = trim($_POST['first_name']);
    $last = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    
    //Make sure phone number is max 11 numbers
    if(!empty($phone)){
        if(!preg_match('/^[0-9]{1,11}$/', $phone)){
            header("Location: register.php?error=Phone number must be numeric and up to 11 digits");
            exit;
        }
    }

    $role = $_POST['role']; // customer or admin
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    //Check if passwords match
    if($password !== $confirm_password){
        header("Location: register.php?error=Passwords do not match");
        exit;
    }

    //Checks if the password is strong
    if(strlen($password)<8){
        header("Location: register.php?error=Password must be at least 8 characters long.");
        exit;
    }

    if(!preg_match('/[A-Z]/', $password)){
        header("Location: register.php?error=Password must include at least one uppercase/capital letter.");
        exit;
    }

    if(!preg_match('/[a-z]/', $password)){
        header("Location: register.php?error=Password must include at least one lowercase/small letter");
        exit;
    }

    if(!preg_match('/[0-9]/', $password)){
        header("Location: register.php?error=Password must include at least one number.");
        exit;
    }

    if(!preg_match('/[^A-Za-z0-9]/', $password)){
        header("Location: register.php?error=Password must include at least one special character");
        exit;
    }

    // Check if email already exists
    $check = $db->prepare("SELECT user_id FROM users WHERE email = :email LIMIT 1");
    $check->bindParam(':email', $email);
    $check->execute();

    if ($check->fetch()) {
        header("Location: register.php?error=Email already registered");
        exit;
    }

    //Hash Password after validation
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $sql = "INSERT INTO users (first_name, last_name, email, password_hash, phone, role)
            VALUES (:first, :last, :email, :password, :phone, :role)";

    $stmt = $db->prepare($sql);

    $stmt->bindParam(':first', $first);
    $stmt->bindParam(':last', $last);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password_hash);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':role', $role);

    if ($stmt->execute()) {
        header("Location: login.php?registered=1");
        exit;
    } else {
        header("Location: register.php?error=Registration failed");
        exit;
    }
}
?>