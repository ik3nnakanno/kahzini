<?php
// include 'config.php';
// session_start();
// $users_id = $_SESSION['id'] ?? 0;

// $post_id = $_POST['post_id'];
//     $comment = $_POST['comment'];
// if(!empty($comment) && $users_id != 0) {
 
  // $querycc = "INSERT INTO `comment`(users_id, post_id, comment)" . "VALUES('$users_id', '$post_id', '$comment')";
  // $resultcc = mysqli_query($conn, $querycc) or die("Operation failed".MYSQLI_ERROR($conn));

  // Update the comment count in the post table
  // $queryup = "UPDATE `posts` SET comment_count = comment_count + 1 WHERE post_id = '$post_id'";
  // $resultup = mysqli_query($conn, $queryup) or die("Operation failed".MYSQLI_ERROR($conn));

  // Query the database for the updated comment count
  // $querycc = "SELECT COUNT(*) AS comment_count FROM `comment` WHERE post_id = '{$post_id}'";
  // $resultcc = mysqli_query($conn, $querycc) or die("Operation failed".MYSQLI_ERROR($conn));
  // $rowcc = mysqli_fetch_assoc($resultcc);
  // $comment_count = $rowcc['comment_count'];

  // $csql = "SELECT * FROM comment WHERE post_id = '$post_id'";
  // $resultc = mysqli_query($conn, $csql);
  // $count  = mysqli_num_rows($resultc);

  // Output the updated comment count
  // echo $comment_count;
// }
//  else {
//   echo "$count";
// }

include 'config.php';
session_start();
$users_id = $_SESSION['id'] ?? 0;

$post_id = $_POST['post_id'];
$comment = $_POST['comment'];

if(!empty($comment) && $users_id != 0) {
  
  $querycc = "INSERT INTO `comment`(users_id, post_id, comment)" . "VALUES('$users_id', '$post_id', '$comment')";
  $resultcc = mysqli_query($conn, $querycc) or die("Operation failed".MYSQLI_ERROR($conn));

  // Query the database for the updated comment count
  $querycc = "SELECT COUNT(*) AS comment_count FROM `comment` WHERE post_id = '{$post_id}'";
  $resultcc = mysqli_query($conn, $querycc) or die("Operation failed".MYSQLI_ERROR($conn));
  $rowcc = mysqli_fetch_assoc($resultcc);
  $comment_count = $rowcc['comment_count'];

  $csql = "SELECT * FROM comment WHERE post_id = '$post_id'";
  $resultc = mysqli_query($conn, $csql);
  $count  = mysqli_num_rows($resultc);
  // Output the updated comment count as a JSON-encoded string
  // $response = array('comment_count' => $comment_count);
  // echo json_encode($response);
}


?>
