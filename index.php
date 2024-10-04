<?php
$conn = new mysqli("localhost","root","","todo");
if ($conn->connect_error) {
    die("Connection Failed " . $conn->connect_error);
}
if (isset($_POST["addtask"])) {
    $task = $_POST["task"];
    $conn -> query("INSERT INTO tasks (task) VALUES ('$task')");
    header("Location: /todo/");
}
if (isset($_GET["delete"])) {
    $id = $_GET["delete"];
    $conn->query("DELETE FROM tasks WHERE id = '$id'");
    header("Location: /todo/");
}
if (isset($_GET["complete"])) {
    $id = $_GET["complete"];
    $conn->query("UPDATE tasks SET status ='completed' WHERE id = '$id'");
    header("Location: /todo/");
}
$result = $conn->query("SELECT * FROM tasks ORDER BY id DESC");
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="todo-app">
            <h2>To-Do List</h2>
            <form action="" method="post">
                <div class="row">
                <input type="text" name="task" placeholder="Add task" id="">
                <button type="submit" name="addtask">Add</button>
                </div>
            </form>
            <ul>
            <?php while($row = $result->fetch_assoc()): ?>
                <li>
                    <span class="<?php echo $row['status']; ?>">
                        <?php echo $row['task']; ?>
                    </span>
                    <div class="actions">
                        <a href="index.php?complete=<?php echo $row['id']; ?>"> &#x2705</a>
                        <a href="index.php?delete=<?php echo $row['id']; ?>">&#215</a>
                    </div>
                </li>
                <?php echo "<!-- Status: " . $row['status'] . " -->"; ?>
            <?php endwhile ?>
            </ul>
        </div>
    </div>
</body>
</html>
