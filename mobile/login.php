<?php
// Inialize session
session_start();

// Include database connection settings
include_once 'dbcon.php';

// capture values from HTML form
$userUname = $_POST['userUname'];
$userPassw = $_POST['userPassw'];

$q = "SELECT * FROM user WHERE userUname= '$userUname' AND userPassw= '$userPassw'";
$query = mysqli_query($con, $q);
$rows = mysqli_num_rows($query);

if ($rows == 0) {
    // Jump to index wrong page
    echo "No data received";
} 
else {
    $r = mysqli_fetch_assoc($query);
    
    $userUname = $r['userUname'];
    $userLevel = $r['userLevel'];
    echo $userLevel;
}

mysqli_close($con);
?>

