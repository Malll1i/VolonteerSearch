<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.html");
    exit();
}

$servername = "localhost";
$db_username = "root"; // Замените на ваш логин к базе данных
$db_password = ""; // Замените на ваш пароль к базе данных
$dbname = "volonteer"; // Замените на ваше имя базы данных

// Создание подключения к базе данных
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$events_sql = "SELECT * FROM volunteer_events";
$events_result = $conn->query($events_sql);

$participants_sql = "SELECT participants.*, volunteer_events.event_name FROM participants 
                     JOIN volunteer_events ON participants.event_id = volunteer_events.id";
$participants_result = $conn->query($participants_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Админ Панель</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f7fd;
        margin: 0;
        padding: 20px;
    }
    .container {
        max-width: 1000px;
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
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }
    table, th, td {
        border: 1px solid #ddd;
    }
    th, td {
        padding: 10px;
        text-align: left;
    }
    th {
        background-color: #0056b3;
        color: white;
    }
</style>
</head>
<body>
<div class="container">
    <h1>Админ Панель</h1>
    <h2>Волонтёрские Мероприятия</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Название мероприятия</th>
            <th>Дата</th>
            <th>Место</th>
            <th>Описание</th>
        </tr>
        <?php
        if ($events_result->num_rows > 0) {
            while($row = $events_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["event_name"] . "</td>";
                echo "<td>" . $row["event_date"] . "</td>";
                echo "<td>" . $row["location"] . "</td>";
                echo "<td>" . $row["description"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Нет доступных мероприятий.</td></tr>";
        }
        ?>
    </table>

    <h2>Участники Мероприятий</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Мероприятие</th>
            <th>Пользователь</th>
            <th>Телефон</th>
        </tr>
        <?php
        if ($participants_result->num_rows > 0) {
            while($row = $participants_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["event_name"] . "</td>";
                echo "<td>" . $row["username"] . "</td>";
                echo "<td>" . $row["phone"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Нет зарегистрированных участников.</td></tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
