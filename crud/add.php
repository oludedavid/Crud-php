
<?php
include 'db.php';
if(isset($_POST['name']) && isset($_POST['send'])) {
    $name = $_POST['name'];
    $sql = "INSERT INTO tasks (name) VALUES ('$name')";
    $mysqli->query($sql);
}
?>