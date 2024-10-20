<!DOCTYPE html>
<?php include 'db.php'; ?>
<?php 
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
                    <input class="border" id="task_description" name="task_description" type="text" required>
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
    </div>

    <script src="https://cdn.tailwindcss.com"></script>
</body>
</html>
