<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: auth.html");
    exit();
}

$servername = "localhost";
$db_username = "root"; 
$db_password = ""; 
$dbname = "volonteer"; 


$conn = new mysqli($servername, $db_username, $db_password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    // Защита от SQL инъекций
    $event_name = $conn->real_escape_string($event_name);
    $event_date = $conn->real_escape_string($event_date);
    $location = $conn->real_escape_string($location);
    $description = $conn->real_escape_string($description);

    // Вставка нового мероприятия
    $sql = "INSERT INTO volunteer_events (event_name, event_date, location, description) VALUES ('$event_name', '$event_date', '$location', '$description')";
    if ($conn->query($sql) === TRUE) {
        echo "Мероприятие успешно добавлено.";
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
