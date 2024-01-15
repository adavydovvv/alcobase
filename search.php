<?php
include 'database.php';

if (isset($_GET['address']) && !empty($_GET['address'])) {
    $searchTerm = '%' . $_GET['address'] . '%';
    $query = "SELECT point_id, object_name, address FROM points WHERE address LIKE ?";

    $stmt = $connect->prepare($query);
    $stmt->bind_param('s', $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div><a href='points.php?object_id={$row['point_id']}'>{$row['object_name']} - {$row['address']}</a></div>";
        }
    } else {
        echo "<div id='search-results'>Нет результатов</div>";
    }
}
?>
