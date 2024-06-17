<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: auth.html");
    exit();
}
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
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    .admin-container {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        max-width: 600px;
        width: 100%;
    }
    .admin-container h2 {
        color: #0056b3;
    }
    .admin-container input[type="text"],
    .admin-container input[type="date"],
    .admin-container textarea,
    .admin-container input[type="submit"] {
        width: calc(100% - 20px);
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
        box-sizing: border-box;
    }
    .admin-container input[type="submit"] {
        background-color: #0056b3;
        color: #ffffff;
        cursor: pointer;
    }
    .admin-container input[type="submit"]:hover {
        background-color: #004080;
    }
</style>
</head>
<body>
<div class="admin-container">
    <h2>Добавить Волонтёрское Мероприятие</h2>
    <form action="add_event.php" method="post">
        <input type="text" name="event_name" placeholder="Название мероприятия" required><br>
        <input type="date" name="event_date" required><br>
        <input type="text" name="location" placeholder="Место проведения" required><br>
        <textarea name="description" placeholder="Описание мероприятия" required></textarea><br>
        <input type="submit" value="Добавить Мероприятие">
    </form>
</div>
</body>
</html>
