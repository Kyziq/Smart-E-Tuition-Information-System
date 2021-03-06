<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="../css/style2.css">
    <!-- Title -->
    <link rel="icon" href="../images/icon.ico" />
    <title>User Details</title>
</head>

<body>
    <?php
    session_start();
    // Connect to database 
    include_once 'dbcon.php';
    ?>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <?php
        // Student's
        if (isset($_SESSION['userID']) && $_SESSION['userLevel'] == 3) { ?>
            <!-- Student navigation -->
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
            </div>
        <?php
        } else if (isset($_SESSION['userID']) && $_SESSION['userLevel'] == 2) { ?>
            <div class="container">
                <!-- Tutor navigation -->
                <div class="navigation">
                    <ul>
                        <li>
                            <a href="tutor.php">
                                <span class="icon">
                                    <img src="../images/logocircle.png" alt="Logo Let Us Score!" id="logoLUS" />
                                </span>
                                <!-- <span class="title">Let Us Score</span> -->
                            </a>
                        </li>
                        <li>
                            <a href="tutor.php">
                                <span class="icon">
                                    <ion-icon name="home-outline"></ion-icon>
                                </span>
                                <span class="title">Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="edit_details.php">
                                <span class="icon">
                                    <ion-icon name="document-text-outline"></ion-icon>
                                </span>
                                <span class="title">My Details</span>
                            </a>
                        </li>

                        <li>
                            <a href="view_class_tutor.php">
                                <span class="icon">
                                    <ion-icon name="document-text-outline"></ion-icon>
                                </span>
                                <span class="title">Student Details</span>
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
            </div>
        <?php
        }
        ?>
        <!-- Main -->
        <div class="main">
            <div class="topbar">
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
            </div>
            <div class="details" style="display: inline-block;">
                <div class="recentOrders">
                    <?php
                    // Data

                    // Construct and run query to check for user details
                    $q = "SELECT * FROM user WHERE userID=?";
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
                    }
                    ?>
                    <div class="cardHeader">
                        <h2>
                            My Details:</h2>
                    </div>
                    <form method='POST' action='edit_details_save.php'>
                        <table style="width: 100%; height: 100%;">
                            <thead>
                                <tr>
                                    <td style="text-align: left; width: 200px; height:60px;">ID</td>
                                    <?php
                                    echo "<td style='text-align: left;'><input type='text' name='userID' style='text-align:center; background-color: var(--gray);' size='1' value='" . $r['userID'] . "'readonly></td>";
                                    ?>
                                </tr>
                                <tr>
                                    <td style="text-align: left; height:60px;">Username</td>
                                    <?php
                                    echo "<td style='text-align: left;'><input type='text' readonly name='userUname' style='text-align:center; background-color: var(--gray);' size='50' value='" . $r['userUname'] . "'></td>";
                                    ?>
                                </tr>
                                <tr>
                                    <td style="text-align: left; height:60px;">Full Name</td>
                                    <?php
                                    echo "<td style='text-align: left;'><input type='text' name='userName' style='text-align:center;' size='50' value='" . $r['userName'] . "'></td>";
                                    ?>
                                </tr>
                                <tr>
                                    <td style="text-align: left; height:60px;">Phone Number</td>
                                    <?php
                                    echo "<td style='text-align: left;'><input type='text' name='userPhone' style='text-align:center;' size='50' value='" . $r['userPhone'] . "'></td>";
                                    ?>
                                </tr>
                                <tr>
                                    <td style="text-align: left; height:60px;">Email</td>
                                    <?php
                                    echo "<td style='text-align: left;'><input type='text' name='userEmail' style='text-align:center;' size='50' value='" . $r['userEmail'] . "'></td>";
                                    ?>
                                </tr>
                                <tr>
                                    <td style="text-align: left; height:60px;">Gender</td>
                                    <td style="text-align: left;">
                                        <?php
                                        if ($r['userGender'] == 1) {
                                            echo "  
                                                    <select name='userGender'>
                                                        <option selected value='1'>Male</option>
                                                        <option value='2'>Female</option>
                                                    </select>";
                                        }
                                        if ($r['userGender'] == 2) {
                                            echo "  
                                                    <select name='userGender'>
                                                        <option value='1'>Male</option>
                                                        <option selected value='2'>Female</option>
                                                    </select>";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; height:60px;">Birthdate</td>
                                    <?php
                                    echo "<td style='text-align: left;'><input type='date' name='userBirthdate' style='text-align:center;' value='" . $r['userBirthdate'] . "'></td>";
                                    ?>
                                </tr>
                                <tr>
                                    <td style="text-align: left; height:60px;">Address</td>
                                    <?php
                                    echo " 
                                            <td style='text-align: left;'>
                                                <textarea type='text' name='userAddress' style='text-align:center;' rows='4' cols='54'>" . $r['userAddress'] . "</textarea>
                                            </td>";
                                    ?>
                                </tr>
                                <tr>
                                    <td style="text-align: left; height:60px;">Action (Save)</td>
                                    <?php
                                    echo "
                                            <td style='text-align: left;'>
                                                <button style='padding: 0; border: none; background: none;' type='submit' name='editDetailsButton'>
                                                    <script src='https://cdn.lordicon.com/xdjxvujz.js'></script>
                                                    <lord-icon
                                                        src='https://cdn.lordicon.com/hjeefwhm.json'
                                                        trigger='loop'
                                                        delay='750'
                                                        colors='primary:#eac143'
                                                        style='width:40px;height:40px'>
                                                    </lord-icon>
                                                </button>
                                            </td>";
                                    ?>
                                </tr>
                            </thead>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- *JS Scripts -->
    <script src="../js/dash.js"></script>
    <script src="../js/script.js"></script>

    <!-- ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <?php
    // Clear results and close the connection
    mysqli_close($con);
    mysqli_free_result($res);
    ?>
</body>

</html>