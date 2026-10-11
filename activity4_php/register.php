<?php
session_start();
$name = $email = $phone = '';
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    if (!preg_match("~^[A-Za-z][A-Za-z .'-]{2,49}$~", $name)) {
        $error = 'Name must be 3 to 50 characters and use letters, spaces, periods, apostrophes, or hyphens.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $email)) {
        $error = 'Please enter a valid email address.';
    } elseif ($phone !== '' && !preg_match('/^[0-9+()\- ]{7,20}$/', $phone)) {
        $error = 'Please enter a valid phone number.';
    } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*[0-9]).{5,}$/', $password)) {
        $error = 'Password must be at least 5 characters and include at least one letter and one number.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match.';
    } else {
        $success = 'Registration details validated successfully. This demo does not save accounts to a database; use admin / 12345 on the login page.';
        $name = $email = $phone = '';
    }
}
function e($value) { return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
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
      padding: 35px 30px;
      width: 100%;
      max-width: 420px;
      box-shadow: 8px 8px 0 #000000, 12px 12px 0 var(--pixel-accent);
      color: var(--pixel-light);
      text-align: center;
    }

    .form-container h1 {
      color: var(--pixel-yellow);
      font-family: 'Press Start 2P', cursive;
      font-size: 1.1rem;
      margin-bottom: 20px;
      line-height: 1.5;
      text-shadow: 3px 3px var(--pixel-accent);
    }

    .input-group {
      margin-bottom: 15px;
      text-align: left;
    }

    .input-group label {
      display: block;
      color: var(--pixel-cyan);
      font-size: 1.1rem;
      margin-bottom: 5px;
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
      padding: 10px 14px;
      background: var(--pixel-dark);
      border: 2px solid var(--pixel-cyan);
      border-radius: 0;
      color: #ffffff;
      font-size: 1.1rem;
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

    .btn-submit {
      width: 100%;
      padding: 12px;
      margin-top: 10px;
      background: var(--pixel-accent);
      color: #ffffff;
      border: 3px solid #ffffff;
      border-radius: 0;
      font-family: 'Press Start 2P', cursive;
      font-size: 0.75rem;
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

    .form-feedback {
      min-height: 1.5em;
      margin-top: 12px;
      color: var(--pixel-cyan);
      font-size: 1.1rem;
    }

    .switch-link {
      margin-top: 18px;
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
        padding: 25px 18px;
        box-shadow: 5px 5px 0 #000000, 8px 8px 0 var(--pixel-accent);
      }

      .form-container h1 {
        font-size: 0.95rem;
      }
    }
  
  </style>
</head>
<body>
  <main class="form-container">
    <h1>Register</h1>
    <?php if ($error !== ''): ?><p class="server-error" role="alert"><?= e($error) ?></p><?php endif; ?>
    <?php if ($success !== ''): ?><p class="success-message" role="status"><?= e($success) ?></p><?php endif; ?>
    <form id="register-form" action="register.php" method="POST" novalidate>
      <div class="input-group"><label for="reg-name">Name</label><input type="text" id="reg-name" name="name" placeholder="Your name" value="<?= e($name) ?>" required minlength="3" maxlength="50"></div>
      <div class="input-group"><label for="reg-email">Email Address</label><input type="email" id="reg-email" name="email" placeholder="Email Address" value="<?= e($email) ?>" required></div>
      <div class="input-group"><label for="reg-phone">Phone Number</label><input type="tel" id="reg-phone" name="phone" placeholder="Phone Number" value="<?= e($phone) ?>"></div>
      <div class="input-group"><label for="reg-password">Password</label><input type="password" id="reg-password" name="password" placeholder="Password" required minlength="5"></div>
      <div class="input-group"><label for="reg-confirm-password">Confirm Password</label><input type="password" id="reg-confirm-password" name="confirm_password" placeholder="Confirm Password" required></div>
      <button type="submit" class="btn-submit">Register</button>
      <p class="switch-link">Already have an account? <a href="login.php">Login Here</a></p>
    </form>
  </main>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>
<script>
$('#register-form').validate({
  rules: { name: { required: true, minlength: 3, maxlength: 50, pattern: /^[A-Za-z][A-Za-z .\'-]*$/ }, email: { required: true, email: true }, phone: { pattern: /^[0-9+()\- ]{7,20}$/ }, password: { required: true, minlength: 5, pattern: /^(?=.*[A-Za-z])(?=.*[0-9]).+$/ }, confirm_password: { required: true, equalTo: '#reg-password' } },
  messages: { name: 'Enter a valid name.', email: 'Enter a valid email address.', phone: 'Enter a valid phone number.', password: 'Use at least 5 characters with a letter and a number.', confirm_password: 'Passwords must match.' }
});
</script>
</body>
</html>
