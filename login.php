<?php
include 'config.php';

if(isset($_POST['guest'])){
    $username = 'guest23';
    $password = 123456;

    $query = "SELECT * FROM users WHERE username = '$username' OR email = '$username'";
            
            $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])){
                    $session_lifetime = 60 * 60 * 24 * 5;
                    session_set_cookie_params($session_lifetime);
                    session_start();
                    $_SESSION['id'] = $row['users_id'];
                    header("Location: kahzini.php");
                    exit();
                }else{
                    header("Location: login.php?e=Sorry, your password was incorrect. Please double-check your password.");
                    exit();
                }
            }else{
                    header("Location: login.php?e=Sorry, your password was incorrect. Please double-check your password.");
                    exit();
                }
        } 
    

if(isset($_POST['login'])){
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validate($_POST['detail']);
    $password = validate($_POST['password']);

    $query = "SELECT * FROM users WHERE username = '$username' OR email = '$username'";
            
            $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])){
                    $session_lifetime = 60 * 60 * 24 * 5;
                    session_set_cookie_params($session_lifetime);
                    session_start();
                    $_SESSION['id'] = $row['users_id'];
                    header("Location: kahzini.php");
                    exit();
                }else{
                    header("Location: login.php?e=Sorry, your password was incorrect. Please double-check your password.");
                    exit();
                }
            }else{
                    header("Location: login.php?e=Sorry, your password was incorrect. Please double-check your password.");
                    exit();
                }
        } 
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kahzini</title>
    <link rel="icon" href="images/logo.png">
    <link rel="stylesheet" href="login.css">
</head>
<body>
<div class="img">
    <div class="img1"><img src="images/2.jpeg" alt=""></div>
    <div class="img2"><img src="images/1.jpeg" alt=""></div>
</div>
<div class="content">
<form action="" method="post">
    <br><h2 align="center">Khazini</h2><br>
    <input type="text" name="detail" id="username" autofocus placeholder="Email or username">
    <div class="form-tag">
    <input type="password" name="password" placeholder="Password" id="password" onkeyup="hidePassword()">
    <input type="checkbox" id="show-password" onclick="showPassword()">
    <label for="show-password"><img src="images/see.png" width="20px" alt=""></label></div>
    <button type="submit" disabled name="login" id="login">Login</button>
<?php if (isset($_GET["e"])) { ?>
      <small class="e"><?php echo $_GET["e"]; ?></small>
          <?php } ?>
<br>
<a href="" align="center">Forget password?</a><br>
<button type="submit" name="guest">Continue as guest</button>
</form><br>
<div class="addon">
    Don't have an account? &nbsp; <a href="signup.php">Sign Up</a>
</div>
</div>
<script>
    function showPassword() {
        var passwordField = document.getElementById("password");
        var checkbox = document.getElementById("show-password");
        if (checkbox.checked) {
          passwordField.type = "text";
        } else {
          passwordField.type = "password";
        }
      }
      const passwordField = document.getElementById('password');
        const loginButton = document.getElementById('login');
        const usernameField = document.getElementById('username');

        function validateFields() {
        if (passwordField.value.length >= 6 && usernameField.value.length > 3) {
            loginButton.disabled = false;
        } else {
            loginButton.disabled = true;
        }
        }

        passwordField.addEventListener("input", validateFields);
        usernameField.addEventListener("input", validateFields);
</script>
