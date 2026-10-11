<?php
session_start();
$username = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if (!preg_match('/^[A-Za-z0-9_]{3,20}$/', $username)) {
        $error = 'Username must be 3 to 20 characters and contain only letters, numbers, or underscores.';
    } elseif (!preg_match('/^.{5,}$/s', $password)) {
        $error = 'Password must contain at least 5 characters.';
    } elseif ($username !== 'admin' || $password !== '12345') {
        $error = 'Incorrect login details. Demo login: admin / 12345';
    } else {
        $_SESSION['authenticated_user'] = $username;
        header('Location: index.php');
        exit;
    }
}
function e($value) { return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=VT323&display=swap" rel="stylesheet">
  <style>

    :root {
      --pixel-dark: #120e24;
      --pixel-purple: #2d1b4e;
      --pixel-accent: #ff0055;
      --pixel-cyan: #00f0ff;
      --pixel-yellow: #ffe600;
      --pixel-light: #e0f8cf;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'VT323', monospace;
    }

    body {
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(rgba(18, 14, 36, 0.58), rgba(31, 18, 53, 0.78)), url('background.jpg') center / cover no-repeat;
      padding: 20px;
    }

    .form-container {
      background: var(--pixel-purple);
      border: 4px solid #ffffff;
      padding: 40px 30px;
      width: 100%;
      max-width: 400px;
      box-shadow: 8px 8px 0 #000000, 12px 12px 0 var(--pixel-accent);
      color: var(--pixel-light);
      text-align: center;
    }

    .form-container h1 {
      color: var(--pixel-yellow);
      font-family: 'Press Start 2P', cursive;
      font-size: 1.3rem;
      margin-bottom: 25px;
      line-height: 1.5;
      text-shadow: 3px 3px var(--pixel-accent);
    }

    .input-group {
      margin-bottom: 20px;
      text-align: left;
    }

    .input-group label {
      display: block;
      color: var(--pixel-cyan);
      font-size: 1.15rem;
      margin-bottom: 6px;
    }

    .server-error { color: #ff8cae; background: #120e24; border: 2px solid #ff0055; padding: 8px; margin-bottom: 16px; }

    .success-message { color: #e0f8cf; background: #120e24; border: 2px solid #00f0ff; padding: 8px; margin-bottom: 16px; }

    .input-group label.error {
      color: var(--pixel-accent);
      font-size: 1rem;
      margin: 4px 0 0;
    }

    .input-group input {
      width: 100%;
      padding: 12px 14px;
      background: var(--pixel-dark);
      border: 2px solid var(--pixel-cyan);
      border-radius: 0;
      color: #ffffff;
      font-size: 1.15rem;
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s;
    }

    .input-group input::placeholder {
      color: #c8c0d8;
    }

    .input-group input:focus {
      border-color: var(--pixel-yellow);
      box-shadow: 0 0 0 2px var(--pixel-yellow);
    }

    .form-options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 1.05rem;
      margin-bottom: 25px;
    }

    .remember-me {
      display: flex;
      align-items: center;
      gap: 6px;
      cursor: pointer;
    }

    .remember-me input {
      accent-color: var(--pixel-accent);
    }

    .forgot-link {
      color: var(--pixel-yellow);
      text-decoration: none;
    }

    .forgot-link:hover {
      text-decoration: underline;
    }

    .btn-submit {
      width: 100%;
      padding: 12px;
      background: var(--pixel-accent);
      color: #ffffff;
      border: 3px solid #ffffff;
      border-radius: 0;
      font-family: 'Press Start 2P', cursive;
      font-size: 0.8rem;
      cursor: pointer;
      transition: background-color 0.15s, transform 0.15s;
      box-shadow: 4px 4px 0 #000000;
    }

    .btn-submit:hover {
      background: var(--pixel-yellow);
      color: #000000;
      transform: translate(-2px, -2px);
      box-shadow: 6px 6px 0 #000000;
    }

    .switch-link {
      margin-top: 20px;
      font-size: 1.05rem;
    }

    .switch-link a {
      color: var(--pixel-cyan);
      text-decoration: none;
    }

    .switch-link a:hover {
      text-decoration: underline;
    }

    @media (max-width: 480px) {
      .form-container {
        padding: 30px 20px;
        box-shadow: 5px 5px 0 #000000, 8px 8px 0 var(--pixel-accent);
      }

      .form-container h1 {
        font-size: 1.05rem;
      }

      .form-options {
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
      }
    }
  
  </style>
</head>
<body>
  <main class="form-container">
    <h1>Login</h1>
    <?php if ($error !== ''): ?><p class="server-error" role="alert"><?= e($error) ?></p><?php endif; ?>
    <form id="login-form" action="login.php" method="POST" novalidate>
      <div class="input-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Enter username" value="<?= e($username) ?>" required pattern="[A-Za-z0-9_]{3,20}" autocomplete="username">
      </div>
      <div class="input-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter password" required minlength="5" autocomplete="current-password">
      </div>
      <div class="form-options">
        <label class="remember-me"><input type="checkbox" name="remember"> Remember me</label>
        <a href="#" class="forgot-link" onclick="return false;">Forgot password?</a>
      </div>
      <button type="submit" class="btn-submit">Login</button>
      <p class="switch-link">Don't have an account? <a href="register.php">Register</a></p>
    </form>
  </main>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>
<script>
$('#login-form').validate({
  rules: { username: { required: true, minlength: 3, maxlength: 20, pattern: /^[A-Za-z0-9_]+$/ }, password: { required: true, minlength: 5 } },
  messages: { username: { required: 'Please enter your username.', minlength: 'Username must be at least 3 characters.', maxlength: 'Username must not exceed 20 characters.', pattern: 'Use only letters, numbers, and underscores.' }, password: { required: 'Please enter your password.', minlength: 'Password must be at least 5 characters.' } }
});
</script>
</body>
</html>
