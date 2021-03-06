<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="../css/style2.css">
    <!-- Title -->
    <title>Class Details</title>
    <link rel="icon" href="../images/icon.ico" />
</head>

<body>
    <?php
    // Student
    session_start();
    if (isset($_SESSION['userID']) && $_SESSION['userLevel'] == 3)
        // Connect to database 
        include_once 'dbcon.php';
    else
        header("Location: login.php");
    ?>
    <!--Navigation -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="student.php">
                        <span class="icon">
                            <img src="../images/logocircle.png" alt="Logo Let Us Score!" id="logoLUS" />
                        </span>
                        <!-- <span class="title">Let Us Score</span> -->
                    </a>
                </li>
                <li>
                    <a href="student.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="edit_details.php">
                        <span class="icon">
                            <ion-icon name="options-outline"></ion-icon>
                        </span>
                        <span class="title">Update Details</span>
                    </a>
                </li>
                <li>
                    <?php
                    // Data

                    // Construct and run query to check for existing subject registration
                    $q = "SELECT * FROM user u, register r WHERE u.userID=r.stuID AND userID=?";
                    // Created a prepared statement
                    $stmt = mysqli_stmt_init($con);
                    // Prepare the prepared statement
                    if (!mysqli_stmt_prepare($stmt, $q))
                        echo "SQL statement failed";
                    else {
                        // Bind parameters to the placeholder
                        mysqli_stmt_bind_param($stmt, "i", $_SESSION['userID']);
                        // Run parameters inside database
                        mysqli_stmt_execute($stmt);
                        $res = mysqli_stmt_get_result($stmt);
                        $r = mysqli_fetch_assoc($res);
                        $num = mysqli_num_rows($res);
                    }
                    if ($res) {
                        if ($num <= 0) {
                            // Will display subject registration option if student does not register yet
                    ?>
                            <a href=register_subject.php>
                                <span class="icon">
                                    <ion-icon name="person-add-outline"></ion-icon>
                                </span>
                                <span class="title">Register Subject(s)</span>
                            </a>
                    <?php
                            //mysqli_free_result($res);
                        }
                    }
                    ?>
                </li>
                <li>
                    <a href="view_class_student.php">
                        <span class="icon">
                            <ion-icon name="document-text-outline"></ion-icon>
                        </span>
                        <span class="title">Class Details</span>
                    </a>
                </li>
                <li>
                    <a href=feedback.php>
                        <span class="icon">
                            <ion-icon name="help-outline"></ion-icon>
                        </span>
                        <span class="title">Feedback</span>
                    </a>
                </li>
                &nbsp;
                <li>
                    <a href=logout.php>
                        <span class="icon" style="color:#ed2146;">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title" style="color:#ed2146;">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Main -->
        <div class="main">
            <div class="topbar">
                <!-- Options menu toggle -->
                <div class="toggle">
                    <script src="https://cdn.lordicon.com/xdjxvujz.js"></script>
                    <lord-icon src="https://cdn.lordicon.com/xhebrhsj.json" trigger="loop-on-hover" colors="primary:#121331" state="hover" style="width:45px;height:45px">
                    </lord-icon>
                </div>

                <!-- Time update (every 1s) on top -->
                <span>
                    <div style="position: absolute; right: 500px; top: 5px;">
                        <script src="https://cdn.lordicon.com/xdjxvujz.js"></script>
                        <lord-icon src="https://cdn.lordicon.com/drtetngs.json" trigger="loop-on-hover" colors="primary:#192e59" style="width:50px;height:50px">
                        </lord-icon>
                    </div>
                    <script>
                        setInterval(function() {
                            document.getElementById('current-time').innerHTML = new Date().toString();
                        }, 1);
                    </script>
                    <div style='font-family: "Helvetica", sans-serif; font-size: 20px; font-weight: 500;' id='current-time'></div>
                </span>

                <!-- 
                <div class="search">
                    <label>
                        <input type="text" placeholder="Search here" />
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>
                
                <div class="user">
                    <img src="../images/icons/user-solid.svg" alt="" />
                </div>
                -->
            </div>
            <!-- ================ Order Details List ================= -->
            <div class="details" style="display: inline-block;">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>
                            <?php
                            $q = "SELECT userName FROM user WHERE userID=" . $_SESSION['userID'];
                            $res = mysqli_query($con, $q);
                            $r = mysqli_fetch_assoc($res);
                            echo $r['userName'];

                            if ($num > 0)
                                echo "'s Classes";
                            else
                                echo "'s Class";
                            ?>
                        </h2>
                    </div>

                    <?php
                    // Construct and run query to check for existing class
                    $q =        " SELECT c.classID, c.classSubject, c.classTime, c.classLink, c.classDay, c.totalStudent, tutor.userName, tutor.userEmail, tutor.userPhone
                                FROM user u, user tutor, class c, register r
                                WHERE u.userID = " . $_SESSION['userID'] . " AND u.userID=r.stuID AND tutor.userID=c.tutorID AND tutor.userLevel='2' AND u.userLevel='3' AND c.classID=r.classID AND r.registerApproval='1'";
                    $res = mysqli_query($con, $q);
                    $num = mysqli_num_rows($res);
                    if ($res) {
                        if ($num > 0) {
                    ?>
                            <table style="width: 100%;">
                                <thead>
                                    <tr>
                                        <td>Subject</td>
                                        <td>Day</td>
                                        <td>Time</td>
                                        <td>Link</td>
                                        <td>Total Student(s)</td>
                                        <td>Tutor's Name</td>
                                        <td>Tutor's Email</td>
                                        <td>Tutor's Phone</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php
                                        // Construct and run query to list user's classes
                                        while ($r = mysqli_fetch_assoc($res)) {
                                        ?>
                                    <tr>
                                        <td> <?php echo $r["classSubject"] ?></td>
                                        <td> <?php echo $r["classDay"] ?></td>
                                        <td>
                                            <?php
                                            // Class Time Checker
                                            if ($r["classTime"] == "08:00:00")
                                                $time = "8.00 a.m. - 9.00 a.m.";
                                            else if ($r["classTime"] == "09:00:00")
                                                $time = "9.00 a.m. - 10.00 a.m.";
                                            else if ($r["classTime"] == "13:00:00")
                                                $time = "1.00 p.m. - 2.00 p.m.";
                                            else if ($r["classTime"] == "14:00:00")
                                                $time = "2.00 p.m. - 3.00 p.m.";
                                            else if ($r["classTime"] == "15:00:00")
                                                $time = "3.00 p.m. - 4.00 p.m.";
                                            echo $time
                                            ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo $r["classLink"]; ?>" target='_blank' class="b">
                                                <?php echo $r["classLink"] ?>
                                            </a>
                                        </td>
                                        <td> <?php echo $r["totalStudent"] ?></td>
                                        <td> <?php echo $r["userName"] ?></td>
                                        <td> <?php echo $r["userEmail"] ?></td>
                                        <td> <?php echo $r["userPhone"] ?></td>
                                    </tr>
                                    </tr>
                                <?php
                                        }
                                ?>
                                </tr>
                                </tbody>
                            </table>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- JS scripts -->
    <script src="../js/dash.js"></script>
    <script src="../js/script.js"></script>
    <!-- ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <?php
    // Clear results and close the connection
    //mysqli_free_result($res);
    mysqli_close($con);
    ?>
</body>

</html>