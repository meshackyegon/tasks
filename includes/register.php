<?php
include_once "operations.php";

if (isset($_POST['submit']) && !empty($_POST)) {
    // Sanitize and assign form inputs to variables
    $fullname = security($_POST['full_name']);
    $contacts = security($_POST['contacts']);
    $gender = security($_POST['gender']);
    $email = security($_POST['email']);
    $password = security($_POST['password']);
    $cpassword = security($_POST['confirm_password']);

    // Check if passwords match
    if ($password === $cpassword) {
        // Hash the password using MD5 (or password_hash() for stronger encryption)
        $hashedPassword = md5($password);  // Using md5, but it's not recommended for password storage in real applications

        // Assign sanitized variables to an associative array
        $arr = [
            "full_name" => $fullname,
            "contacts" => $contacts,
            "gender" => $gender,
            "email" => $email,
            "password" => $hashedPassword,
        ];
// var_dump($arr);
        // Save the user details into the database
        build_sql_insert("users", $arr);

        // Redirect to login page after successful registration
        header('location: ../login.php');
        exit(); // Ensure no further code is executed after the redirect
    } else {
        // Passwords do not match
        echo "Passwords do not match. Please try again.";
    }
}
?>
