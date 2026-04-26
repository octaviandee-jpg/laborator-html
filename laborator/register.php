<?php
require_once 'config.php';
$mesaj = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    try {
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $email, $password]);
        $mesaj = "<div style='color:green;'>✅ Înregistrare reușită! <a href='login.php'>Autentifică-te</a></div>";
    } catch(PDOException $e) {
        $mesaj = "<div style='color:red;'>❌ Nume sau email deja existent!</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Înregistrare</title>
    <style>
        body { font-family: Arial; max-width: 400px; margin: 50px auto; padding: 20px; }
        input { width: 100%; padding: 10px; margin: 10px 0; }
        button { background: #4CAF50; color: white; padding: 10px; width: 100%; border: none; cursor: pointer; }
        .container { border: 1px solid #ccc; padding: 20px; border-radius: 10px; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h2> Înregistrare Utilizator</h2>
        <?php echo $mesaj; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Nume utilizator" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Parolă" required>
            <button type="submit">Înregistrare</button>
        </form>
        <p style="text-align:center">Ai deja cont? <a href="login.php">Autentifică-te</a></p>
    </div>
</body>
</html>