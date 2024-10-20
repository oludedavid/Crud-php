<!DOCTYPE html>
<?php include 'db.php'; ?>
<?php 
$sql = "SELECT * FROM tasks";
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My first php</title>
</head>
<body>
   
    <form action="index.php" method="get" style="display: flex; flex-direction: column; gap: 10px; padding-top: 10px;">
     <div style="display: flex; gap: 10px; padding-top: 10px;">
     <label for="task_title">Enter task title: </label>
    <input id="task_title" name="task_title" type="text" required>
    </div>

    <div style="display: flex; gap: 10px; padding-top: 10px;">
     <label for="task_description">Enter your task: </label>
    <input id="task_description" name="task_description" type="text" required>
    </div>
   
    <input style="width: 100px" type="submit" value="Submit">
    </form>
    <br>

  <?php
  // Start the session
  session_start();
  
  // Initialize task list if it doesn't exist
  if (!isset($_SESSION['tasks'])) {
      $_SESSION['tasks'] = [];
  }

  // Function to check if a task already exists
  function taskExists($task_title, $task_description) {
      foreach ($_SESSION['tasks'] as $task) {
          if ($task['title'] === $task_title && $task['description'] === $task_description) {
              return true; // Task already exists
          }
      }
      return false; // Task does not exist
  }

  // Handle form submission
  if (isset($_GET['task_title']) && isset($_GET['task_description'])) {
      $task_title = $_GET['task_title'];
      $task_description = $_GET['task_description'];

      // Check if task already exists
      if (!taskExists($task_title, $task_description)) {
          // Add task if it doesn't exist
          $_SESSION['tasks'][] = [
              'title' => $task_title,
              'description' => $task_description,
              'status' => 'pending'
          ];
      } else {
          null;
      }
  }

  // Display the tasks
  foreach ($_SESSION['tasks'] as $task) {
      echo $task['title'] . ' - ' . $task['description'] . ' - ' . $task['status'] .'<button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 my-2 rounded">Delete</button>'.'<button style="margin-left: 10px; background-color: green;">Edit</button>'  .'<br>';
  }
  
  ?>
  <script src="https://cdn.tailwindcss.com"></script>
</body>
</html>
