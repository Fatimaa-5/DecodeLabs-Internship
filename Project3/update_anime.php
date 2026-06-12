<?php
include 'db.php';
if($_POST){
    $id = $_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $genres = mysqli_real_escape_string($conn, $_POST['genres']);
    $ep = $_POST['episodes_watched'];
    $total = $_POST['total_episodes'];
    $rating = $_POST['rating'];
    $img = mysqli_real_escape_string($conn, $_POST['image_url']);
    $status = $_POST['status'];
    
    mysqli_query($conn, "UPDATE anime SET title='$title',genres='$genres',episodes_watched='$ep',total_episodes='$total',rating='$rating',image_url='$img',status='$status' WHERE id=$id");
    header("Location: index.php?page=watchlist");
}
?>