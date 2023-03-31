<?php
include 'config.php';
session_start();
$users_id = $_SESSION['id'] ?? 0;
include 'header.php';
?>
    <main>
        <?php
        if(isset($_POST['see'])){
            $postid = $_POST['post_id'];
            $view = mysqli_query($conn, "SELECT * FROM posts where post_id = '$postid'");
            $line=mysqli_fetch_array($view);
            $posters_id = $line['users_id'];

            $vql = mysqli_query($conn,"SELECT * FROM users WHERE users_id = '$posters_id'");
            $vline=mysqli_fetch_array($vql);
            ?>
            <div class="pop" id="Popup">
                    <div class="headd">
                        <img src="profile/<?= $vline['pic'];?>" width="70px" height="70px" class="cf" alt="">
                        <label><b><?= $vline['username'];?></b>
                        <?php
                        if($vline['verified'] == 1){
                            ?>
                            <img src="images/verified.png" width="12px" alt="">
                            <?php
                        }else{}
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
                        
                            
                        </label>
                    </div>
                    <div class="container">
                        <div class="pile">
                            <img src="uploads/<?= $line['photo'];?>"  class="pp" alt="">
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
                            <p><?= $line['caption'];?></p>
                            <?php
                            $comm = "SELECT * FROM comment where post_id = '$postid'";
                            $clines=mysqli_query($conn, $comm);
                            while($cline=mysqli_fetch_array($clines)){
                            $liker_id = $cline['users_id'];
                            $likers= "SELECT * FROM users WHERE users_id = '$liker_id'";
                            $likerr = mysqli_query($conn, $likers);
                            while($lik=mysqli_fetch_array($likerr)){
                                ?>
                            <div class="tcom">
                            <a href="user.php?p=<?= $lik['username'];?>">
                                <img src="profile/<?= $lik['pic'];?>" class="comimg" width="50px" height="50px" alt=""></a> &nbsp;
                                <label><b><a href="user.php?p=<?= $lik['username'];?>"><?=$lik['username'];?></a>
                            
                                <?php
                                        if($lik['verified'] == 1){
                                        ?>
                                        <img src="images/verified.png" width="12px" alt="">
                                        <?php
                                    }else{}
                        ?>&nbsp;
                            </b>
                                <?= $cline['comment'];?>
                                </label>
                            </div>

                            <?php  } }
                            if(mysqli_num_rows($clines)<1){
                                echo "<label>No comment yet</label>";
                            }
                            ?>
                        </div>
                        <div class="comment commentsss">
                            <button id="emoji-button">😀</button>
                            <input type="hidden" name="post_id" value="<?php echo $line['post_id'] ?>">
                            <input type="text" autocomplete="off" placeholder="Add a comment..." name="comment">
                            <input type="hidden" name="<?php echo $line['post_id'] ?>"
                                value="<?php echo $line['post_id'] ?>">
                            <button name="postc">post</button>
                        </div>
                    </div></div>
                  
                
                <?php

        }
        function validate($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
          }
        $get_id = validate($_GET['p']);
        $query = "SELECT * FROM users WHERE username = '$get_id'";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) < 1){
            header('location: kahzini.php');
        }
        while($row=mysqli_fetch_array($result)){
        $user_id = $row['users_id'];
        if ($row['users_id'] == $users_id) {
            header('location: profile.php');
        }else{}
        ?>
        <form action="" method="post">
        <div class="profile">
            <h3 align="center"><i> @<?= $row['username'];?></i>
            <?php
            if($row['verified'] == 1){
                ?>
                &nbsp;<img src="images/verified.png" width="14px" alt="">
                <?php
            }else{}
            ?></h3>
            <br>
            <div class="top">
                <img src="profile/<?= $row['pic'];?>" alt="">
                <label for="">
                <?php 
                if(isset($_POST['follow'])){
                    
                $follow = mysqli_query($conn,"INSERT INTO followers (users_id, user2_id) VALUES ($users_id, $user_id)");
                }
                if(isset($_POST['unfollow'])){
                    
                    $follow = mysqli_query($conn,"DELETE FROM followers where users_id = '$users_id' AND user2_id = $user_id");
                    }
                $fol = mysqli_query($conn,"SELECT * FROM followers where users_id = '$users_id' AND user2_id = $user_id");
                if(mysqli_num_rows($fol) > 0){
                    echo '<button name="unfollow">Unfollow</button>';
                }else{
                    echo '<button name="follow">Follow</button>';
                }
                ?>
                </label>
                <a href="message.php"><label for="">Message</label></a>
            </div>
            <div class="details">
                <label for="">Followers
                <?php
                $foll = mysqli_query($conn,"SELECT * FROM followers where user2_id = '$user_id'");
                $followers= mysqli_num_rows($foll);
                
                
                echo number_format($followers); ?>&nbsp;&nbsp;&nbsp;&nbsp;Following
                <?php
                    $folls = mysqli_query($conn,"SELECT * FROM followers where users_id = '$user_id'");
                    $following= mysqli_num_rows($folls);
                
                 echo number_format($following); ?></label><br>
                <label for=""><img src="images/user.png" width="24px" alt="">&nbsp;&nbsp;<?= $row['name'];?></label><br>
                <label for=""><img src="images/book.png" width="24px" alt="">&nbsp;&nbsp;<?= $row['education'];?></label><br>
                <label for=""><img src="images/map.png" width="24px" alt="">&nbsp;&nbsp;<?= $row['state'];?>, <?= $row['country'];?></label><br>
                <h4>bio</h4><p>
                <?= $row['bio'];?>
                </p><br><br>
            </div></form>
        <?php
    }
        ?>
            <h4>Posts</h4>
            <div class="pposts">
                <div class="tinyp">
                    <?php
                    
                    $sql = "SELECT * FROM posts WHERE users_id = '$user_id' ORDER BY post_id DESC";
                    $result = mysqli_query($conn, $sql);
                    while($row=mysqli_fetch_array($result)){
                        $post_ids = $row['post_id']
                        ?>
                        <form action="" method="post">
                        <button name="see">
                        <div class="engage">
                        <div class="imgg">
                            <img src="uploads/<?= $row['photo'];?>">
                        </div>
                        <div class="total">
                            <?php
                            $sql2 = mysqli_query($conn, "SELECT * FROM likes WHERE post_id = '$post_ids'");
                            $likes = mysqli_num_rows($sql2);
                            $csql = "SELECT * FROM comment WHERE post_id = '$post_ids'";
                            $resultc = mysqli_query($conn, $csql);
                            $comments = mysqli_num_rows($resultc);
                            ?>
                            <input type="hidden" name="post_id" value="<?php echo $row['post_id'] ?>">
                            <img src="images/likew.png" width="18px" alt=""> <?= $likes ?> &nbsp;&nbsp;
                            <img src="images/chatw.png" width="18px" alt=""><?= $comments ?>
                        </div>
                    </div></button></form>
                    

                    <?php
                    }

                    
?>                  
                </div>
            </div>
        </div>
        <?php
        $sqls = mysqli_query($conn, "SELECT * FROM posts WHERE users_id = '$user_id'");
                    if(mysqli_num_rows($sqls) < 1){
                        ?>
                        <div class="emp">
                        <label>No Post Yet</label></div>
                   <?php }else{
                   } 
                   
                   ?>
                   <div class="theme">
<input type="radio" id="lightModeToggle" name="themeToggle" value="light-mode" checked>
<label for="lightModeToggle">Dark mode</label><br>
<input type="radio" id="darkModeToggle" name="themeToggle" value="dark-mode">
<label for="darkModeToggle">Light mode</label><br>
<a href="logout.php">Logout</a>
                </div>
</main>
<script>
      
      const popup = document.getElementById("Popup");

      // Close the pop-up when the user clicks outside of it
      window.addEventListener("click", function (event) {
          if (event.target !== popup && !popup.contains(event.target)) {
              popup.style.display = "none";
          }
      });

  </script>