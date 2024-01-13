<?php
include 'database.php';

session_start();

if (isset($_SESSION['user_id'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userId = $_SESSION['user_id'];
        $pointId = $_POST['point_id'];
        $rating = $_POST['rating'];
        $comment = $_POST['comment'];

        $sql = "INSERT INTO reviews (point_id, user_id, rating, comment, timestamp) VALUES ($pointId, $userId, $rating, '$comment', NOW())";
        $result = $connect->query($sql);

        if ($result) {
            header("Location: points.php?object_id=$pointId"); 
            exit;
        } else {
            echo $connect->error;
        }
    } else {
        echo "Недопустимый метод запроса.";
    }
} else {
    header("Location: login.php"); 
    exit;
}
?>
