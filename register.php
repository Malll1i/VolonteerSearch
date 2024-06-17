<?php
session_start();

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "volonteer"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Защита от SQL инъекций
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    // Проверка, существует ли пользователь
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "Ошибка: Пользователь с таким именем уже существует.";
    } else {

        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if ($conn->query($sql) === TRUE) {
            echo "Регистрация успешна. Вы можете <a href='auth.html'>войти</a>.";
        } else {
            echo "Ошибка: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
