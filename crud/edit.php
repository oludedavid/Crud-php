<?php
include 'db.php';

// Check if the ID and new task description are set
if (isset($_POST['id']) && isset($_POST['task_description'])) {
    $id = $_POST['id'];
    $new_description = $_POST['task_description'];

    // SQL query to update the task
    $sql = "UPDATE tasks SET name='$new_description' WHERE id=$id";
    
    // Execute the query
    if ($mysqli->query($sql)) {
        header("Location: index.php");
    } else {
        echo "Error: " . $mysqli->error;
    }
}
?>
