<?php
include "config.php";
session_start();
$users_id = $_SESSION['id'] ?? 0;
if(!isset($_SESSION['id'])){
  header("Location: login.php");
    exit();
}
if(isset($_POST['post']) && isset($_FILES['photo'])){
  function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $caption = validate($_POST['caption']);
  $img_name = $_FILES['photo']['name'];
  $img_size = $_FILES['photo']['size'];
  $tmp_name = $_FILES['photo']['tmp_name'];
  $error = $_FILES['photo']['error'];

  if ($img_size > 2513024){
    header("Location: post.php?error=File too large");
    exit();
  }

  $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
  $img_ex_lc = strtolower($img_ex);

  $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
  $img_ex_lc = strtolower($img_ex);

  $allowed_exs = array("jpg", "png", "jpeg", "webp");

  if (in_array($img_ex_lc, $allowed_exs)){
      $new_img_name = uniqid("khazini-", true).'.'.$img_ex_lc;
      $img_upload_path = 'uploads/'.$new_img_name;
      move_uploaded_file($tmp_name, $img_upload_path);



    $query = "INSERT INTO `posts`(users_id, caption, photo)" . "VALUES('$users_id', '$caption', '$new_img_name')";
    $result = mysqli_query($conn, $query) or die("Operation failed".MYSQLI_ERROR($conn));
    header('location: profile.php');
  
  } else {
    header("Location: post.php?error=Invalid image format");
    exit();
  } }
// } else {
//   header("Location: post.php?error=Unknown error occurred");
//   exit();
// }


include 'header.php';
?>
<main>
<form action="" method="post" enctype="multipart/form-data">
    <div class="caption">
        <h3>Caption</h3>
        <textarea name="caption" id="textarea" placeholder="what's on your mind.."></textarea>
    </div><br>
    <div class="photo">
    <h3>Add Image</h3>
    <input type="file"  accept="image/png, image/jpg, image/jpeg" id="image-input"name="photo" ><br>
    <div class="image-previewed">
      <br>
      <img id="preview" src="#" onerror="this.src='images/no-image-found-360x260.png';">
      </div>
      
<br />
    <button type="submit" name="post" id="button">Post</button>
</form>
</div>
</div></div><br><br><br><br>
<div class="theme">
<input type="radio" id="lightModeToggle" name="themeToggle" value="light-mode" checked>
<label for="lightModeToggle">Dark mode</label><br>
<input type="radio" id="darkModeToggle" name="themeToggle" value="dark-mode">
<label for="darkModeToggle">Light mode</label><br>
<a href="logout.php">Logout</a>
                </div>
<script>
 $(document).ready(function() {
  // Function to display the preview image
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#preview').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    } else {
      $('#preview').attr('src', 'images/1.jpeg');
    }
  }

  // Listen for a change event on the file input field
  $('#image-input').change(function() {
    readURL(this);
  });
});
</script>
