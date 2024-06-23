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


$conn = new mysqli($servername, $db_username, $db_password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'];
    $phone = $_POST['phone'];
    $username = $_SESSION['username'];

    // Защита от SQL инъекций
    $event_id = $conn->real_escape_string($event_id);
    $phone = $conn->real_escape_string($phone);

    // Вставка данных о регистрации на участие
    $sql = "INSERT INTO participants (event_id, username, phone) VALUES ('$event_id', '$username', '$phone')";
    if ($conn->query($sql) === TRUE) {
        echo "Вы успешно зарегистрированы на участие.";
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
