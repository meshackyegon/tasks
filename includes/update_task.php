<?php
include("operations.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the data from the form
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $priority_level = $_POST['priority_level'];

    // Sanitize and validate the inputs
    $title = security(trim($title));
    $description = security(trim($description));
    $priority_level = security(trim($priority_level));

    // Update the task in the database
    $sql = "UPDATE tasks SET title = '$title', description = '$description', priority_level = '$priority_level' WHERE id = $id";
    
    if (mysqli_query(connect(), $sql)) {
        echo "Task updated successfully!";
        header("location: ../view_tasks.php");
    } else {
        echo "Error updating task: " . mysqli_error(connect());
    }
}
?>
