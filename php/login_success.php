<?php
// After click login button 

session_start();
// Submit button name below
if (isset($_POST['loginButton'])) {
    // Connect to database 
    include_once 'dbcon.php';

    // Get all the posted items
    $userUname = $_POST['userUname'];
    $userPassw = $_POST['userPassw'];

    // Construct and run query to check for correct credentials
    $query = "SELECT * FROM user WHERE userUname='$userUname' AND userPassw='$userPassw'";
    $res = mysqli_query($con, $query);
    $rows = mysqli_num_rows($res);

    // If result matched $username and $password, table row must be 1 row
    if ($rows == 1) {
        $r = mysqli_fetch_assoc($res);
        $_SESSION['userID'] = $r['userID'];
        $_SESSION['userLevel'] = $r['userLevel'];

        // Check if user is admin - send to admin page
        if ($r['userLevel'] == 1)
            header("Location: admin.php");
        // Check if user is tutor - send to tutor page
        else if ($r['userLevel'] == 2)
            header("Location: tutor.php");
        // Check if user is student - send to student page
        else if ($r['userLevel'] == 3)
            header("Location: student.php");
        // Check for wrong password
        else {
            header("Location:login.php?msg=failed");
        }
    } else {
        header("Location:login.php?msg=failed");
    }
    // Clear results and close the connection
    mysqli_free_result($res);
    mysqli_close($con);
} else
    header("Location: login.php");
