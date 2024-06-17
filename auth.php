<?php
session_start();

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Защита от SQL инъекций
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    // Поиск пользователя в базе данных
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $row['role'];
        if ($row['role'] == 'admin') {
            header("Location: admin_panel.php");
        } else {
            header("Location: events.php");
        }
    } else {
        echo "Ошибка: Неверное имя пользователя или пароль.";
    }
}

$conn->close();
?>
