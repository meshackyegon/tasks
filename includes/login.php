<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');            // Do not display errors on the browser
ini_set('log_errors', '1'); 
session_start();
include_once "operations.php";
// var_dump($_POST);
if (isset($_POST['submit']) && !empty($_POST)) {
    // Check if form inputs are set

    $email = security($_POST['email']);
    $password = security($_POST['password']);
   
    if (!empty($email) && !empty($password)) {
        // Hash the password with md5 before comparison
        $hashed_password = md5($password);
        // var_dump($hashed_password);
        // Query to check if the user exists with the given email and hashed password
        $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$hashed_password'";
        $user = select_rows($sql);
        // var_dump($user);
        if ($user && isset($user[0])) {
            // Store user details in the session using the inner array at $user[0]
            $_SESSION['user_id'] = $user[0]['id'];
            $_SESSION['full_name'] = $user[0]['full_name'];
            $_SESSION['email'] = $user[0]['email'];

            // Redirect to view_tasks.php after successful login
            header('location: ../view_tasks.php');
            exit();
            // var_dump($_SESSION);
        } 
        // else {
        //     // Invalid email or password
        //     $error_message = "Invalid email or password. Please try again.";
        //     echo "<p style='color: red;'>$error_message</p>";
        // }
    } else {
        $error_message = "Please enter both email and password.";
    }
}
?>




