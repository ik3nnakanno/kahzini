<?php
$conn = mysqli_connect('localhost', 'test', '', 'khazini');

if(!$conn){
    echo "connection failed";
}