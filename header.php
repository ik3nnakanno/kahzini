<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khazini</title>
    <link rel="icon" href="images/logo.png">
    <link rel="stylesheet" href="app.css">
    <script src="js/theme.js" defer></script>
    <script src="js/search.js" defer></script>
    <script src="js/close.js" defer></script>
    <script src="js/links.js"></script>
    <script src="js/likes.js"></script>
    <script src="js/comment.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

</head>
<body class="body">
    <header><h1><a href="kahzini.php"> Khazini</a></h1></header>
    <nav>
        <div class="abeg"><h1><a href="kahzini.php">Khazini</a></h1></div>
        <form id="search-form" method="post">
        <div id="search">
        <input type="search" name="search" id="search-input">
        <button type="submit"><img src="images/search.png" alt=""></button>
    </div></form>

    <div id="search_box">
        <div class="show">
          <form id="search-form2" method="post">
        <div class="search">
        <input type="search" name="search" id="search-input2">
        <button type="submit"><img src="images/search.png" alt=""></button>
        </div></form>
            <div id="x">
            <img src="images/close.png" width="20px" alt="" ></div><br>
            <div id="output"></div>
        </div>
    </div>
        <a href="kahzini.php"><h3>Home</h3><img src="images/home.png" alt=""></a>
        <a href="post.php"><h3>Post</h3><img src="images/send.png" alt=""></a>
        <a href="message.php"><h3>Messages</h3><img src="images/mail.png" alt="">&nbsp;<span>1</span></a>
        <a href="profile.php"><h3>Profile</h3><img src="images/user.png" alt=""></a>
        <a href="more.php"><h3>More</h3><img src="images/more.png" alt=""></a>
    </nav>

    <script>
    
    document.addEventListener('DOMContentLoaded', function () {
  const search = document.querySelector('#search');
  const searchBox = document.querySelector('#search_box');
  const x = document.querySelector('#x');

  if (search && searchBox) {
    search.addEventListener('click', function () {
      searchBox.style.display = 'block';
    });
  }

  x.addEventListener('click', function () {
    searchBox.style.display = 'none';
  });

  $('#search-form').on('submit', function (event) {
    event.preventDefault(); // Prevent the form from submitting
  });

  $('#search-input').on('keyup', function () {
    var searchValue = $(this).val();
    if (searchValue != '') {
      $.ajax({
        type: 'POST',
        url: 'search.php', // replace with the name of your PHP file
        data: $('#search-form').serialize(),
        success: function (response) {
          $('#output').html(response);
        },
      });
    } else {
      $('#output').html('');
    }
  });
});
$('#search-input2').on('keyup', function () {
    var searchValue = $(this).val();
    if (searchValue != '') {
      $.ajax({
        type: 'POST',
        url: 'search.php', // replace with the name of your PHP file
        data: $('#search-form2').serialize(),
        success: function (response) {
          $('#output').html(response);
        },
      });
    } else {
      $('#output').html('');
    }
  });

    </script>