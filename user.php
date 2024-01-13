<?php
session_start();
include 'database.php';
include 'navbar.php';
$userId = $_SESSION['user_id'];

$query = "SELECT name FROM users WHERE user_id=?";
$stmt = $connect->prepare($query);
$stmt->bind_param('s', $userId);
$stmt->execute();
$result = $stmt->get_result();
if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $userName = $user['name'];
}
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
        <?php if (isset($userName)) : ?>
            <div class="container">
            <div class="row">
            <div class='col-lg-12'>
            <div class ="object-block">
            <h2><?php echo $userName; ?></h2><br>
            <a href="" class="btn btn-primary">Изменить данные</a>
            <a href="logout.php" class="btn btn-primary">Выйти</a>
            <?php else : ?>
            <p>Ошибка загрузки данных пользователя.</p>
            <?php endif; ?>
            </div>
            </div>
            </div>
            </div>
<footer>
    <p><a>Пользователь</a></p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>