<?php
session_start();

// Si l'utilisateur est déjà connecté, redirige vers le dashboard
if (isset($_SESSION['username'])) {
    header("Location: welcome.php");
    exit;
}

// Charger les utilisateurs depuis le fichier JSON
$users = [];
if (file_exists("users.json")) {
    $jsonData = file_get_contents("users.json");
    $users = json_decode($jsonData, true);
    if (!is_array($users)) {
        $users = [];
    }
}

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    $found = false;
    foreach ($users as $user) {
        if ($user['email'] === $email && $user['password'] === $password) {
            $found = true;
            break;
        }
    }
    if ($found) {
        $_SESSION['username'] = $email;
        header("Location: welcome.php");
        exit;
    } else {
        $error_message = "Nom d'utilisateur ou mot de passe incorrect";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Page de Connexion</title>
  <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <style>
    .login-form {
      width: 300px;
      margin: 100px auto;
      padding: 20px;
      background: #1f1f1f;
      border-radius: 10px;
      text-align: center;
    }
    .login-form input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ffcc00;
      border-radius: 5px;
      background: #333;
      color: white;
    }
    .login-form button {
      padding: 10px 20px;
      background: #ffcc00;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="login-form">
    <h2>Se connecter</h2>
    <?php if(isset($error_message)): ?>
      <p style="color:red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form action="index.php" method="POST">
      <label for="username">Email :</label>
      <input type="text" id="username" name="username" required>
      <label for="password">Mot de passe :</label>
      <input type="password" id="password" name="password" required>
      <button type="submit">Connexion</button>
    </form>
  </div>
</body>
</html>
