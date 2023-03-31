<?php
include "config.php";
$userid = 55;
$postid = $_POST['postid'];
$type = $_POST['type'];
 
$query = "SELECT COUNT(*) AS cntpost FROM likes WHERE post_id=".$postid." and users_id=".$userid;
 
$result = mysqli_query($conn,$query);
$fetchdata = mysqli_fetch_array($result);
$count = $fetchdata['cntpost'];
 
if($count == 0){
    $insertquery = "INSERT INTO likes(users_id,post_id,type) values(".$userid.",".$postid.",".$type.")";
    mysqli_query($conn,$insertquery);
}else {
    $updatequery = "UPDATE likes SET type=" . $type . " where users_id=" . $userid . " and post_id=" . $postid;
    mysqli_query($conn,$updatequery);
}
 
$query = "SELECT COUNT(*) AS cntLike FROM likes WHERE type=1 and post_id=".$postid;
$result = mysqli_query($conn,$query);
$fetchlikes = mysqli_fetch_array($result);
$totalLikes = $fetchlikes['cntLike'];
 
$query = "SELECT COUNT(*) AS cntUnlike FROM likes WHERE type=0 and post_id=".$postid;
$result = mysqli_query($conn,$query);
$fetchunlikes = mysqli_fetch_array($result);
$totalUnlikes = $fetchunlikes['cntUnlike'];
 
$return_arr = array("likes"=>$totalLikes,"unlikes"=>$totalUnlikes);
 
echo json_encode($return_arr);
?>