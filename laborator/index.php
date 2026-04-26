<?php
// Pornim sesiunea
session_start();

// Conectare la baza de date
require_once 'config.php';

// Variabile pentru mesaje
$login_error = '';
$is_logged_in = isset($_SESSION['user_id']);

// Procesare LOGIN (când utilizatorul apasă butonul)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Căutăm utilizatorul în baza de date
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    // Verificăm parola
    if ($user && password_verify($password, $user['password'])) {
        // Login reușit - salvăm în sesiune
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $is_logged_in = true;
    } else {
        $login_error = "❌ Nume sau parolă greșită!";
    }
}

// Procesare LOGOUT (când utilizatorul apasă delogare)
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Site-ul Meu - Autentificare</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 0;
        }
        
        .header {
            background: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
        }
        
        .container {
            max-width: 400px;
            margin: 50px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 30px;
        }
        
        .login-box h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        
        .login-box input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        
        .login-box button {
            width: 100%;
            padding: 12px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
        
        .login-box button:hover {
            background: #45a049;
        }
        
        .error {
            background: #ffebee;
            color: #c62828;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }
        
        .success-box {
            text-align: center;
        }
        
        .success-box h2 {
            color: #4CAF50;
        }
        
        .logout-btn {
            background: #f44336;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
        
        .logout-btn:hover {
            background: #d32f2f;
        }
        
        .register-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        
        .register-link a {
            color: #4CAF50;
            text-decoration: none;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>🏠 Site-ul Meu</h1>
</div>

<div class="container">
    <?php if (!$is_logged_in): ?>
        <!-- AFIȘĂM FORMULARUL DE LOGIN -->
        <div class="login-box">
            <h2> Autentificare</h2>
            
            <?php if ($login_error != ''): ?>
                <div class="error"><?php echo $login_error; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <input type="text" name="username" placeholder="Nume utilizator" required>
                <input type="password" name="password" placeholder="Parolă" required>
                <button type="submit" name="login">Autentificare</button>
            </form>
            
            <div class="register-link">
                Nu ai cont? <a href="register.php">Înregistrează-te aici</a>
            </div>
        </div>
        
    <?php else: ?>
        <!-- AFIȘĂM CONȚINUTUL PENTRU UTILIZATORI LOGAȚI -->
        <div class="success-box">
            <h2>👋 Bun venit, <?php echo $_SESSION['username']; ?>!</h2>
            <p>Ești autentificat cu succes pe site-ul nostru.</p>
            <p>Acum ai acces la toate funcțiile site-ului.</p>
            <a href="?logout=1" class="logout-btn">🚪 Delogare</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>


<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechZone - Acasă</title>
    <link rel="stylesheet" href="../CSS/index.css">
</head>
<body>

<header>
    <div class="logo">
        <img src="../IMG/logo.png" alt="Logo" width="80">
    </div>

    <h1>TechZone</h1>
    
    <nav>
        <a href="index.html" class="active">Acasă</a>
        <a href="telefoane.html">Telefoane</a>
        <a href="laptopuri.html">Laptopuri</a>
        <a href="periferice.html">Periferice</a>
        <a href="despre.html">Despre</a>
        <a href="contact.html">Contact</a>

        <div class="cos-wrapper">
            <button id="deschide-cos">🛒 <span id="numar-produse">0</span></button>
            <div id="cos-dropdown" class="cos-ascuns">
                <h3>Coșul tău</h3>
                <ul id="lista-cos"></ul>
                <hr>
                <p>Total: <span id="total-plata">0</span> MDL</p>
                <button id="goleste-cos">Golește Coșul</button>
            </div>
        </div>
    </nav>
</header>

<main>
    <section class="hero-section">
        <h2>Bine ai venit la TechZone!</h2>
        <p>Magazin online de telefoane și laptopuri moderne.</p>
    </section>

    <section class="container-produse">
        
        <div class="produs">
            <a href="hp_pavilion.html">
                <img src="../IMG/HP Pavilion.jpg" alt="HP Pavilion">
            </a>
            <h3><a href="hp_pavilion.html">HP Pavilion</a></h3>
            <p class="pret">13000 MDL</p>
            <button class="btn-adauga" data-nume="HP Pavilion" data-pret="13000">Adaugă în coș</button>
        </div>

        <div class="produs">
            <img src="../IMG/Samsung Galaxy S23.jpg" alt="Samsung Galaxy S23">
            <h3><a href="samsung23.html">Samsung Galaxy S23</a></h3>
            <p class="pret">15000 MDL</p>
            <button class="btn-adauga" data-nume="Samsung Galaxy S23" data-pret="15000">Adaugă în coș</button>
        </div>

        <div class="produs">
            <a href="logitech_m90.html">
                <img src="../IMG/Mouse Logitech M90.webp" alt="Mouse">
            </a>
            <h3><a href="logitech_m90.html">Mouse Logitech M90</a></h3>
            <p class="pret">400 MDL</p>
            <button class="btn-adauga" data-nume="Mouse Logitech M90" data-pret="400">Adaugă în coș</button>
        </div>

    </section>
</main>

<footer>
    <p>© 2026 TechZone. Toate drepturile rezervate.</p>
</footer>

<script src="../JS/cos.js"></script>
</body>
</html>