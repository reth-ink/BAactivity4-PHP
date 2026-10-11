<?php
session_start();
if (empty($_SESSION['authenticated_user'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reth's Strange Journey - Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=VT323&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<?php include 'includes/header.php'; ?>
<main>
    <?php include 'includes/hero.php'; ?>
    <?php include 'includes/characters.php'; ?>
    <?php include 'includes/overworld.php'; ?>
    <?php include 'includes/dungeon.php'; ?>
</main>
<?php include 'includes/footer.php'; ?>
