<?php
session_start();

if (!isset($_SESSION['username'])) {
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

// Получение данных из формы фильтрации
$filter_name = isset($_GET['filter_name']) ? $_GET['filter_name'] : '';
$filter_date = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';
$filter_location = isset($_GET['filter_location']) ? $_GET['filter_location'] : '';

$sql = "SELECT * FROM volunteer_events WHERE 1=1";

if ($filter_name) {
    $filter_name = $conn->real_escape_string($filter_name);
    $sql .= " AND event_name LIKE '%$filter_name%'";
}

if ($filter_date) {
    $filter_date = $conn->real_escape_string($filter_date);
    $sql .= " AND event_date = '$filter_date'";
}

if ($filter_location) {
    $filter_location = $conn->real_escape_string($filter_location);
    $sql .= " AND location LIKE '%$filter_location%'";
}

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
    .filter-form {
        text-align: center;
        margin-bottom: 20px;
    }
    .filter-form input[type="text"],
    .filter-form input[type="date"],
    .filter-form input[type="submit"] {
        padding: 10px;
        margin: 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
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
    .event form {
        text-align: center;
        margin-top: 10px;
    }
    .event form input[type="text"] {
        padding: 10px;
        margin: 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
    }
    .event form input[type="submit"] {
        padding: 10px 20px;
        background-color: #0056b3;
        color: #ffffff;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
    }
    .event form input[type="submit"]:hover {
        background-color: #004080;
    }
</style>
</head>
<body>
<div class="container">
    <h1>Волонтёрские Мероприятия</h1>
    <div class="filter-form">
        <form method="get" action="events.php">
            <input type="text" name="filter_name" placeholder="Название мероприятия" value="<?php echo htmlspecialchars($filter_name); ?>">
            <input type="date" name="filter_date" value="<?php echo htmlspecialchars($filter_date); ?>">
            <input type="text" name="filter_location" placeholder="Место проведения" value="<?php echo htmlspecialchars($filter_location); ?>">
            <input type="submit" value="Фильтровать">
        </form>
    </div>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='event'>";
            echo "<h2>" . $row["event_name"] . "</h2>";
            echo "<p><strong>Дата:</strong> " . $row["event_date"] . "</p>";
            echo "<p><strong>Место:</strong> " . $row["location"] . "</p>";
            echo "<p><strong>Описание:</strong> " . $row["description"] . "</p>";
            echo "<form method='post' action='participate.php'>";
            echo "<input type='hidden' name='event_id' value='" . $row["id"] . "'>";
            echo "<input type='text' name='phone' placeholder='Введите ваш номер телефона' required>";
            echo "<input type='submit' value='Участвовать'>";
            echo "</form>";
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
