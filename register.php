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
    <title>АлкоХаб: Регистрация</title>
    
</head>

<body>
<?php

if (!empty($_POST)) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $name = $_POST['name'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $query = "SELECT * FROM users WHERE login=?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param('s', $login);
    $stmt->execute();
    $result = $stmt->get_result();
    if (mysqli_num_rows($result) == 0) {
        $query = "CALL InsertUser(?, ?, ?)";
        $stmt = $connect->prepare($query);
        $stmt->bind_param('sss', $login, $hashedPassword, $name);
        $stmt->execute();
        header("Location: login.php");
        exit;
    } else {
        header("Location: register.php?error=1");;
    }
}
?>

<form class="form-signin w-50 m-auto" method="POST" action="">
    <h2 style="text-align: center;">Регистрация</h2><br>
    <div>
        <label>ФИО</label>
        <input class="form-control" type="text" name="name" required>
    </div>
    <br>
    <div>
        <label>Логин</label>
        <input class="form-control" type="text" name="login" required>
    </div>
    <br>
    <div>
        <label>Пароль</label>
        <input class="form-control" type="password" name="password" required>
    </div>
    <br>
    <?php
        if (isset($_GET['error']) && $_GET['error'] == 1) {
            echo '<div class="error-message"><p>Пользователь с таким логином уже существует</p></div>';
        }
        ?>
        <br>
    <div>
        <button class='btn btn-primary' type="submit">Регистрация</button>
    </div>
</form>

<footer>
    <p><a>АлкоХаб: Регистрация</a></p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>