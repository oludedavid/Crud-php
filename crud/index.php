<!DOCTYPE html>
<?php 
session_start();  
include 'db.php';
// Display success message if it exists
if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']);  
}
// Determine current page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 5; // Number of tasks per page
$start = ($page - 1) * $limit;

// Query to get the tasks for the current page
$result = $mysqli->query("SELECT * FROM tasks LIMIT $start, $limit");

// Query to get the total number of tasks
$total_result = $mysqli->query("SELECT COUNT(id) AS total FROM tasks");
$total_tasks = $total_result->fetch_assoc()['total'];

// Calculate total pages needed
$total_pages = ceil($total_tasks / $limit);


$sql = "SELECT * FROM tasks";
$rows = $mysqli->query($sql);

// Check if we are in "edit mode"
$edit_mode = false;
$task_id = "";
$task_name = "";

// Check if the edit form has been requested
if (isset($_POST['edit'])) {
    $edit_mode = true; 
    $task_id = $_POST['id']; 
    $task_name = $_POST['name'];
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud application</title>
</head>
<body>
    <div class="w-screen flex flex-col items-center">
        <!-- Add or Edit Form -->
        <?php if ($edit_mode): ?>
            <!-- If in edit mode, show the edit form -->
            <form action="edit.php" method="post" class="flex flex-col gap-2 p-2">
                <div class="flex gap-2">
                    <label for="task_description">Edit your task: </label>
                    <input class="border" id="task_description" name="task_description" type="text" value="<?php echo $task_name ?>" required>
                </div>
                <!-- Hidden input to send the ID -->
                <input type="hidden" name="id" value="<?php echo $task_id ?>">
                <input type="submit" name="submit" value="Update Task" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
            </form>
        <?php else: ?>
            <!-- Show the add form if not in edit mode -->
            <form action="add.php" method="post" class="flex flex-col gap-2 p-2">
                <div class="flex gap-2">
                    <label for="task_description">Enter your task: </label>
                    <input class="border" id="task_description" name="name" type="text" required>
                </div>
                <input type="submit" name="submit" value="Add Task" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
            </form>
        <?php endif; ?>

        <!-- Tasks Table -->
        <table class="table-fixed w-1/2 border-collapse border border-slate-500">
            <thead class="p-2">
                <tr class="bg-gray-200">
                    <th class="border border-slate-600">ID</th>
                    <th class="border border-slate-600">Task</th>
                    <th class="border border-slate-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $rows->fetch_assoc()): ?>
                <tr class="mx-2">
                    <td class="border border-slate-600"><?php echo $row['id'] ?></td>
                    <td class="border border-slate-600"><?php echo $row['name'] ?></td> 
                    <td class="border border-slate-600 flex gap-2 items-center justify-center">
                        <!-- Edit Button -->
                        <form action="index.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
                            <input type="submit" name="edit" value="Edit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
                        </form>

                        <!-- Delete Button -->
                        <form action="delete.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="submit" name="delete" value="Delete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">
                        </form>
                    </td>  
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
                <!-- Pagination Links -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>" <?php if ($i == $page) echo 'style="font-weight: bold;"'; ?>>
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="?page=<?php echo $page + 1; ?>">Next</a>
            <?php endif; ?>
        </div>

    </div>

    <script src="https://cdn.tailwindcss.com"></script>
</body>
</html>
