<?php
include 'database.php';
include 'navbar.php';

$flag=true;
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
    <style>
        .regbutton, .regbutton a {
            padding: 8px 12px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .regbutton:hover {
            background-color: #0056b3;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300&display=swap" rel="stylesheet">
    <title>АлкоХаб</title>
    
</head>

<body>
<?php

if (!empty($_POST)) {
    $login = $_POST['login'];
    $password = $_POST['password'];


    $query = "SELECT * FROM users WHERE login=?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param('s', $login);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION["user_id"] = $user['user_id'];
            $_SESSION["label"] = $user['label'];
            header("Location: index.php");
            exit;
        }
        else{
            header("Location: login.php?error=1");
            exit;
        }
    }
    else{
        header("Location: login.php?error=1");
        exit;
    }
}
?>

<form class="form-signin w-50 m-auto" method="POST" action="">
    <h2 style="text-align: center;">Авторизация</h2><br>
    <div class="container">
    <div class="row">
    <div class='col-lg-12'>
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
            echo '<div class="error-message"><p>Неправильный логин или пароль</p></div>';
        }
        ?>
        <br>
    <div>
        <button class="regbutton" type="submit">Войти</button>
    </div>
    <br>
    
    </div>
    </div>
    <div>
        <a class='btn btn-primary'href="register.php">Регистрация</a>
    </div>
    </div>
</form>

<footer>
    <p><a>АлкоХаб: Авторизация</a></p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>