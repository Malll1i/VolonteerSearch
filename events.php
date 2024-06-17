<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$servername = "localhost";
$db_username = "root"; 
$db_password = ""; 
$dbname = "volonteer"; 

// Создание подключения к базе данных
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM volunteer_events";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Мероприятия</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f7fd;
        margin: 0;
        padding: 20px;
    }
    .container {
        max-width: 800px;
        margin: 0 auto;
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
        color: #0056b3;
        text-align: center;
    }
    .event {
        border-bottom: 1px solid #ddd;
        padding: 10px 0;
    }
    .event:last-child {
        border-bottom: none;
    }
    .event h2 {
        color: #0056b3;
        margin: 0;
    }
    .event p {
        margin: 5px 0;
    }
</style>
</head>
<body>
<div class="container">
    <h1>Волонтёрские Мероприятия</h1>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='event'>";
            echo "<h2>" . $row["event_name"] . "</h2>";
            echo "<p><strong>Дата:</strong> " . $row["event_date"] . "</p>";
            echo "<p><strong>Место:</strong> " . $row["location"] . "</p>";
            echo "<p><strong>Описание:</strong> " . $row["description"] . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>Нет доступных мероприятий.</p>";
    }
    $conn->close();
    ?>
</div>
</body>
</html>
