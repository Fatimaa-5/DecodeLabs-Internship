<?php
file_put_contents('debug.txt', date('H:i:s') . " | Error Code: " . $_FILES['image']['error'] . " | Tmp: " . $_FILES['image']['tmp_name'] . "\n", FILE_APPEND);
include 'db.php';
if($_POST){
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $genres = mysqli_real_escape_string($conn, $_POST['genres']);
    $ep = $_POST['episodes_watched'];
    $total = $_POST['total_episodes'];
    $rating = $_POST['rating'];
    $img = mysqli_real_escape_string($conn, $_POST['image_url']);
    $status = $_POST['status'];
    
    // YEH WALA HISSA MISSING THA TUMHARE CODE ME
    if(isset($_FILES['image']) && $_FILES['image']['error']==0 && $_FILES['image']['name']!= ''){
        if(!is_dir('uploads')) mkdir('uploads', 0777, true);
        $target = "uploads/".time()."_".basename($_FILES['image']['name']);


       if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
    $img = $target;
    error_log("SUCCESS: File uploaded to $target"); // YE ADD KARO
} else {
    error_log("FAILED: Error code " . $_FILES['image']['error']); // YE BHI
}
    }
    
    mysqli_query($conn, "INSERT INTO anime (title,genres,episodes_watched,total_episodes,rating,image_url,status) 
    VALUES ('$title','$genres','$ep','$total','$rating','$img','$status')");
    
    mysqli_query($conn, "INSERT INTO notifications (message) VALUES ('New anime added: $title')");
    header("Location: index.php?page=watchlist");
}
?>