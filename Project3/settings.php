<?php
include 'db.php';
session_start();

$username = mysqli_real_escape_string($conn, $_POST['username']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$theme = mysqli_real_escape_string($conn, $_POST['theme']);
$profile_pic = $_POST['old_pic'];

// Profile pic upload
if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['name']!= '' && $_FILES['profile_pic']['error']==0){
    if(!is_dir('uploads')) mkdir('uploads', 0777, true); // YE LINE ADD KI
    
    $ext = pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
    $filename = "uploads/profile_".time().".".$ext;

    if(move_uploaded_file($_FILES['profile_pic']['tmp_name'], $filename)){
        // Delete old pic if exists
        if($profile_pic!= '' && file_exists($profile_pic)) unlink($profile_pic);
        $profile_pic = $filename;
    }
}

$sql = "UPDATE settings SET username='$username', email='$email', theme='$theme', profile_pic='$profile_pic' WHERE id=1";
mysqli_query($conn, $sql);

header('Location: index.php?page=settings&saved=1');
exit();
?>