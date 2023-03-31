<?php 
include 'config.php';
session_start();
$users_id = $_SESSION['id'] ?? 0;
if(!isset($_SESSION['id'])){
    header("Location: login.php");
      exit();
  }
include 'header.php';
?>
<main>
  <div class="hide">
  <h3>Theme is still in development!</h3>
<input type="radio" id="lightModeToggle" name="themeToggle" value="light-mode" checked>
<label for="lightModeToggle">Dark mode</label><br>
<input type="radio" id="darkModeToggle" name="themeToggle" value="dark-mode">
<label for="darkModeToggle">Light mode</label></div><br>
<a href="logout.php">Logout</a>
</main>