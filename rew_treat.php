<?php
include 'database.php';

session_start();

if (isset($_SESSION['user_id'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userId = $_SESSION['user_id'];
        $pointId = $_POST['point_id'];
        $rating = $_POST['rating'];
        $comment = $_POST['comment'];
        $label = $_POST['label'];

        $query = "INSERT INTO reviews (point_id, user_id, rating, comment, timestamp) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $connect->prepare($query);
        $stmt->bind_param('iiis', $pointId, $userId, $rating, $comment);
        $stmt->execute();
        $result = $stmt->get_result();

        $query2 = "UPDATE users SET label = ? WHERE user_id = ?";
        $stmt2 = $connect->prepare($query2);
        $stmt2->bind_param('ii', $label, $userId);
        $stmt2->execute();
        
        if ($stmt) {
            header("Location: points.php?object_id=$pointId"); 
            exit;
        } else {
            echo $connect->error;
            echo $result;
        }

        
    } else {
        echo "Недопустимый метод запроса.";
    }
} else {
    header("Location: login.php"); 
    exit;
}
?>
