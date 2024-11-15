<?php
include("operations.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the task ID from the request
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];

    // Mark the task as completed
    $sql = "UPDATE tasks SET completion = 'Completed' WHERE id = $id";
    
    if (mysqli_query(connect(), $sql)) {
        echo "Task marked as completed!";
        header("location: ../view_tasks.php");
    } else {
        echo "Error marking task as completed: " . mysqli_error(connect());
    }
}
?>
