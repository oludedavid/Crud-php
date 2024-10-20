
<?php
include 'db.php';
if(isset($_POST['name']) && isset($_POST['submit'])) {
    $name = $_POST['name'];
    $sql = "INSERT INTO tasks (name) VALUES ('$name')";
    $mysqli->query($sql);
    header("Location: index.php");
}
else {
    echo "Error: " . $mysqli->error;
}
?>