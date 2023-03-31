<?php
include 'config.php';
$users_id = $_SESSION['id'] ?? 0;

function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
$search = validate($_POST['search']);

$sql = "SELECT * FROM users WHERE name OR username LIKE '%$search%'";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result)>0){
while ($row=mysqli_fetch_assoc($result)) {
?>
<a href="user.php?p=<?= $row['username'];?>">
<div class='mini'>
    <img src="profile/<?= $row['pic']?>" alt='<?=$row['username']?>'>
    <div class="miniT">
    <label><?=$row['username']?>
    <?php
            if($row['verified'] == 1){
                ?>
                &nbsp;<img src="images/verified.png" width="14px" alt="">
                <?php
            }else{}
            ?></label>
    <?php
    if ($row['users_id'] == $users_id){
        echo 'You';
    }else{
    ?>
    <?=$row['name']?>
    <?php
    }
    ?>
    </div>
</div>
</a>
<?php
}
}
else{
echo "No data found";
}


?>