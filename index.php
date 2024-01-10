<?php
include 'database.php';
include 'navbar.php';

$objectsPerPage = 10;
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

$offset = ($currentPage - 1) * $objectsPerPage;
$typeFilter = isset($_GET['type']) ? $_GET['type'] : '';

$query = "SELECT point_id, object_name, address FROM points";

if ($typeFilter !== '') {
    $query .= " WHERE object_name LIKE '%$typeFilter%' LIMIT $objectsPerPage OFFSET $offset";
} else {
    $query .= " LIMIT $objectsPerPage OFFSET $offset";
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
<div class="container">
<div class="row">
<div class='col-lg-12'>
    <div class="p-4 bg-light text-center text-white">
        <h2>Объекты торговли лицензированным алкоголем</h2>
    </div><br>
</div>
<div class='col-lg-6 col-md-6 col-sm-12'>
    <div class="btn-group">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle='dropdown'>Тип объекта<span class='caret'></span></button>
        <ul class='dropdown-menu'>
            <?php
            $typeQuery = "SELECT DISTINCT SUBSTRING_INDEX(object_name, ' ', 1) AS type FROM points";
            $result = $connect->query($typeQuery);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li><a class='dropdown-item' href='?page=1&type=" . urlencode($row['type']) . "'>" . $row['type'] . "</a></li>";
                }
            }
            ?>
        </ul>
    </div>
</div>
</div>
</div>

  <div class="container">
    <div class="row">
            <?php
            $result = $connect->query($query);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='col-lg-6 col-md-6 col-sm-12'>";
                    echo "<div class='object-block'>";
                    echo "<h3>" . $row['object_name'] . "</h3>";
                    echo "<p class='address-column'>" . $row['address'] . "</p>";
                    echo "<a href='points.php?object_id={$row['point_id']}'>Подробнее об объекте</a>";
                    echo "</div>";
                    echo "</div>";
                }
            }
                    
            $query = "SELECT COUNT(*) AS total FROM points";
            $result = $connect->query($query);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $totalObjects = $row['total'];
            }

            $totalPages = ceil($totalObjects / $objectsPerPage);
            echo "<div class='col-12'>";
            echo "<div class='pagination-links'>";
            echo "<a href='?page=1&type=$typeFilter'>Первая страница</a>";
            if ($currentPage > 1) {
                $prevPage = $currentPage - 1;
                echo "<a href='?page=$prevPage&type=$typeFilter'>Предыдущая страница</a>";
            }

            if ($currentPage < $totalPages) {
                $nextPage = $currentPage + 1;
                echo "<a href='?page=$nextPage&type=$typeFilter'>Следующая страница</a>";
            }
            echo "<a href='?page=$totalPages&type=$typeFilter'>Последняя страница</a>";
            echo "</div>";
            echo "</div>";
            ?>
        </div>
</div>

<footer>
    <p><a href = 'https://data.mos.ru/opendata/586?isDynamic=false'>Ссылка на источник данных</a></p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>