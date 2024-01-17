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

        $query = "CALL InsertReview(?, ?, ?, ?)";
        $stmt = $connect->prepare($query);
        $stmt->bind_param('iiis', $pointId, $userId, $rating, $comment);
        $stmt->execute();
        $result = $stmt->get_result();

        $query2 = "CALL UpdateUserLabel(?, ?)";
        $stmt2 = $connect->prepare($query2);
        $stmt2->bind_param('ii', $label, $userId);
        $stmt2->execute();
        
        $_SESSION["user_id"] = $userId;
        $_SESSION["label"] = $label;
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
