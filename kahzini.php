<?php
include 'config.php';

ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 5);

// set the session cookie lifetime to 5 days
$session_lifetime = 60 * 60 * 24 * 5;
session_set_cookie_params($session_lifetime);
session_start();
$users_id = $_SESSION['id'] ?? 0;
if(!isset($_SESSION['id'])){
  header("Location: login.php");
    exit();
}

include 'header.php';
if(isset($_POST['view'])){
  $postid = $_POST['post_id'];
  $view = mysqli_query($conn, "SELECT * FROM posts where post_id = '$postid'");
  $line=mysqli_fetch_array($view);
    $posters_id = $line['users_id'];


    $vql = mysqli_query($conn,"SELECT * FROM users WHERE users_id = '$posters_id'");
    $vline=mysqli_fetch_array($vql);

  ?>
  <form action="" method="post">
    <div class="view">
      <div class="clos">
          <img src="images/close.png"  width="28px"class="x" alt="">
        </div>
        <div class="content">
            <div class="media">
                <img src="uploads/<?= $line['photo'];?>" width="100%" alt="">
                
            </div>
            <div class="written">
                <div class="comm">
                    <div class="owner">
                    <a href="user.php?p=<?= $vline['username'];?>">
                    <div class="topp">
                    <img src="profile/<?= $vline['pic'];?>"class="comimg" class="img" width="45px" height="45px" alt="">
                        <label><b><?= $vline['username'];?></b>
                        <?php
                            if($vline['verified'] == 1){
                              ?>
                              <img src="images/verified.png" width="12px" alt="">
                              <?php
                          }else{}
                        ?>
                        </label>
                        </div></a>
                        <br>
                        <label><?= $line['caption'];?></label><br>
                        <small>
                        <?php
                            $data_added_time = $line['date'];
                            $current_time = time();
                            $data_added_timestamp = strtotime($data_added_time);
                            $time_diff = $current_time - $data_added_timestamp;
                            
                            if ($time_diff < 60) {
                              echo "Just now";

                            } elseif ($time_diff < 3600) {

                              $minutes = floor($time_diff / 60);
                              echo $minutes . " m";

                            } elseif ($time_diff < 86400) {

                              $hours = floor($time_diff / 3600);
                              echo $hours . " h";

                            } elseif($time_diff > 86399 && $time_diff < 172800) {
                              // $day = floor($time_diff / 86400);
                              echo "1 day ago";
                            } else {
                              $days = floor($time_diff / 172800);
                              echo $days . " days ago";
                            }
                          ?>
                        </small>
                    </div>
                    <div class="comms">
                    <?php
                    $comm = "SELECT * FROM comment where post_id = '$postid'";
                    $clines=mysqli_query($conn, $comm);
                    while($cline=mysqli_fetch_array($clines)){
                    $liker_id = $cline['users_id'];
                    $likers= "SELECT * FROM users WHERE users_id = '$liker_id'";
                    $likerr = mysqli_query($conn, $likers);
                    while($lik=mysqli_fetch_array($likerr)){
                    ?><div class="commenters">
                        <a href="user.php?p=<?= $lik['username'];?>"><img  src="profile/<?= $lik['pic'];?>"class="comimg" width="45px" height="45px" alt="">
                        <p><b><?= $lik['username'];?></a>
                        <?php
                        if($lik['verified'] == 1){
                            ?>
                            <img src="images/verified.png" width="12px" alt="">
                            <?php
                        }else{}
                        ?></b>
                      &nbsp;
                        <?= $cline['comment'];?></p<br>
                    </div>
                    <?php
                    } }
                    ?>
                </div></div>
            <div class="com">
                <div class="likes">
                <?php
              $status_query = "SELECT count(*) as cntStatus,type FROM likes WHERE users_id=".$users_id." and post_id=".$postid;
              $status_result = mysqli_query($conn,$status_query);
              $status_row = mysqli_fetch_array($status_result);
              $count_status = $status_row['cntStatus'];
              if($count_status > 0){
                  $type = $status_row['type'];
              }

              $like_query = "SELECT COUNT(*) AS cntLikes FROM likes WHERE type=1 and post_id=".$postid;
              $like_result = mysqli_query($conn,$like_query);
              $like_row = mysqli_fetch_array($like_result);
              $total_likes = $like_row['cntLikes'];

              $unlike_query = "SELECT COUNT(*) AS cntUnlikes FROM likes WHERE type=0 and post_id=".$postid;
              $unlike_result = mysqli_query($conn,$unlike_query);
              $unlike_row = mysqli_fetch_array($unlike_result);
              $total_unlikes = $unlike_row['cntUnlikes'];
              $bar_width = 80;
              $type = -1;
              $denominator = $total_likes + $total_unlikes;
              if($denominator == 0){
                
              }else{
              $percent_likes = round(($total_likes / $denominator) * 100);
              $percent_unlikes = round(($total_unlikes / $denominator) * 100);
              
              $red_width = $percent_likes * $bar_width / 100;
              $blue_width = $percent_unlikes * $bar_width / 100;
              }
              ?>
            <button id="like_<?php echo $postid; ?>" class="like" style="<?php if($type == 1){ echo "background-color: #ffa449;"; } ?>"><img src="images/like.png" width="28px" alt=""></button><span id="likes_<?php echo $postid; ?>"><?php echo $total_likes; ?></span> 
                            <div class="bar" style="width:<?php echo $bar_width; ?>px; height:10px; background-color:gray; display:inline-block; position:relative;">
                                <span class="like-bar-like" style="position:absolute; top:0; left:0; bottom:0; width:<?php echo $red_width; ?>px; background-color:rgba(187, 14, 14, 0.658);"></span>
                                <span class="like-bar-unlike" style="position:absolute; top:0; right:0; bottom:0; width:<?php echo $blue_width; ?>px; background-color:rgba(145, 16, 156, 0.432);"></span>
                            </div>
                            <span id="unlikes_<?php echo $postid; ?>"><?php echo $total_unlikes; ?></span>
                            <button id="unlike_<?php echo $postid; ?>" class="unlike" style="<?php if($type == 0){ echo "color: #ffa449;"; } ?>"><img src="images/heartx.png" width="28px" alt=""></button>
                            
            </div>       
            </div>
                <div class="comment">
                  <button id="emoji-button">😀</button>
                  <input type="hidden" name="post_id" value="<?php echo $line['post_id'] ?>">
                  <input type="text" autocomplete="off" placeholder="Add a comment..." name="comment">
                  <input type="hidden" name="<?php echo $line['post_id'] ?>" value="<?php echo $line['post_id'] ?>">
                  <button name="postc">post</button>
              </div>
                </div>
            </div>
        </div>
        
        
    </div>
    </form>
<?php  
} 
// //ORDER BY post_id DESC  
// $sql = "SELECT * FROM posts where users_id != '$users_id' ORDER BY post_id DESC";
// $sql2 = "SELECT * FROM follower where users_id = '$users_id'";
?>
<main>
<?php

$sql = "SELECT p.*
FROM posts p
INNER JOIN followers f ON p.users_id = f.user2_id
WHERE f.users_id = '$users_id' ORDER BY rand()";
$result = mysqli_query($conn, $sql);
while($rows=mysqli_fetch_array($result)){
  $poster_id = $rows['users_id'];
  $postid = $rows['post_id'];
  ?>
<div class="post">
    <?php
    $querys = "SELECT * FROM users WHERE users_id = '$poster_id'";
        $results = mysqli_query($conn, $querys);
        while($row=mysqli_fetch_array($results)){
          ?>
            <a href="user.php?p=<?= $row['username'];?>"><div class="poster">
                <img class="img" src="profile/<?= $row['pic'];?>" alt="">&nbsp;&nbsp;
                <label for=""><?= $row['username'];?>
                <?php
            if($row['verified'] == 1){
                ?>
                <img src="images/verified.png" width="12px" alt="">
                <?php
            }else{}
            ?>
              </label>&nbsp;.&nbsp;
              <?php
                            $data_added_time = $rows['date'];
                            $current_time = time();
                            $data_added_timestamp = strtotime($data_added_time);
                            $time_diff = $current_time - $data_added_timestamp;
                            
                            if ($time_diff < 60) {
                              echo "Just now";

                            } elseif ($time_diff < 3600) {

                              $minutes = floor($time_diff / 60);
                              echo $minutes . " m";

                            } elseif ($time_diff < 86400) {

                              $hours = floor($time_diff / 3600);
                              echo $hours . " h";

                            } elseif($time_diff > 86399 && $time_diff < 172800) {
                              // $day = floor($time_diff / 86400);
                              echo "1 day ago";
                            } else {
                              $days = floor($time_diff / 172800);
                              echo $days . " days ago";
                            }
                          ?>
            </div></a>
            <?php
        } ?>
        <form action="" method="post">
        <input type="hidden" name="post_id" value="<?php echo $rows['post_id'] ?>">
        </form>
            <div class="imgs">
                <img src="uploads/<?= $rows['photo'];?>" loading="lazy" alt="">
            </div>
            
            <div class="likes">
              <?php
              $status_query = "SELECT count(*) as cntStatus,type FROM likes WHERE users_id=".$users_id." and post_id=".$postid;
              $status_result = mysqli_query($conn,$status_query);
              $status_row = mysqli_fetch_array($status_result);
              $count_status = $status_row['cntStatus'];
              if($count_status > 0){
                  $type = $status_row['type'];
              }

              $like_query = "SELECT COUNT(*) AS cntLikes FROM likes WHERE type=1 and post_id=".$postid;
              $like_result = mysqli_query($conn,$like_query);
              $like_row = mysqli_fetch_array($like_result);
              $total_likes = $like_row['cntLikes'];

              $unlike_query = "SELECT COUNT(*) AS cntUnlikes FROM likes WHERE type=0 and post_id=".$postid;
              $unlike_result = mysqli_query($conn,$unlike_query);
              $unlike_row = mysqli_fetch_array($unlike_result);
              $total_unlikes = $unlike_row['cntUnlikes'];
              $bar_width = 80;
              $type = -1;
              $denominator = $total_likes + $total_unlikes;
              if($denominator == 0){
                
              }else{
              $percent_likes = round(($total_likes / $denominator) * 100);
              $percent_unlikes = round(($total_unlikes / $denominator) * 100);
              
              $red_width = $percent_likes * $bar_width / 100;
              $blue_width = $percent_unlikes * $bar_width / 100;
              }
              ?>
            <button id="like_<?php echo $postid; ?>" class="like" style="<?php if($type == 1){ echo "background-color: #ffa449;"; } ?>"><img src="images/like.png" width="28px" alt=""></button><span id="likes_<?php echo $postid; ?>"><?php echo $total_likes; ?></span> 
                            <div class="bar" style="width:<?php echo $bar_width; ?>px; height:10px; background-color:gray; display:inline-block; position:relative;">
                                <span class="like-bar-like" style="position:absolute; top:0; left:0; bottom:0; width:<?php echo $red_width; ?>px; background-color:rgba(187, 14, 14, 0.658);"></span>
                                <span class="like-bar-unlike" style="position:absolute; top:0; right:0; bottom:0; width:<?php echo $blue_width; ?>px; background-color:rgba(145, 16, 156, 0.432);"></span>
                            </div>
                            <span id="unlikes_<?php echo $postid; ?>"><?php echo $total_unlikes; ?></span>
                            <button id="unlike_<?php echo $postid; ?>" class="unlike" style="<?php if($type == 0){ echo "color: #ffa449;"; } ?>"><img src="images/heartx.png" width="28px" alt=""></button>
                            
            </div>
            <div class="quotes">
              <?php
            $queryss = "SELECT * FROM users WHERE users_id = '$poster_id'";
        $resultss = mysqli_query($conn, $queryss);
        while($rowtt=mysqli_fetch_array($resultss)){
          ?>
                <p><b><?= $rowtt['username']; }?></b>&nbsp;<?= $rows['caption'];?></p>
            </div>
            <div class="comments"><form action="" method="post">
            <?php
            $csql = "SELECT * FROM comment WHERE post_id = '$postid'";
            $resultc = mysqli_query($conn, $csql);
            $comment_count  = mysqli_num_rows($resultc);
            if (mysqli_num_rows($resultc) > 1){
             ?>
             
            <input type="hidden" name="post_id" value="<?php echo $rows['post_id'] ?>">
        
               <button type="submit" class="cm" name="view"><h4>View all <span class="comment-count"><?php echo $comment_count; ?></span> comments</h4></button>
           <?php 
           }
           elseif (mysqli_num_rows($resultc) == 1){
             ?>
               <button type="submit" class="cm" name="view"><h4>view <span class="comment-count"><?php echo $comment_count; ?></span> comment</h4></button>
               
           <?php 
           }else{
            echo '<small>No comments yet</small>';
           } 
           ?></form>




              <div class="comment">
              <form class="comment-form">
              <input type="hidden" name="post_id" value="<?php echo $rows['post_id'] ?>">
              <input type="text" autocomplete="off" placeholder="Add a comment..." name="comment" class="comments">
              <input type="hidden" name="<?php echo $rows['post_id'] ?>" value="<?php echo $rows['post_id'] ?>">
              <button id="postc" type="submit" name="postc">post</button>
            </form>
              </div>

            </div> 
</div>
<?php
} 
$sql4 = "SELECT p.*
FROM posts p
INNER JOIN followers f ON p.users_id = f.user2_id
WHERE f.users_id = '$users_id' ORDER BY rand()";
$result5 = mysqli_query($conn, $sql4);
if(mysqli_num_rows($result5) < 1){
  echo "Add to your feed by following people!";
  ?>
  <div class="polo">
  <br> <h3>Suggession</h3> <br>
  <?php
        $sqltt = "SELECT * FROM users WHERE users_id != '$users_id' ORDER BY rand() LIMIT 3";
        $resulttt = mysqli_query($conn, $sqltt);
        while ($row=mysqli_fetch_assoc($resulttt)) {
        ?>
        <a href="user.php?p=<?= $row['username'];?>">
        <div class='mini'>
            <img src="profile/<?= $row['pic']?>" alt='<?=$row['username']?>'>
            <div class="miniT">
            <label for="">
            <?=$row['username']?>
            <?php
            if($row['verified'] == 1){
                ?>
                &nbsp;<img src="images/verified.png" width="14px" alt="">
                <?php
            }else{}
            ?></label>
            <?=$row['name']?>
            </div>
        </div>
        </a>
        <?php
} 
?>
</div>
<?php
}
?>

</main>

    <aside>
        <h3>Suggession</h3>
        <div class="follow">
          <h3>Follow</h3>
        <?php
        $sqltt = "SELECT * FROM users WHERE users_id != '$users_id' ORDER BY rand() LIMIT 3";
        $resulttt = mysqli_query($conn, $sqltt);
        while ($row=mysqli_fetch_assoc($resulttt)) {
        ?>
        <a href="user.php?p=<?= $row['username'];?>">
        <div class='mini'>
            <img src="profile/<?= $row['pic']?>" alt='<?=$row['username']?>'>
            <div class="miniT">
            <label for="">
            <?=$row['username']?>
            <?php
            if($row['verified'] == 1){
                ?>
                &nbsp;<img src="images/verified.png" width="14px" alt="">
                <?php
            }else{}
            ?></label>
            <?=$row['name']?>
            </div>
        </div>
        </a>
        <?php
        }
        ?>
          
    </aside><div class="theme">
        <input type="radio" id="lightModeToggle" name="themeToggle" value="light-mode" checked>
        <label for="lightModeToggle">Dark mode</label><br>
        <input type="radio" id="darkModeToggle" name="themeToggle" value="dark-mode">
        <label for="darkModeToggle">Light mode</label>
              </div>
              </div>
 <script type='text/javascript'>
$(document).ready(function(){
    $(".like, .unlike").click(function(){
        var id = this.id;
        var split_id = id.split("_");
        var text = split_id[0];
        var postid = split_id[1];
        var type = 0;
        if(text == "like"){
            type = 1;
        }else{
            type = 0;
        }
        $.ajax({
            url: 'like2.php?' + new Date().getTime(), // add a random parameter to the URL
    type: 'post',
    data: {postid:postid,type:type},
    dataType: 'json',
    success: function(data){
    var likes = data['likes'];
    var unlikes = data['unlikes'];
    $("#likes_"+postid).text(likes);
    $("#unlikes_"+postid).text(unlikes);
    if(type == 1){
        $("#like_"+postid).css("color","#ffa449");
        $("#unlike_"+postid).css("color","lightseagreen");
    }
    if(type == 0){
        $("#unlike_"+postid).css("color","#ffa449");
        $("#like_"+postid).css("color","lightseagreen");
    }
    updateLikeBar(postid, likes, unlikes);
}
        });
    });
});


$(document).ready(function() {
    $('#search-input').on('keyup', function() {
        var searchValue = $(this).val();
        if(searchValue != '') {
            $.ajax({
                type: 'POST',
                url: 'search.php', // replace with the name of your PHP file
                data: $('#search-form').serialize(),
                success: function(response) {
                    $('#output').html(response);
                }
            });
        }
        else {
            $('#output').html('');
        }
    });
});



function submitForm(event) {
  //event.preventDefault();
  console.log('submitForm called');
  var form = $('.commentz');
  var commentInput = $('.commentInput');
  $.ajax({
    type: form.attr('method'),
    url: form.attr('action'),
    data: { post_id: "", user_id: user_id },
    success: function(response) {
      console.log(response);
      var obj = JSON.parse(response);
      $('#comment-count').text(obj.comment_count);
      commentInput.val('');
    }
  });
}

document.addEventListener('DOMContentLoaded', function() {
const commentForms = document.querySelectorAll('.comment-form');
var comments = $('.comments');
// Iterate through each form and attach event listener
commentForms.forEach(function(form) {
  form.addEventListener('submit', function(event) {
    // Prevent default form submission behavior
    event.preventDefault();

    // Get form data
    const formData = new FormData(event.target);

    // Create fetch request to submit form data
    fetch('comment.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.text())
    .then(data => {
      // Update page content with new comment data
      const newComment = data;
      comments.val('');
      $('.comment-count').text(data.count);
      form.previousElementSibling.insertAdjacentHTML('beforeend', newComment);
    })
    .catch(error => console.error(error));
  });
});
});

</script>
</body>
</html>