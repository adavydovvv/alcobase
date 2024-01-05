<?php
include 'database.php';
include 'navbar.php';

$objectsPerPage = 10;
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

$offset = ($currentPage - 1) * $objectsPerPage;
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
            <h2>Объекты торговли лицензированным алкоголем</h2><br>
            <?php
            $query = "SELECT object_name, address FROM points LIMIT $objectsPerPage OFFSET $offset";
            $result = $connect->query($query);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='col-lg-6 col-md-6 col-sm-12'>";
                    echo "<div class='object-block'>";
                    echo "<h3>" . $row['object_name'] . "</h3>";
                    echo "<p class='address-column'>" . $row['address'] . "</p>";
                    echo "<a href='full_object_page.php?object_id={$row['object_id']}'>Подробнее об объекте</a>";
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

            echo "<div class='col-lg-6 col-md-6 col-sm-12'>";
            if ($currentPage > 1) {
                $prevPage = $currentPage - 1;
                echo "<a href='?page=$prevPage'>Предыдущая</a>";
            }

            if ($currentPage < $totalPages) {
                $nextPage = $currentPage + 1;
                echo "<a href='?page=$nextPage'>Следующая</a>";
            }
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