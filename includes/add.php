<?php
// include_once "operations.php";


// if (isset($_POST['submit']) && !empty($_POST)) {
    
    
//     // Sanitize and assign form inputs to the array
//     $title = security(trim($_POST['title']));
//     $description = security(trim($_POST['description']));
//     $priority_level = security(trim($_POST['priority_level']));
//     $due_date = security(trim($_POST['due_date']));
// var_dump($arr);
//     // Insert the sanitized data into the database
//     build_sql_insert("tasks", $arr);
// }


include_once "operations.php";

if (isset($_POST['submit']) && !empty($_POST)) {
    // Sanitize and assign form inputs to variables
    $title = security($_POST['title']);
    $description = security($_POST['description']);
    $priority_level = security($_POST['priority_level']);
    $due_date = security($_POST['due_date']);

    // Assign sanitized variables to an associative array
    $arr = [
        "title" => $title,
        "description" => $description,
        "priority_level" => $priority_level,
        "due_date" => $due_date,
    ];

    // Display the array for debugging
    // var_dump($arr);

    // Insert the sanitized data into the database
    build_sql_insert("tasks", $arr);
    header('location: ../add.php');
}




?>
