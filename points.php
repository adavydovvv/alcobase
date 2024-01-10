<?php
include 'database.php';
include 'navbar.php';


$object_id = $_GET['object_id'] ?? null;

if ($object_id) {
    $sql = "SELECT * FROM points WHERE point_id = $object_id";
    $result = $connect->query($sql);

    if ($result->num_rows > 0) {
        $object = $result->fetch_assoc();
    } else {
        echo "Error";
    }
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
    <script src="script.js"></script>
    <title>АлкоХаб</title>
    
</head>

<body>
<div class="container mt-4">
        <h2>Информация о объекте торговли</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="object-details">
                    <h3>Название объекта: <?php echo $object['object_name']; ?></h3>
                    <p><strong>Адрес:</strong> <?php echo $object['address']; ?></p>
                    <p><strong>Административный район:</strong> <?php echo $object['adm_area']; ?></p>
                    <p><strong>Район:</strong> <?php echo $object['district']; ?></p>
                    <p><strong>E-mail:</strong> <?php echo $object['email']; ?></p>
                    <p><strong>ИНН:</strong> <?php echo $object['inn']; ?></p>
                    <p><strong>КПП:</strong> <?php echo $object['kpp']; ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="object-details">
                    <h3>Лицензия</h3>
                    <p><strong>Номер лицензии:</strong> <?php echo $object['license_number']; ?></p>
                    <p><strong>Реестр лицензий:</strong> <?php echo $object['license_registry']; ?></p>
                    <p><strong>Дата установки лицензии:</strong> <?php echo $object['license_installdate']; ?></p>
                    <p><strong>Статус лицензии:</strong> <?php echo $object['license_status']; ?></p>
                    <p><strong>Уполномоченный орган:</strong> <?php echo $object['license_authority']; ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="object-details">
                    <h3>Отзывы и рейтинг</h3>
                    <?php
                    $pointId = $object['point_id'];

                    $sql = "SELECT * FROM reviews JOIN users ON reviews.user_id = users.user_id WHERE point_id = $pointId";
                    $result = $connect->query($sql);
                    echo "<hr>";
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<p><strong>" . $row['name'] . "</strong> ". $row['timestamp'] . "</p>";
                            echo "<p><strong>Оценка:</strong> " . $row['rating'] . "</p>";
                            echo "<p><strong>Отзыв:</strong> " . $row['comment'] . "</p>";
                            echo "<hr>";
                        }
                    } else {
                        echo "Отзывов пока нет.";
                    }

                    session_start();
                    if (isset($_SESSION['user_id'])) {
                        ?>
                        <form method="POST" action="rew_treat.php" id="reviewForm">
                        <label for="rating" class="form-label">Оценка</label>
                        <input type="hidden" name="point_id" value="<?php echo $pointId; ?>">
                        <div class="mb-3">
                            <div class="rating">
                                <input type="radio" id="star5" name="rating" value="5"><label for="star5"></label>
                                <input type="radio" id="star4" name="rating" value="4"><label for="star4"></label>
                                <input type="radio" id="star3" name="rating" value="3"><label for="star3"></label>
                                <input type="radio" id="star2" name="rating" value="2"><label for="star2"></label>
                                <input type="radio" id="star1" name="rating" value="1"><label for="star1"></label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label">Отзыв</label>
                            <textarea class="form-control" name="comment" id="comment" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Отправить отзыв</button>
                    </form>
                        <?php
                    } else {
                        echo "<p>Чтобы оставить отзыв необходимо авторизоваться.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

<footer>
    <p><a href = 'https://data.mos.ru/opendata/586?isDynamic=false'>Ссылка на источник данных</a></p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>