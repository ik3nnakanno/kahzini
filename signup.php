<?php
include 'config.php';
if(isset($_POST['signup'])){
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
        $username = validate($_POST['username']);
        $password = validate($_POST['password']);
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $email = validate($_POST['email']);
        $name = validate($_POST['name']);
        
        $query = "INSERT INTO users (name, email, username, password) " . "VALUES('$name', '$email', '$username', '$hash')";
        $result = mysqli_query($conn, $query) or die('Wahala dey oo');
        header('location: login.php');
    }else{
    
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
    <div class="img1"><img src="images/1.jpeg" alt=""></div>
    <div class="img2"><img src="images/2.jpeg" alt=""></div>
</div>
<div class="content">
 <form action="" method="post">
        <h2 align="center">Khazini</h2>
        <input type="email" name="email" id="emailField" autofocus placeholder="Email">
        <input type="text" name="name" id="name" placeholder="Fullname">
        <input type="text" name="username" id="username" placeholder="Username">
        <div class="form-tag">
        <input type="password" name="password" id="password" placeholder="Password">
        <input type="checkbox" id="show-password" onclick="showPassword()">
        <label for="show-password"><img src="images/see.png" width="20px" alt=""></label></div>
        <input type="password" name="" id="password2" placeholder="Confirm password">
        <small>People who use our service may have uploaded your contact information to Kahzini.
            <a href="">Learn more</a>
        </small>
        <small>By signing up, you agree to our Terms , Privacy Policy and Cookies Policy .
            <a href=""></a>
        </small>
        <button type="submit" disabled name="signup" id="signup">Sign Up</button>
    </form>
<br>
<div class="addon">
Have an account?&nbsp; <a href="login.php"> Log in</a>
</div>
</div>
    <script>
        // Get the form and button elements
            const form = document.querySelector('form');
            const button = document.querySelector('#signup');

            // Add an event listener to the form
            form.addEventListener('input', () => {
            // Get the values of the form fields
            const email = document.querySelector('#emailField').value;
            const name = document.querySelector('#name').value;
            const username = document.querySelector('#username').value;
            const password = document.querySelector('#password').value;
            const password2 = document.querySelector('#password2').value;

            // Check if all the fields are filled and password is more than 5 characters
            if (email !== '' && name !== '' && username !== '' && password.length > 5 && password === password2) {
                // Enable the button
                button.disabled = false;
            } else {
                // Disable the button
                button.disabled = true;
            }
            });

    </script>
    </body>
</html>