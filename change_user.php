<?php
include 'database.php';
include 'navbar.php';
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300&display=swap" rel="stylesheet">
    <title>АлкоХаб</title>
    
</head>

<body>
<?php

if (!empty($_POST)) {
    session_start();
    $userId = $_SESSION['user_id'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $name = $_POST['name'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    
    $query = "UPDATE users u SET u.password = ?, u.name = ? WHERE user_id = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param('ssi', $hashedPassword, $name, $userId);
    $stmt->execute();
    session_destroy();
    header("Location: login.php");
    exit;
    
}
?>

<form class="f1" method="POST" action="">
    <div>
        <label>Новые ФИО</label>
        <input class="form-control" type="text" name="name">
    </div>


    <div>
        <label>Новый пароль</label>
        <input class="form-control" type="password" name="password">
    </div>
    <br>
    <div>
        <button class='btn-primary' type="submit">Отправить</button>
    </div>
</form>

<footer>
    <p><a>АлкоХаб</a></p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>