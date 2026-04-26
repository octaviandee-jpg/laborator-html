<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body { font-family: Arial; text-align: center; margin-top: 50px; }
        .logout { background: #dc3545; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <h2>👋 Bine ai venit, <?php echo $_SESSION['username']; ?>!</h2>
    <p>Ești autentificat cu succes în sistem.</p>
    <a href="logout.php" class="logout">Delogare</a>
</body>
</html>