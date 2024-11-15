<?php
include("operations.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the task ID from the request
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];

    // Delete the task from the database
    $sql = "DELETE FROM tasks WHERE id = $id";
    
    if (mysqli_query(connect(), $sql)) {
        echo "Task deleted successfully!";
        header("location: ../view_tasks.php");
    } else {
        echo "Error deleting task: " . mysqli_error(connect());
    }
}
?>
