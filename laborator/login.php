<?php
session_start();
require_once 'config.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "❌ Nume sau parolă greșită!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Autentificare</title>
    <style>
        body { font-family: Arial; max-width: 400px; margin: 50px auto; padding: 20px; }
        input { width: 100%; padding: 10px; margin: 10px 0; }
        button { background: #007bff; color: white; padding: 10px; width: 100%; border: none; cursor: pointer; }
        .container { border: 1px solid #ccc; padding: 20px; border-radius: 10px; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h2> Autentificare</h2>
        <?php if($error) echo "<p style='color:red'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Nume utilizator" required>
            <input type="password" name="password" placeholder="Parolă" required>
            <button type="submit">Autentificare</button>
        </form>
        <p style="text-align:center">Nu ai cont? <a href="register.php">Înregistrează-te</a></p>
    </div>
</body>
</html>