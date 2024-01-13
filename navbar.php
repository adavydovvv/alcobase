<!DOCTYPE html>
<html lang="ru">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand">АлкоХаб</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Главная</a>
        </li>
        <li class="nav-item">
        <?php
        session_start();
        include 'database.php';

        if (isset($_SESSION['user_id'])) {
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
            if (isset($userName)) {
                echo "<a class='nav-link' href='user.php'>$userName</a>";
            }
            } else {
                echo "<a class='nav-link' href='login.php'>Войти</a>";
            }
            ?>
        </li>
      </ul>
    </div>
  </div>
</nav>
</html>