<?php
include 'database.php';
include 'navbar.php';
session_start();

if (isset($_SESSION['user_id']) && $_SESSION['label'] != 0) {
    $userLabel = $_SESSION['label'];

    $objectsPerPage = 10;
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

    $offset = ($currentPage - 1) * $objectsPerPage;
    $typeFilter = isset($_GET['type']) ? $_GET['type'] : '';

    $query = "SELECT point_id, object_name, address FROM points";

    if ($typeFilter !== '') {
        $query .= " WHERE object_name LIKE ? AND label = ? LIMIT ? OFFSET ?";

        $stmt = $connect->prepare($query);
        $stmt->bind_param('siii', $userLabel, $typeFilter, $objectsPerPage, $offset);

    } else {
        $query .= " WHERE label = ? LIMIT ? OFFSET ?";

        $stmt = $connect->prepare($query);
        $stmt->bind_param('iii', $userLabel, $objectsPerPage, $offset);
    }

}
else{
$objectsPerPage = 10;
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

$offset = ($currentPage - 1) * $objectsPerPage;
$typeFilter = isset($_GET['type']) ? $_GET['type'] : '';

$query = "SELECT point_id, object_name, address FROM points";

if ($typeFilter !== '') {
    $query .= " WHERE object_name LIKE ? LIMIT ? OFFSET ?";

    $stmt = $connect->prepare($query);
    $stmt->bind_param('sii', $typeFilter, $objectsPerPage, $offset);

} else {
    $query .= " LIMIT ? OFFSET ?";

    $stmt = $connect->prepare($query);
    $stmt->bind_param('ii', $objectsPerPage, $offset);
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
    <title>АлкоХаб</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="col-12">
                <br>
                <div class="p-4 text-center" style="border-radius: 10px; background-color: #f8f9fa; border: 1px solid #dee2e6;">
                    <h2>Объекты торговли лицензированным алкоголем <br> на основе личных предпочтений</h2>
                </div>
                
                <br>
            </div>
            <br>
        </div>
</div>
    <div class="row">
            <?php
             $stmt->execute();
             $result = $stmt->get_result();

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
            ?>
        </div>  
        <div class = "row">
            <?php
            $query = "SELECT COUNT(*) AS total FROM points";
            $stmt = $connect->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
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
            <br>
            <br>
            <br>
            <br>
        </div>
</div>
<footer>
    <p><a href = 'https://data.mos.ru/opendata/586?isDynamic=false'>Ссылка на источник данных</a></p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>