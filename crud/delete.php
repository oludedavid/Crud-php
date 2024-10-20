<?php
include 'db.php';
session_start();  // Start the session

// Check if ID is set in the form
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // SQL query to delete the task with the given ID
    $sql = "DELETE FROM tasks WHERE id = $id";
    
    // Execute the query
    if ($mysqli->query($sql)) {
        // Store a success message in the session
        $_SESSION['message'] = "Task deleted successfully!";
        
        // Redirect back to the main page
        header("Location: index.php");
        exit();  // Always exit after a header redirect
    } else {
        echo "Error: " . $mysqli->error;
    }
}
?>
